<?php


namespace Modules\Locacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Locacao\Enuns\ReservaStatusEnum;
use Modules\Locacao\Models\Horario;

/**
 * Class HorarioTransformer
 * @package  namespace Modules\Locacao\Transformers;
 */
class HorarioTransformer extends TransformerAbstract
{

    public function transform(Horario $model)
    {

        return [
            'id' => (int)$model->id,
            "locacao_id" => $model->locacao_id,
            "dth_inicio" => $model->dth_inicio,
            "dth_fim" => $model->dth_fim,
            "locacao_nome" => $model->locacao->nome,
            "locacao_capacidade" => $model->locacao->capacidade,
            "valor" => $model->valor,
            "possui_reserva" => ($model->reservas_ativas->count() > 0),
            "status_reserva_label" => ($model->reservas_ativas->count() > 0) ? (new ReservaStatusEnum($model->reservas_ativas->first()->status))->toArray() : null,
            "locador_nome" => ($model->reservas_ativas->count() > 0) ? $model->reservas_ativas->first()->locador->pessoa->nome : null,
            "locador_telefone" => (!($model->reservas_ativas->count() > 0) ? null : (($model->reservas_ativas->first()->locador->pessoa->telefones->count() > 0) ? '(' . $model->reservas_ativas->first()->locador->pessoa->telefones->get(0)->ddd . ') ' . $model->reservas_ativas->first()->locador->pessoa->telefones->get(0)->numero : null)),
            "reserva_id" => ($model->reservas_ativas->count() > 0) ? $model->reservas_ativas->first()->id : null,
            'informar_saida' => $model->informar_saida,
            'hr_ativo_app' => $model->hr_ativo_app,
        ];

    }

}
