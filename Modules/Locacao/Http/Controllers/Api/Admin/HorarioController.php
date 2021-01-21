<?php

namespace Modules\Locacao\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Modules\Locacao\Criteria\HorarioCriteria;
use Modules\Locacao\Services\HorarioService;
use Modules\Locacao\Http\Requests\HorarioRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class HorarioController extends BaseController implements ICustomController
{

	/**
	 * @var  HorarioCriteria
	 */
	private $horarioCriteria;

	/**
	 * @var  HorarioService
	 */
	private $horarioService;

	public function __construct(HorarioService $horarioService, HorarioCriteria $horarioCriteria)
	{
		parent::__construct($horarioService->getDefaultRepository(), $horarioCriteria);
		$this->horarioCriteria = $horarioCriteria;
		$this->horarioService = $horarioService;
	}

	public function getValidator()
	{
		return new HorarioRequest();
	}

    public function horariosByMesByLocacao($idLocacao, $mes, $ano){
        return $this->horarioService->horariosByMesByLocacao($idLocacao, $mes, $ano);
    }

    public function store(HorarioRequest $request)
    {
        return $this->horarioService->store($request->getOnlyDataFields());
    }

    public function smartStore(HorarioRequest $request){
        return $this->horarioService->smartStore($request->getOnlyDataFields());
    }

    public function destroy($id)
    {
        return $this->horarioService->destroy($id);
    }

}

