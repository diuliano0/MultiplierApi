<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Criteria\FilialCriteria;
use Modules\Core\Enuns\Modulo;
use Modules\Core\Http\Requests\FilialRequest;
use Modules\Core\Repositories\FilialRepository;
use Modules\Core\Services\DBService;
use Modules\Core\Services\FilialService;
use App\Criteria\OrderCriteria;
use App\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

class CoreController extends BaseController
{


	/**
	 * @var FilialService
	 */
	private $filialService;

	/**
	 * @var FilialCriteria
	 */
	private $filialCriteria;

	public function __construct(FilialService $filialService, FilialCriteria $filialCriteria)
	{
		parent::__construct($filialService->getDefaultRepository(), $filialCriteria);
		$this->filialService = $filialService;
		$this->filialCriteria = $filialCriteria;
	}

	public function getValidator($id = null)
	{
		return [];
	}

	public function filial()
	{
		return $this->filialService->getFilial();
	}

	public function atualizarFilial(FilialRequest $filialRequest)
	{
		return $this->filialService->update($filialRequest->getOnlyDataFields(), null);
	}


	public function listaModulos()
	{
		return ['data' => array_values(Modulo::labels())];
	}

}
