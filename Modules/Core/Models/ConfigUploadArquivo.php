<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;

class ConfigUploadArquivo extends BaseModel
{
	protected $fillable = [
		"quantidade_maxima_arquivo",
		"tamanho_maximo_arquivo",
		"quantidade_maxima_img",
		"tamanho_maximo_img",
	];
}
