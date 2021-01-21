<?php

namespace Modules\Locacao\Http\Controllers\Api\Admin;

use Modules\Locacao\Criteria\CategoriaLocacaoCriteria;
use Modules\Locacao\Services\CategoriaLocacaoService;
use Modules\Locacao\Http\Requests\CategoriaLocacaoRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class CategoriaLocacaoController extends BaseController implements ICustomController
{

	/**
	 * @var  CategoriaLocacaoCriteria
	 */
	private $categorialocacaoCriteria;

	/**
	 * @var  CategoriaLocacaoService
	 */
	private $categorialocacaoService;

	public function __construct(CategoriaLocacaoService $categorialocacaoService, CategoriaLocacaoCriteria $categorialocacaoCriteria)
	{
		parent::__construct($categorialocacaoService->getDefaultRepository(), $categorialocacaoCriteria);
		$this->categorialocacaoCriteria = $categorialocacaoCriteria;
		$this->categorialocacaoService = $categorialocacaoService;
	}

	public function getValidator()
	{
		return new CategoriaLocacaoRequest();
	}

    public function lista(){
	    return $this->categorialocacaoService->lista();
    }
}

