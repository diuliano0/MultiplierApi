<?php

namespace Modules\Locacao\Http\Controllers\Api\Admin;

use Modules\Locacao\Criteria\ReservaCriteria;
use Modules\Locacao\Services\ReservaService;
use Modules\Locacao\Http\Requests\ReservaRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class ReservaController extends BaseController implements ICustomController
{

    /**
     * @var  ReservaCriteria
     */
    private $reservaCriteria;

    /**
     * @var  ReservaService
     */
    private $reservaService;

    public function __construct(ReservaService $reservaService, ReservaCriteria $reservaCriteria)
    {
        parent::__construct($reservaService->getDefaultRepository(), $reservaCriteria);
        $this->reservaCriteria = $reservaCriteria;
        $this->reservaService = $reservaService;
    }

    public function getValidator()
    {
        return new ReservaRequest();
    }

    public function agendar($horarioId, $locadorId)
    {
        return $this->reservaService->agendar($horarioId, $locadorId);
    }

    public function cancelar($horarioId){
        return $this->reservaService->cancelar($horarioId);
    }
}

