<?php

namespace Modules\Locacao\Models;

use App\Models\BaseModel;

class Fatura extends BaseModel{



    protected $fillable = [
            "codigo","meio_pagamento","valor","reserva_id","status","filial_id"
        ];
}
