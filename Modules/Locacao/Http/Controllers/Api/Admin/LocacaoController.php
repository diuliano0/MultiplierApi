<?php

namespace Modules\Locacao\Http\Controllers\Api\Admin;

use Modules\Locacao\Criteria\LocacaoCriteria;
use Modules\Locacao\Http\Requests\LocacaoImageRequest;
use Modules\Locacao\Services\ComodidadeService;
use Modules\Locacao\Services\LocacaoService;
use Modules\Locacao\Http\Requests\LocacaoRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class LocacaoController extends BaseController implements ICustomController
{

	/**
	 * @var  LocacaoCriteria
	 */
	private $locacaoCriteria;

	/**
	 * @var  LocacaoService
	 */
	private $locacaoService;
    /**
     * @var ComodidadeService
     */
    private $comodidadeService;

    public function __construct(
	    LocacaoService $locacaoService,
        ComodidadeService $comodidadeService,
        LocacaoCriteria $locacaoCriteria)
	{
		parent::__construct($locacaoService->getDefaultRepository(), $locacaoCriteria);
		$this->locacaoCriteria = $locacaoCriteria;
		$this->locacaoService = $locacaoService;
        $this->comodidadeService = $comodidadeService;
    }

	public function getValidator()
	{
		return new LocacaoRequest();
	}

	public function store(LocacaoRequest $locacaoRequest){
        return $this->locacaoService->store($locacaoRequest->getOnlyDataFields());
    }

	public function update($id, LocacaoRequest $locacaoRequest){
        return $this->locacaoService->update($id, $locacaoRequest->getOnlyDataFields());
    }

	public function addImage($id, LocacaoRequest $locacaoRequest){
        return $this->locacaoService->addImage($id, $locacaoRequest->getOnlyDataFields());
    }
	public function listaLocacoes(){
        return $this->locacaoService->listaLocacoes();
    }

	public function removeImage($id){
        return $this->locacaoService->removeImage($id);
    }

    public function listaComodidade(){
        return $this->comodidadeService->getDefaultRepository()->all();
    }

}
