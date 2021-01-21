<?php

namespace Modules\Associacao\Http\Controllers\Api\Admin;

use Modules\Associacao\Criteria\DependenteCriteria;
use Modules\Associacao\Services\DependenteService;
use Modules\Associacao\Http\Requests\DependenteRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class DependenteController extends BaseController implements ICustomController
{

	/**
	 * @var  DependenteCriteria
	 */
	private $dependenteCriteria;

	/**
	 * @var  DependenteService
	 */
	private $dependenteService;

	public function __construct(DependenteService $dependenteService, DependenteCriteria $dependenteCriteria)
	{
		parent::__construct($dependenteService->getDefaultRepository(), $dependenteCriteria);
		$this->dependenteCriteria = $dependenteCriteria;
		$this->dependenteService = $dependenteService;
	}

	public function getValidator()
	{
		return new DependenteRequest();
	}

	public function store(DependenteRequest $request)
	{
		return $this->dependenteService->create($request->getOnlyDataFields());

	}

	public function update(DependenteRequest $request, $id)
	{
		return $this->dependenteService->update($request->getOnlyDataFields(), $id);
	}


}

