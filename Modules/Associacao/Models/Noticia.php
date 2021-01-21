<?php

namespace Modules\Associacao\Models;

use Modules\Core\Models\Anexo;
use App\Models\BaseModel;

class Noticia extends BaseModel
{


	protected $fillable = [
		"titulo", "chamada", "status", "url"
	];

	public function anexo(){
		return $this->morphOne(Anexo::class, 'anexotable');
	}
}
