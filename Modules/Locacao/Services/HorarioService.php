<?php

namespace Modules\Locacao\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Services\DBService;
use Modules\Locacao\Models\Horario;
use Modules\Locacao\Repositories\HorarioRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class HorarioService extends BaseService implements IService
{
    use ResponseActions;

    /**
     * @var  HorarioRepository
     */
    private $horarioRepository;

    public function __construct(HorarioRepository $horarioRepository)
    {
        $this->horarioRepository = $horarioRepository;
    }

    public function getDefaultRepository()
    {
        return $this->horarioRepository;
    }

    public function get(int $id = null, bool $presenter = false)
    {
        if (is_null($id))
            return $this->getDefaultRepository()->skipPresenter($presenter)->first();

        return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

    }

    public function horariosByMesByLocacao($idLocacao, $mes, $ano)
    {
        try {
            return $this->horarioRepository->scopeQuery(function ($query) use ($idLocacao, $mes, $ano) {
                if (!is_null($mes)) {
                    $query = $query
                        ->whereMonth('dth_inicio', $mes);
                }
                if (!is_null($mes)) {
                    $query = $query
                        ->whereYear('dth_inicio', $ano);
                }
                return $query;
            })->all();
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function store($data)
    {
        try {
            DBService::beginTransaction();
            /** @var Horario $horario */
            $horario = new Horario();

            if (!isset($data['funcionamento_semanal'])) {
                if (isset($data['horarios']) && count($data['horarios']) > 0) {
                    array_map(function ($item) use ($horario, $data) {
                        $horario->create([
                            'locacao_id' => $data['locacao_id'],
                            'dth_inicio' => $item['dth_inicio'],
                            'dth_fim' => $item['dth_fim'],
                            'valor' => $item['valor'],
                            'informar_saida' => $item['informar_saida'],
                            'hr_ativo_app' => $item['hr_ativo_app'],
                        ]);
                    }, $data['horarios']);
                }
            } else {
                $dataInicial = \Carbon\Carbon::createFromTimestamp(strtotime($data['dth_inicio']));
                $dataFinal = \Carbon\Carbon::createFromTimestamp(strtotime($data['dth_fim']));
                $dias = $dataInicial
                    ->diffInDays($dataFinal);
                for ($i = 0; $i <= (($dias == 0) ? 1 : $dias); $i++) {
                    $aux = \Carbon\Carbon::createFromTimestamp(strtotime($data['dth_inicio']))->addDays($i);
                    $dia_semana = $aux->format('N');

                    if (in_array($dia_semana, $data['funcionamento_semanal']) == false)
                        continue;

                    if (isset($data['horarios']) && count($data['horarios']) > 0) {
                        array_map(function ($item) use ($horario, $data, $i) {
                            $item['dth_inicio'] = \Carbon\Carbon::createFromTimestamp(strtotime($item['dth_inicio']))->addDays($i);
                            $item['dth_fim'] = \Carbon\Carbon::createFromTimestamp(strtotime($item['dth_fim']))->addDays($i);
                            $horario->create([
                                'locacao_id' => $data['locacao_id'],
                                'dth_inicio' => $item['dth_inicio'],
                                'dth_fim' => $item['dth_fim'],
                                'valor' => $item['valor'],
                                'informar_saida' => $item['informar_saida'],
                                'hr_ativo_app' => $item['hr_ativo_app'],
                            ]);
                        }, $data['horarios']);
                    }
                }
            }
            DBService::commit();
            return self::responseSuccess(self::$HTTP_CODE_OK, 'horarios cadastrados');
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function smartStore($data)
    {
        try {
            DBService::beginTransaction();
            $horario = $this->getDefaultRepository()->create($data);
            DBService::commit();
            return $horario;
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function destroy($id)
    {
        try {
            /**
             * @var $horario Horario
             */
            $horario = $this->getDefaultRepository()->skipPresenter(true)->resetScope()->find($id);
            if ($horario->reservas_ativas->count() > 0) {
                return self::responseError(self::$HTTP_CODE_UNPROCESSABLE_ENTITY, "'horario já contem reservas realizadas não pode ser excluído.'");
            }
            $horario->delete();
            return self::responseSuccess(self::$HTTP_CODE_OK, 'horario excluído!');
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

}
