<?php

namespace Modules\Core\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Modules\Core\Repositories\RotaAcessoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class RotaAcessoService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  RotaAcessoRepository
	 */
	private $rotaacessoRepository;

	public function __construct(RotaAcessoRepository $rotaacessoRepository)
	{
		$this->rotaacessoRepository = $rotaacessoRepository;
	}

	public function getDefaultRepository()
	{
		return $this->rotaacessoRepository;
	}


	public function deleteOnCascade($id){
		try{
			DBService::beginTransaction();
			$rota = $this->getDefaultRepository()->skipPresenter(true)->find($id);
			$rota->filhos()->delete();
			$rota->delete($id);
			DBService::commit();
			return self::responseSuccess(self::$HTTP_CODE_OK, self::$MSG_REGISTRO_EXCLUIDO);
		}catch (ModelNotFoundException | RepositoryException | \Exception $e) {
			DBService::rollBack();
			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
		}
	}

	public static function montarMenu($rotas, $parent_id = null){
		$array = Arr::where($rotas, function ($value, $key) use ($parent_id) {
			return $value['parent_id'] == $parent_id;
		});
		foreach ($array as $key=>$value)
			$array[$key]['rotas']['data'] =  array_values(self::montarMenu($rotas, $value['id']));
		return $array;
	}

}
