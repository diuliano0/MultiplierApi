<?php

namespace Modules\Locacao\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Modules\Locacao\Criteria\LocadorCriteria;
use Modules\Locacao\Services\LocadorService;
use Modules\Locacao\Http\Requests\LocadorRequest;
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
		return new LocadorRequest();
	}

	public function store(LocadorRequest $request)
    {
        return $this->locadorService->create($request->getOnlyDataFields());
    }

	public function update(LocadorRequest $request, $id)
    {
        return $this->locadorService->update($request->getOnlyDataFields(), $id);
    }

    public function pesquisar($query){
        return $this->locadorService->pesquisar($query);
    }

}

