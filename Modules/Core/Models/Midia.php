<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;

class Midia extends BaseModel{

    protected $table = "tb_midia";


    protected $fillable = [
				"filial_id",
                "nome","bloqueado","categoria","integracao"
    	];
}
