<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Criteria\GrupoCriteria;
use Modules\Core\Http\Requests\GrupoRequest;
use Modules\Core\Repositories\GrupoRepository;
use Modules\Core\Services\DashboardService;
use Modules\Core\Services\GrupoService;
use Modules\Saude\Enuns\DashBoardModeloSaudeEnum;
use App\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

class GrupoController extends BaseController
{

	/**
	 * @var GrupoService
	 */
	private $grupoService;

	public function __construct(GrupoService $grupoService)
	{
		parent::__construct($grupoService->getDefaultRepository(), GrupoCriteria::class);
		$this->grupoService = $grupoService;
	}

	public function getValidator(){
		return new GrupoRequest();
	}

	public function update(GrupoRequest $grupoRequest, $id){
		return $this->grupoService->update($grupoRequest->getOnlyDataFields(), $id);
	}

	public function store(GrupoRequest $grupoRequest){
		return $this->grupoService->create($grupoRequest->getOnlyDataFields());
	}

	public function ativarDesativar($id){
		try{
			$this->grupoService->getDefaultRepository()->ativarDesativar($id);
			return self::responseSuccess(self::HTTP_CODE_OK, "Grupo alterado com sucesso!");
		}catch (ModelNotFoundException | RepositoryException | \Exception $e) {
			\DB::rollBack();
			return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
		}
	}

	public function selectGrupo(){
		return $this->grupoService->getDefaultRepository()->all();
	}

	public function destroy($id)
	{
		\Validator::make(['id'=>$id], [
			'id'=>'required|exists:grupos,id'
		])->validate();
		return $this->grupoService->deleteOnCascade($id);
	}

	public function listDashBoard(){
	    return ["data" =>DashboardService::listDashborads()];
    }



}
