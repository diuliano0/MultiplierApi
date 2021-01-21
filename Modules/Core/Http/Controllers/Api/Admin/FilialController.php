<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Modules\Core\Criteria\FilialCriteria;
use Modules\Core\Services\FilialService;
use Modules\Core\Http\Requests\FilialRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;
use App\Services\UtilService;

class FilialController extends BaseController implements ICustomController
{

	/**
	 * @var  FilialCriteria
	 */
	private $filialCriteria;

	/**
	 * @var  FilialService
	 */
	private $filialService;

	public function __construct(FilialService $filialService, FilialCriteria $filialCriteria)
	{
		parent::__construct($filialService->getDefaultRepository(), $filialCriteria);
		$this->filialCriteria = $filialCriteria;
		$this->filialService = $filialService;
	}

	public function getValidator()
	{
		return new FilialRequest();
	}

	public function store(FilialRequest $request){
		return $this->filialService->create($request->getOnlyDataFields());
	}

	public function update(FilialRequest $request, $id){
		return $this->filialService->update($request->getOnlyDataFields(), $id);
	}

    public function pesquisar($query){
        return $this->filialService->pesquisar($query);
    }
}

