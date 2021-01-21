<?php


namespace Modules\Locacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Locacao\Enuns\ReservaStatusEnum;
use Modules\Locacao\Models\Reserva;

/**
 * Class ReservaTransformer
 * @package  namespace Modules\Locacao\Transformers;
 */
class ReservaTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['horarios'];

    /**
     * Transform the ReservaTransformer entity
     * @param Reserva $model
     *
     * @return  array
     */
    public function transform(Reserva $model)
    {
        return [
            'id' => $model->id,
            "locador_id" => $model->locador_id,
            "locador_nome" => $model->locador->pessoa->nome,
            "valor" => $model->valor,
            "status" => $model->status,
            "motivo_cancelamento" => $model->motivo_cancelamento,
            "motivo_cancelamento_texto" => $model->motivo_cancelamento_texto,
            "status_label" => (new ReservaStatusEnum($model->status))->toArray(),
            "created_at" => $model->created_at,
        ];
    }

    public function includeHorarios(Reserva $model)
    {
        if ($model->horario->count() == 0) {
            return $this->null();
        }
        return $this->collection($model->horario, new HorarioTransformer());
    }
}
