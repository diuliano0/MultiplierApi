<?php

namespace Modules\Associacao\Services;

use App\Services\UtilService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Associacao\Events\EnviarEmailBeneficioEvent;
use Modules\Associacao\Presenters\TrabalhadorPresenter;
use Modules\Associacao\Repositories\TrabalhadorRepository;
use Modules\Core\Enuns\Grupo;
use Modules\Core\Models\Device;
use Modules\Core\Models\User;
use Modules\Core\Repositories\PessoaRepository;
use Modules\Core\Repositories\UserRepositoryEloquent;
use Modules\Core\Services\DBService;
use Modules\Core\Services\ImageUploadService;
use Modules\Localidade\Services\EnderecoService;
use Modules\Localidade\Services\TelefoneService;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class TrabalhadorService extends BaseService implements IService
{
    use ResponseActions;

    /**
     * @var  TrabalhadorRepository
     */
    private $trabalhadorRepository;

    private $path;
    /**
     * @var ImageUploadService
     */
    private $imageUploadService;

    public function __construct(
        TrabalhadorRepository $trabalhadorRepository,
        ImageUploadService $imageUploadService
    )
    {
        $this->trabalhadorRepository = $trabalhadorRepository;

        $this->path = '/arquivos/img/trabalhador/';
        $this->imageUploadService = $imageUploadService;
    }

    public function getDefaultRepository()
    {
        return $this->trabalhadorRepository;
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

            $trabalhador = $this->getDefaultRepository()->skipPresenter(true)->create($data);

            $pessoa = $trabalhador->pessoa()->create($data['pessoa']);

            $trabalhador->pessoa_id = $pessoa->id;

            if (isset($data['pessoa']['telefones'])) {

                TelefoneService::salvarTelefone($data, $trabalhador);

            }

            if (isset($data['pessoa']['enderecos'])) {

                EnderecoService::salvarEndereco($data, $trabalhador);

            }

            if (isset($data['user'])) {

                /** @var User $user */

                $user = $trabalhador->usuario()->create($data['user']);

                $trabalhador->user_id = $user->id;

                $user->grupos()->attach([Grupo::BENEFICIARIO]);

            }

            if (isset($data['anexo'])) {

                try {

                    $this->createAnexo($trabalhador, $data, $this->path);
                    $this->imageUploadService->cropPhoto('arquivos/img/trabalhador/' . $data['anexo']['conteudo'], array(
                        'width' => 500,
                        'height' => 500,
                        'grayscale' => false
                    ), 'arquivos/img/anuncio/img_230_160_' . $data['anexo']['conteudo']);

                } catch (\Exception $e) {

                    return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

                }

            }
            $trabalhador->update();


            $item = [];
            $carteirinhaService = app(CarteirinhaService::class);
            $carteirinhaService->gerar($trabalhador->id, $item);

            DBService::commit();

            return self::transformerData($trabalhador, TrabalhadorPresenter::class);

        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {

            \DB::rollBack();

            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

        }

    }


    /**
     * @param $data
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($data, $id)

    {

        try {

            DBService::beginTransaction();

            $trabalhador = $this->get($id, true);

            $trabalhador->fill($data);

            $trabalhador->pessoa->update($data['pessoa']);


            if (isset($data['pessoa']['telefones'])) {

                TelefoneService::salvarTelefone($data, $trabalhador);

            }


            if (isset($data['pessoa']['enderecos'])) {

                EnderecoService::salvarEndereco($data, $trabalhador);

            }


            if (isset($data['anexo'])) {

                try {

                    $this->createAnexo($trabalhador, $data, $this->path);
                    $trabalhador = $this->get($id, true);
                    $this->imageUploadService->cropPhoto('arquivos/img/trabalhador/' . $trabalhador->anexo->nome, array(
                        'width' => 500,
                        'height' => 500,
                        'grayscale' => false
                    ), 'arquivos/img/trabalhador/img_230_160_' . $trabalhador->anexo->nome);
                } catch (\Exception $e) {

                    return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

                }

            }


            if (isset($data['user'])) {

                if (is_null($trabalhador->usuario)) {
                    /** @var User $user */

                    $user = $trabalhador->usuario()->create($data['user']);
                    $trabalhador->user_id = $user->id;

                    $user->grupos()->attach([Grupo::TRABALHADOR]);

                } else {


                    $trabalhador->usuario->fill($data['user'])->save();

                }


            }

            $trabalhador->update();


            $item = [];
            $carteirinhaService = app(CarteirinhaService::class);
            $carteirinhaService->gerar($trabalhador->id, $item);

            DBService::commit();

            return self::transformerData($this->get($id, true), TrabalhadorPresenter::class);

        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {

            \DB::rollBack();

            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

        }

    }


    public function perfil($id, $skip = false)
    {
        try {
            $trabalhador = $this->getDefaultRepository()->resetScope()->skipPresenter(true)->findByField('user_id', $id);
            if (!$skip)
                return self::transformerData($trabalhador->first(), TrabalhadorPresenter::class);
            return $trabalhador->first();
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function mudarImagem($id, $data)
    {
        try {
            \DB::beginTransaction();
            $trabalhador = $this->getDefaultRepository()->resetScope()->skipPresenter(true)->findByField('user_id', $id)->first();
            if (isset($data['anexo'])) {
                try {
                    $this->createAnexo($trabalhador, $data, $this->path);
                } catch (\Exception $e) {
                    return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
                }
            }
            \DB::commit();
            return self::responseSuccess(self::$HTTP_CODE_OK, 'Imagem Alterada');
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            \DB::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function importarCsv()
    {
        $filename = public_path('trabalhadores.CSV');
        $delimiter = ';';
        if (!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        $trabalhadorService = $this;
        array_map(function ($item) use ($trabalhadorService) {
            $item['Matricula'] = str_replace('-', '', $item['Matricula']);
            $tabalhador = $trabalhadorService->getDefaultRepository()->skipPresenter(true)->findByField('matricula', $item['Matricula']);
            if ($tabalhador->count() > 0) {
                return;
            }
            //$user = app(UserRepository::class)->skipPresenter(true)->findByField('cpf', mask($item['CPF'],"###.###.###-##"));
            $user = app(UserRepositoryEloquent::class)->resetScope()->skipPresenter(true)->findByField('cpf', $item['CPF']);
            $pessoa = app(PessoaRepository::class)->skipPresenter(true)->findByField('cpf_cnpj', $item['CPF']);

            if ($user->count() == 0) {
                return;
            }

            if ($pessoa->count() == 0) {
                return;
            }
            $dataFiliacao = "2019-07-25 00:00:00";
            if (!is_null($item['data_admissao']) && !empty($item['data_admissao'])) {
                $dataFiliacao = implode('-', array_reverse(explode('/', $item['data_admissao']))) . " 00:00:00";
            }
            $trabalhadorService->getDefaultRepository()->skipPresenter(true)->create([
                "funcao" => $item['Cargo'],
                "matricula" => $item['Matricula'],
                "pessoa_id" => $pessoa->first()->id,
                "user_id" => $user->first()->id,
                "data_filiacao" => $dataFiliacao
            ]);
        }, $data);
    }

    public function enviarEmail($data)
    {
        try {
            event(new EnviarEmailBeneficioEvent($data));
            return self::responseSuccess(self::$HTTP_CODE_OK, 'Email Enviado');
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function enviarSabEmail($data, $userId)
    {
        try {
            $trabalhador = $this->perfil($userId);
            mail_queue([
                //'qimob@qative.com.br' => 'MedBrasil',
                'diuliano0@gmail.com' => 'Atendimento Pro-tocantins',
                //'diuliano0@gmail.com' => 'MedBrasil',
            ],
                'Solicitação de Atendimento - Mensagem SAB',
                'modules.associacao.email.email-beneficio.email-sab-mensagem',
                [
                    'data' => [
                        'msg' => $data['msg'],
                        'trabalhador' => $trabalhador['data']
                    ]
                ]);
            return self::responseSuccess(self::$HTTP_CODE_OK, 'Email Enviado');
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function enviarMsg($data)
    {
        try {
            $devices = Device::all();
            $tokens = array_map(function ($item){
                return $item['token_register'];
            }, $devices->toArray());

            UtilService::FCMPushMulti($tokens, $data['titulo'], $data['mensagem']);
            return self::responseSuccess(self::$HTTP_CODE_OK, 'Notificação Enviado');
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }
}
