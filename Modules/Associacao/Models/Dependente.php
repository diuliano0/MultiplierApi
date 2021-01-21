<?php

namespace Modules\Associacao\Models;

use Modules\Core\Models\Anexo;
use Modules\Core\Models\Pessoa;
use App\Models\BaseModel;

class Dependente extends BaseModel
{

	protected $fillable = [
		"trabalhador_id", "pessoa_id", "anexo"
	];

	public function trabalhador()
	{

		return $this->belongsTo(Trabalhador::class, 'trabalhador_id');

	}

	public function pessoa()
	{

		return $this->belongsTo(Pessoa::class, 'pessoa_id');

	}

	public function anexo(){

		return $this->morphOne(Anexo::class, 'anexotable');

	}
}
