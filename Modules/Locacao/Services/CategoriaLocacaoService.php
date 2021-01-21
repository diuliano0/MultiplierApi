<?php

namespace Modules\Locacao\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Locacao\Repositories\CategoriaLocacaoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class CategoriaLocacaoService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  CategoriaLocacaoRepository
	 */
	private $categorialocacaoRepository;

	public function __construct(CategoriaLocacaoRepository $categorialocacaoRepository)
	{
		$this->categorialocacaoRepository = $categorialocacaoRepository;
	}

	public function getDefaultRepository()
	{
		return $this->categorialocacaoRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}

    public function lista(){
        try {
            return $this->getDefaultRepository()->scopeQuery(function ($query){
                return $query
                    ->where('status', true)
                    ->orderBy('nome', 'ASC');
            })->all();
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }
}
