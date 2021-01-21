<?php

namespace Modules\Associacao\Models;

use App\Models\BaseModel;

class Carteirinha extends BaseModel
{

	protected $fillable = [
		"validade", "trabalhador_id", 'status', 'url'
	];


	public function trabalhador()
	{

		return $this->belongsTo(Trabalhador::class, 'trabalhador_id');

	}

}
