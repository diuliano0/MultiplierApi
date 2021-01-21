<?php

namespace Modules\Locacao\Http\Controllers\Api\Admin;

use Modules\Locacao\Criteria\FaturaCriteria;
use Modules\Locacao\Services\FaturaService;
use Modules\Locacao\Http\Requests\FaturaRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class FaturaController extends BaseController implements ICustomController
{

	/**
	 * @var  FaturaCriteria
	 */
	private $faturaCriteria;

	/**
	 * @var  FaturaService
	 */
	private $faturaService;

	public function __construct(FaturaService $faturaService, FaturaCriteria $faturaCriteria)
	{
		parent::__construct($faturaService->getDefaultRepository(), $faturaCriteria);
		$this->faturaCriteria = $faturaCriteria;
		$this->faturaService = $faturaService;
	}

	public function getValidator()
	{
		return new FaturaRequest();
	}


}

