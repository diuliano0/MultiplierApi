<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;

class Anexo extends BaseModel
{
	protected $fillable = [
		"nome",
		"alias",
		"filial_id",
		"diretorio",
		"url",
		"extensao",
		"anexotable_id",
		"anexotable_type",
	];
}
