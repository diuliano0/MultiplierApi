<?php

namespace Modules\Locacao\Models;

use App\Models\BaseModel;
use Modules\Locacao\Enuns\ReservaStatusEnum;

class Horario extends BaseModel
{

    protected $fillable = [
        'filial_id', 'locacao_id', 'dth_inicio', 'dth_fim', 'valor', 'informar_saida', 'hr_ativo_app'
    ];

    public function locacao()
    {
        return $this->belongsTo(Locacao::class, 'locacao_id');
    }

    public function reservas()
    {
        return $this->belongsToMany(Reserva::class, 'horario_reservas', 'horario_id', 'reserva_id');
    }

    public function reservas_ativas()
    {
        return $this->belongsToMany(Reserva::class, 'horario_reservas', 'horario_id', 'reserva_id')
            ->whereIn('reservas.status',[ReservaStatusEnum::PARCIALMENTE_PAGO, ReservaStatusEnum::RESERVADO, ReservaStatusEnum::PAGO]);
    }



}
