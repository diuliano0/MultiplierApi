<?php

namespace Modules\Associacao\Http\Controllers\Api\Front;

use Illuminate\Http\Request;
use Modules\Associacao\Criteria\TrabalhadorCriteria;
use Modules\Associacao\Http\Requests\TrabalhadorFrontRequest;
use Modules\Associacao\Http\Requests\TrabalhadorImagemRequest;
use Modules\Associacao\Services\TrabalhadorService;
use Modules\Core\Repositories\PessoaRepository;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Repositories\UserRepositoryEloquent;
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
		return new TrabalhadorFrontRequest();
	}

	public function store(TrabalhadorFrontRequest $request)
	{
		return $this->trabalhadorService->create($request->getOnlyDataFields());
	}

	public function atualizar(TrabalhadorFrontRequest $request)
	{
		$tabalhador = $this->trabalhadorService->perfil($this->getUserId(), true);
		return $this->trabalhadorService->update($request->getOnlyDataFields(), $tabalhador->id);
	}

	public function mudarImagem(TrabalhadorImagemRequest $request){
		return $this->trabalhadorService->mudarImagem($this->getUserId(), $request->getOnlyDataFields());
	}

	public function perfil(){
		return $this->trabalhadorService->perfil($this->getUserId());
	}

	public function teste(){
        return $this->trabalhadorService->importarCsv();
    }

    public function enviarEmail(Request $request){
        return $this->trabalhadorService->enviarEmail($request->all());
    }

    public function enviarSabEmail(Request $request){
        return $this->trabalhadorService->enviarSabEmail($request->only('msg'), $this->getUserId());
    }

}

