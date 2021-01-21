<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Modules\Core\Criteria\GatewayPagamentoCriteria;
use Modules\Core\Services\GatewayPagamentoService;
use Modules\Core\Http\Requests\GatewayPagamentoRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class GatewayPagamentoController extends BaseController implements ICustomController
{

	/**
	 * @var  GatewayPagamentoCriteria
	 */
	private $gatewaypagamentoCriteria;

	/**
	 * @var  GatewayPagamentoService
	 */
	private $gatewaypagamentoService;

	public function __construct(GatewayPagamentoService $gatewaypagamentoService, GatewayPagamentoCriteria $gatewaypagamentoCriteria)
	{
		parent::__construct($gatewaypagamentoService->getDefaultRepository(), $gatewaypagamentoCriteria);
		$this->gatewaypagamentoCriteria = $gatewaypagamentoCriteria;
		$this->gatewaypagamentoService = $gatewaypagamentoService;
	}

	public function getValidator()
	{
		return new GatewayPagamentoRequest();
	}


}

