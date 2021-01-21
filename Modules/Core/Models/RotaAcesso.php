<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;

class RotaAcesso extends BaseModel
{

	protected $fillable = [
		"parent_id",
		"titulo",
		"rota",
		"icon",
		"disabled",
		"ambiente",
		"modulo",
		"prioridade",
		"is_menu"
	];

	public function filhos()
	{
		return $this->hasMany(RotaAcesso::class, 'parent_id')->orderBy('prioridade', 'ASC');
	}

	public function grupos()
	{
		return $this->belongsToMany(Grupo::class, 'grupo_rota_acessos', 'rota_acesso_id', 'grupo_id');
	}
}
