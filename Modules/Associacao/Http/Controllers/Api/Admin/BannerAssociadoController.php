<?php

namespace Modules\Associacao\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Modules\Associacao\Criteria\BannerAssociadoCriteria;
use Modules\Associacao\Services\BannerAssociadoService;
use Modules\Associacao\Http\Requests\BannerAssociadoRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class BannerAssociadoController extends BaseController implements ICustomController
{

	/**
	 * @var  BannerAssociadoCriteria
	 */
	private $bannerassociadoCriteria;

	/**
	 * @var  BannerAssociadoService
	 */
	private $bannerassociadoService;

	public function __construct(BannerAssociadoService $bannerassociadoService, BannerAssociadoCriteria $bannerassociadoCriteria)
	{
		parent::__construct($bannerassociadoService->getDefaultRepository(), $bannerassociadoCriteria);
		$this->bannerassociadoCriteria = $bannerassociadoCriteria;
		$this->bannerassociadoService = $bannerassociadoService;
	}

	public function getValidator()
	{
		return new BannerAssociadoRequest();
	}


	public function store(BannerAssociadoRequest $request)
    {
        return $this->bannerassociadoService->create($request->getOnlyDataFields());
    }

    public function update(BannerAssociadoRequest $request, $id)
    {
        return $this->bannerassociadoService->update($request->getOnlyDataFields(), $id);
    }

}

