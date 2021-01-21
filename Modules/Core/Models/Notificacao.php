<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;

class Notificacao extends BaseModel{

    protected $table = "core.notificacoes";


    protected $fillable = [
        'type',
        'data',
        'read_at',
        'type',
        ];
}
