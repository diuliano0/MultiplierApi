<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;

class ModulosAtivo extends BaseModel
{

	public $timestamps = false;

	protected $fillable = [
		"filial_id",
		"modulo"
	];

	protected static function boot()
	{
		parent::boot();
	}
}
