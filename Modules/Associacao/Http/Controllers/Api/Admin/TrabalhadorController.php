<?php

namespace Modules\Associacao\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Modules\Associacao\Criteria\TrabalhadorCriteria;
use Modules\Associacao\Services\TrabalhadorService;
use Modules\Associacao\Http\Requests\TrabalhadorRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class TrabalhadorController extends BaseController implements ICustomController
{

	/**
	 * @var  TrabalhadorCriteria
	 */
	private $trabalhadorCriteria;

	/**
	 * @var  TrabalhadorService
	 */
	private $trabalhadorService;

	public function __construct(TrabalhadorService $trabalhadorService, TrabalhadorCriteria $trabalhadorCriteria)
	{
		parent::__construct($trabalhadorService->getDefaultRepository(), $trabalhadorCriteria);
		$this->trabalhadorCriteria = $trabalhadorCriteria;
		$this->trabalhadorService = $trabalhadorService;
	}

	public function getValidator()
	{
		return new TrabalhadorRequest();
	}

	public function store(TrabalhadorRequest $request)
	{
		return $this->trabalhadorService->create($request->getOnlyDataFields());

	}

	public function update(TrabalhadorRequest $request, $id)
	{
		return $this->trabalhadorService->update($request->getOnlyDataFields(), $id);
	}

	public function enviarMsg(Request $request){
        return $this->trabalhadorService->enviarMsg($request->only(['titulo', 'mensagem']));
    }

}

