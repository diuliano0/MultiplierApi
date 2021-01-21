<?php

namespace Modules\Associacao\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Associacao\Presenters\CarteirinhaPresenter;
use Modules\Associacao\Repositories\CarteirinhaRepository;
use Modules\Core\Presenters\AnexoPresenter;
use Modules\Core\Services\DBService;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class CarteirinhaService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  CarteirinhaRepository
	 */
	private $carteirinhaRepository;
	/**
	 * @var TrabalhadorService
	 */
	private $trabalhadorService;

	public function __construct(
		CarteirinhaRepository $carteirinhaRepository,
		TrabalhadorService $trabalhadorService
	)
	{
		$this->carteirinhaRepository = $carteirinhaRepository;
		$this->trabalhadorService = $trabalhadorService;
	}

	public function getDefaultRepository()
	{
		return $this->carteirinhaRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);
	}

	public function create($data)
	{

		try {

			DBService::beginTransaction();
			$data['validade'] = Carbon::now()->addDays(30);
			$data['status'] = true;

			$carteirinha = $this->getDefaultRepository()->create($data);
			DBService::commit();

			return $carteirinha;

		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {

			\DB::rollBack();

			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

		}

	}

	public function gerar($id, $data)
	{

		try {

			DBService::beginTransaction();
			$data['validade'] = Carbon::now()->addYear(1);
			$data['status'] = true;
			$data['trabalhador_id'] = $id;
			$trabalhador = $this->trabalhadorService->getDefaultRepository()->skipPresenter(true)->find($id);

			$url = null;
			if(!is_null($trabalhador->anexo)){
				$anexo = self::transformerData($trabalhador->anexo, AnexoPresenter::class);
				$url = count($anexo['data']) > 0 ? public_path($anexo['data']['diretorio'] . 'img_230_160_'.$anexo['data']['nome']) : null;
			}

            $nomeArquivo = null;
			if(!is_null($trabalhador->carteirinha)){
				$nomeArquivo = $trabalhador->carteirinha->url;
			}

			$cpf = is_null($trabalhador->pessoa->cpf_cnpj)? null: mask($trabalhador->pessoa->cpf_cnpj, '###.###.###-##');

			$data['url'] = $this->gerarCarteirinha($trabalhador->pessoa->nome, $trabalhador->matricula, $trabalhador->funcao, $trabalhador->pessoa->rg, $cpf, $url, $nomeArquivo);
			if(is_null($nomeArquivo)){
                $carteirinha = $this->getDefaultRepository()->create($data);
            }else{
                $carteirinha = self::transformerData($trabalhador->carteirinha, CarteirinhaPresenter::class);
            }

			DBService::commit();

			return $carteirinha;

		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {

			\DB::rollBack();

			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

		}

	}


	public function update($data, $id)

	{

		try {

			DBService::beginTransaction();

			$carteirinha = $this->get($id, true);

			$carteirinha->fill($data);

			$carteirinha->update();

			DBService::commit();

			return self::transformerData($this->get($id, true), CarteirinhaPresenter::class);

		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {

			\DB::rollBack();

			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

		}

	}


	public function gerarCarteirinha($nome, $matricula, $cargo, $rg, $cpf, $foto = null, $nomeArquivo = null)
	{
		if (is_null($foto))
			$foto = public_path('img/carteirinha/photo.jpg');

		// Carregar imagem já existente no servidor
		$imagem = imagecreatefrompng(public_path('img/carteirinha/carteirinha_apra_limpa.png'));
		list($img_width,$img_height) = getimagesize($foto);
		$src = imagecreatefromjpeg($foto);

		\QrCode::size(500)
			->format('png')
			->generate('152441253', public_path('img/carteirinha/qrcode.png'));
		$cateirinha = imagecreatefrompng(public_path('img/carteirinha/qrcode.png'));

		/* @Parametros
		 * "foto.jpg" - Caminho relativo ou absoluto da imagem a ser carregada.
		 */

		// Cor de saída
		$cor = imagecolorallocate($imagem, 0, 0, 0);
		/* @Parametros
		 * $imagem - Imagem previamente criada Usei imagecreatefromjpeg
		 * 255 - Cor vermelha ( RGB )
		 * 255 - Cor verde ( RGB )
		 * 255 - Cor azul ( RGB )
		 * -- No caso acima é branco
		 */

		// Texto que será escrito na imagem
		$nome = urldecode($nome);
		/* @Parametros
		 * $_GET['nome'] - Texto que será escrito
		 */

		// Escrever nome

		imagettftext($imagem, 35, 0, 50, 430, $cor, public_path('fonts/MYRIADPRO-REGULAR.OTF'), $nome);
		imagettftext($imagem, 20, 0, 50, 470, $cor, public_path('fonts/MYRIADPRO-REGULAR.OTF'), $cargo);
		imagettftext($imagem, 22, 0, 93, 528, $cor, public_path('fonts/MYRIADPRO-REGULAR.OTF'), $rg);
		imagettftext($imagem, 22, 0, 105, 571, $cor, public_path('fonts/MYRIADPRO-REGULAR.OTF'), $cpf);
		imagettftext($imagem, 22, 0, 168, 616, $cor, public_path('fonts/MYRIADPRO-REGULAR.OTF'), $matricula);

		imagecopyresampled($imagem, $src, 48, 157, 0, 0,  214,218, $img_width, $img_height);
		imagecopyresampled($imagem, $cateirinha, 730, 370, 0, 0, 300,300, 26, 26);
		/* @Parametros
		 * $imagem - Imagem previamente criada Usei imagecreatefromjpeg
		 * 5 - tamanho da fonte. Valores de 1 a 5
		 * 15 - Posição X do texto na imagem
		 * 515 - Posição Y do texto na imagem
		 * $nome - Texto que será escrito
		 * $cor - Cor criada pelo imagecolorallocate
		 */
		//file_put_contents(public_path('img/teste/'), $imagem);
		// Header informando que é uma imagem JPEG
		header('Content-type: image/jpeg');
		$imagem_nova = 'img/carteirinha/' . md5(time() . uniqid(rand(), true)) . '.jpg';
		// eEnvia a imagem para o borwser ou arquivo
		imagejpeg($imagem, public_path(is_null($nomeArquivo)?$imagem_nova:$nomeArquivo), 100);
		//imagejpeg($imagem, null, 100);
		/* @Parametros
		 * $imagem - Imagem previamente criada Usei imagecreatefromjpeg
		 * NULL - O caminho para salvar o arquivo.
		 * Se não definido NULL a imagem será mostrado no browser.
		 * 80 - Qualidade da compresão da imagem.
		 */

		return $imagem_nova;
	}

    public function atualizarTodas()
    {

            $trabalhador = $this->trabalhadorService->getDefaultRepository()->skipPresenter(true)->all();
            $idError = null;
            $trabalhador->each(function ($trab) use ($idError)
            {
                if(is_null($trab->carteirinha))
                {
                    $data['validade'] = Carbon::now()->addYear(1);
                    $data['status'] = true;
                    $data['trabalhador_id'] = $trab->id;

                    $url = null;
                    if(!is_null($trab->anexo)){
                        $anexo = self::transformerData($trab->anexo, AnexoPresenter::class);
                        $url = count($anexo['data']) > 0 ? public_path($anexo['data']['diretorio'] . 'img_230_160_'.$anexo['data']['nome']) : null;
                    }
                    if(is_null($trab->pessoa))
                    {
                        dd($trab);
                    }
                    $cpf = is_null($trab->pessoa->cpf_cnpj)? null: mask($trab->pessoa->cpf_cnpj, '###.###.###-##');
                    $data['url'] = $this->gerarCarteirinha($trab->pessoa->nome, $trab->matricula, $trab->funcao, $trab->pessoa->rg, $cpf, $url);
                    $carteirinha = $this->getDefaultRepository()->create($data);
                }
            });
            die;
    }
}
