<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Modules\Core\Criteria\RotaAcessoCriteria;
use Modules\Core\Enuns\AmbienteEnum;
use Modules\Core\Services\AuthService;
use Modules\Core\Services\RotaAcessoService;
use Modules\Core\Http\Requests\RotaAcessoRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class RotaAcessoController extends BaseController implements ICustomController
{

	/**
	 * @var  RotaAcessoCriteria
	 */
	private $rotaacessoCriteria;

	/**
	 * @var  RotaAcessoService
	 */
	private $rotaacessoService;

	public function __construct(RotaAcessoService $rotaacessoService, RotaAcessoCriteria $rotaacessoCriteria)
	{
		parent::__construct($rotaacessoService->getDefaultRepository(), $rotaacessoCriteria);
		$this->rotaacessoCriteria = $rotaacessoCriteria;
		$this->rotaacessoService = $rotaacessoService;
	}

	public function getValidator()
	{
		return new RotaAcessoRequest();
	}

	public function listaAmbientes()
	{
		return ['data' => array_values(AmbienteEnum::labels())];
	}

	public function rotaByModulo(Request $request){

		//TODO criar request de validação.

		$modulos = $request->get('modulos', []);
		if (count($modulos) == 0)
			throw new \Exception('Modulo(s) enviado(s) não existem');
		$filialId = AuthService::getFilialId();

		return $this->rotaacessoService->getDefaultRepository()->scopeQuery(function ($query) use ($modulos, $filialId){
			return $query
				->whereIn('modulo', $modulos)
				->where('parent_id',null);
		})->all();
	}

	public function destroy($id)
	{
		\Validator::make(['id'=>$id], [
			'id'=>'required|exists:rota_acessos,id'
		])->validate();
		return $this->rotaacessoService->deleteOnCascade($id);
	}


}

