<?php

namespace Modules\Locacao\Services;

use Modules\Core\Services\DBService;
use Modules\Locacao\Enuns\ReservaStatusEnum;
use Modules\Locacao\Models\Horario;
use Modules\Locacao\Models\Locador;
use Modules\Locacao\Models\Reserva;
use Modules\Locacao\Presenters\ReservaPresenter;
use Modules\Locacao\Repositories\ReservaRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use mysql_xdevapi\Exception;

class ReservaService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  ReservaRepository
	 */
	private $reservaRepository;
    /**
     * @var HorarioService
     */
    private $horarioService;
    /**
     * @var LocadorService
     */
    private $locadorService;

    public function __construct(
	    ReservaRepository $reservaRepository,
	    LocadorService $locadorService,
        HorarioService $horarioService
    )
	{
		$this->reservaRepository = $reservaRepository;
        $this->horarioService = $horarioService;
        $this->locadorService = $locadorService;
    }

	public function getDefaultRepository()
	{
		return $this->reservaRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}

    public function agendar($horarioId, $locadorId)
    {
        try{
            DBService::beginTransaction();
            /** @var Horario $horario */
            $horario = $this->horarioService->get($horarioId, true);

            /** @var Locador $locador */
            $locador = $this->locadorService->get($locadorId, true);

            if(is_null($horario))
                throw new \Exception('Horário não existe');

            if(is_null($locador))
                throw new \Exception('Locador não existe');

            $reserva = $horario->reservas()->create([
                'horario_id' => $horario->id,
                'valor' => $horario->valor,
                'locador_id' => $locador->id,
                'status' => ReservaStatusEnum::RESERVADO
            ]);
            DBService::commit();
            return self::transformerData($reserva, ReservaPresenter::class);
        }catch (\Exception $exception){
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans());
        }
    }

    public function cancelar($horarioId)
    {
        try{
            DBService::beginTransaction();

            /** @var Reserva $reserva */
            $reserva = $this->get($horarioId, true);

            if(is_null($reserva))
                throw new \Exception('Reserva não existe');

            $reserva->status = ReservaStatusEnum::CANCELADO;
            $reserva->save();
            DBService::commit();
            return self::responseSuccess(self::$HTTP_CODE_OK, 'Reserva cancelada');
        }catch (\Exception $e){
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

}
