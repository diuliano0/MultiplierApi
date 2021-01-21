<?php

namespace Modules\Locacao\Http\Controllers\Api\Front;

use Illuminate\Http\Request;
use Modules\Locacao\Criteria\LocadorCriteria;
use Modules\Locacao\Http\Requests\LocadorFrontRequest;
use Modules\Locacao\Http\Requests\LocadorImagemRequest;
use Modules\Locacao\Services\LocadorService;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class LocadorController extends BaseController implements ICustomController
{

	/**
	 * @var  LocadorCriteria
	 */
	private $locadorCriteria;

	/**
	 * @var  LocadorService
	 */
	private $locadorService;

	public function __construct(LocadorService $locadorService, LocadorCriteria $locadorCriteria)
	{
		parent::__construct($locadorService->getDefaultRepository(), $locadorCriteria);
		$this->locadorCriteria = $locadorCriteria;
		$this->locadorService = $locadorService;
	}

	public function getValidator()
	{
		return new LocadorFrontRequest();
	}

	public function store(LocadorFrontRequest $request)
	{
		return $this->locadorService->create($request->getOnlyDataFields());
	}

	public function atualizar(LocadorFrontRequest $request)
	{
		$tabalhador = $this->locadorService->perfil($this->getUserId(), true);
		return $this->locadorService->update($request->getOnlyDataFields(), $tabalhador->id);
	}

	public function mudarImagem(LocadorImagemRequest $request){
		return $this->locadorService->mudarImagem($this->getUserId(), $request->getOnlyDataFields());
	}

	public function perfil(){
		return $this->locadorService->perfil($this->getUserId());
	}

}

