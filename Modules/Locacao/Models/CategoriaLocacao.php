<?php

namespace Modules\Locacao\Models;

use App\Models\BaseModel;

class CategoriaLocacao extends BaseModel
{

    protected $table = "categoria_locacoes";


    protected $fillable = [
        "nome", "status"
    ];
}
