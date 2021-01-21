<?php

namespace Modules\Associacao\Models;

use Modules\Core\Models\Anexo;
use Modules\Core\Models\Pessoa;
use Modules\Core\Models\User;
use App\Models\BaseModel;

class Trabalhador extends BaseModel
{
	protected $table = 'trabalhadores';

    protected $fillable = [
        "funcao", "matricula", "pessoa_id", "user_id", "data_filiacao"
    ];

	public function pessoa(){

		return $this->belongsTo(Pessoa::class, 'pessoa_id');

	}

	public function usuario(){

		return $this->belongsTo(User::class, 'user_id');

	}

	public function dependentes(){

		return $this->hasMany(Dependente::class, 'trabalhador_id');

	}

	public function carteirinha(){

		return $this->hasOne(Carteirinha::class, 'trabalhador_id');

	}



	public function anexo(){

		return $this->morphOne(Anexo::class, 'anexotable');

	}
}
