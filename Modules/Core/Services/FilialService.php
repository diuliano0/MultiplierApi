<?php

namespace Modules\Core\Services;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Models\ModulosAtivo;
use Modules\Core\Presenters\FilialPresenter;
use Modules\Core\Repositories\AnexoRepository;
use Modules\Core\Repositories\FilialRepository;
use Modules\Localidade\Models\Endereco;
use Modules\Localidade\Services\EnderecoService;
use Modules\Localidade\Services\TelefoneService;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class FilialService extends BaseService implements IService
{
	use ResponseActions;
	/**
	 * @var FilialRepository
	 */
	private $filialRepository;
	/**
	 * @var AnexoRepository
	 */
	private $anexoRepository;

	private $path;
	/**
	 * @var EnderecoService
	 */
	private $enderecoService;
	/**
	 * @var TelefoneService
	 */
	private $telefoneService;

	public function __construct(
		FilialRepository $filialRepository,
		EnderecoService $enderecoService,
		TelefoneService $telefoneService,
		AnexoRepository $anexoRepository)
	{
		$this->filialRepository = $filialRepository;
		$this->anexoRepository = $anexoRepository;
		$this->path = '/arquivos/img/filial/';
		$this->enderecoService = $enderecoService;
		$this->telefoneService = $telefoneService;
	}

	public function getDefaultRepository()
	{
		return $this->filialRepository;
	}

	public function getFilial(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}

	public function create($data){
		try {
			DBService::beginTransaction();
			$filial = $this->getDefaultRepository()->skipPresenter(true)->create($data);
			$pessoa = $filial->pessoa()->create($data['pessoa']);
			$filial->pessoa_id = $pessoa->id;

			if (isset($data['modulos_ativos'])) {
				$this->salvarModulo($data, $filial);
			}

			if (isset($data['pessoa']['telefones'])) {
				TelefoneService::salvarTelefone($data, $filial);
			}

			if (isset($data['pessoa']['enderecos'])) {
				EnderecoService::salvarEndereco($data, $filial);
			}

			if (isset($data['anexo'])) {
				try {
					$this->createAnexo($filial, $data, $this->path);
				} catch (\Exception $e) {
					return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
				}
			}
			$filial->update();
			DBService::commit();
			return self::transformerData($filial, FilialPresenter::class);
		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {
			\DB::rollBack();
			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
		}
	}

	/**
	 * @param $data
	 * @param null $id
	 */
	public function update($data, $id)
	{
		try {
			DBService::beginTransaction();
			$filial = $this->getFilial($id, true);
			$filial->fill($data);
			$filial->pessoa->update($data['pessoa']);

			if (isset($data['modulos_ativos'])) {
				$this->salvarModulo($data, $filial);
			}

			if (isset($data['pessoa']['telefones'])) {
				TelefoneService::salvarTelefone($data, $filial);
			}

			if (isset($data['pessoa']['enderecos'])) {
				EnderecoService::salvarEndereco($data, $filial);
			}

			if (isset($data['anexo'])) {
				try {
					$this->createAnexo($filial, $data, $this->path);
				} catch (\Exception $e) {
					return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
				}
			}

			$filial->update();
			DBService::commit();
			return self::transformerData($this->getFilial($id, true), FilialPresenter::class);
		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {
			\DB::rollBack();
			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
		}
	}

	private function salvarModulo($data, &$filial){
		$filial->modulos_ativos()->delete();
		array_map(function ($item) use (&$filial) {
			$modulo = new ModulosAtivo();
			$modulo->filial_id = $filial->id;
			$modulo->modulo = $item;
			$filial->modulos_ativos()->save($modulo);
			return $item;
		}, $data['modulos_ativos']);
	}


    public function pesquisar($string)
    {
        try{
            return $this->getDefaultRepository()->scopeQuery(function ($query) use ($string){
                return $query
                    ->join('core.pessoas', 'core.pessoas.id', '=', 'core.filiais.pessoa_id')
                    ->where(function ($query) use ($string){
                        return $query->orWhere('core.pessoas.nome', 'ilike', '%' . $string . '%')
                            ->orWhere('core.pessoas.cpf_cnpj', 'ilike', '%' . $string . '%');
                    })
                    ->select([\DB::raw('DISTINCT filiais.*')])
                    ->limit(25);
            })->all();
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            \DB::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }
}
