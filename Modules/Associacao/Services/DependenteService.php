<?php

namespace Modules\Associacao\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Associacao\Presenters\DependentePresenter;
use Modules\Associacao\Repositories\DependenteRepository;
use Modules\Core\Services\DBService;
use Modules\Localidade\Services\EnderecoService;
use Modules\Localidade\Services\TelefoneService;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class DependenteService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  DependenteRepository
	 */
	private $dependenteRepository;

	private $path;

	public function __construct(DependenteRepository $dependenteRepository)
	{
		$this->dependenteRepository = $dependenteRepository;

		$this->path = '/arquivos/img/dependente/';
	}

	public function getDefaultRepository()
	{
		return $this->dependenteRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}

	public function create($data){

		try{

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

			if (isset($data['anexo'])) {

				try {

					$this->createAnexo($trabalhador, $data, $this->path);

				} catch (\Exception $e) {

					return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

				}

			}

			$trabalhador->update();

			DBService::commit();

			return self::transformerData($trabalhador, DependentePresenter::class);

		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {

			\DB::rollBack();

			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

		}

	}



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

				} catch (\Exception $e) {

					return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

				}

			}




			$trabalhador->update();

			DBService::commit();

			return self::transformerData($this->get($id, true), DependentePresenter::class);

		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {

			\DB::rollBack();

			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

		}

	}

	public function pesquisar($string)
	{

		try{

			return $this->getDefaultRepository()->scopeQuery(function ($query) use ($string){

				return $query

					->join('core.pessoas', 'core.pessoas.id', '=', 'saude.dependentes.pessoa_id')

					->where(function ($query) use ($string){

						return $query->orWhere('core.pessoas.nome', 'ilike', '%' . $string . '%')

							->orWhere('core.pessoas.cpf_cnpj', 'ilike', '%' . $string . '%');

					})

					->select([\DB::raw('DISTINCT dependentes.*')])

					->limit(25);

			})->all();

		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {

			\DB::rollBack();

			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

		}

	}
}
