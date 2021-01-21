<?php

namespace Modules\Locacao\Models;

use App\Models\BaseModel;

class Reserva extends BaseModel
{

    protected $fillable = [
        "filial_id", "locador_id", "valor", "motivo_cancelamento", "motivo_cancelamento_texto", "status"
    ];

    public function locador(){
        return $this->belongsTo(Locador::class, 'locador_id');
    }

    public function horario(){
        return $this->belongsToMany(Horario::class, 'horario_reservas', 'reserva_id', 'horario_id');
    }

}
