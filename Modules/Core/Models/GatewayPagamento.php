<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;

class GatewayPagamento extends BaseModel {

    protected $fillable = [
        "tipo_gateway",
        "taxa_credito",
        "taxa_debito",
        "iof",
        "cliente_code",
        "token",
        "producao",
        "ativo",
    ];

}
