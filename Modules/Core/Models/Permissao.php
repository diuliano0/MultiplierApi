<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;

class Permissao extends BaseModel
{

    protected $fillable = [
    	'grupo_id',
		'rotina',
		'modulo',
		'rotina_modulo',
		'filial_id',
	];

	public function rotina(){
		if(is_null($this->getAttribute('rotina_modulo'))){
			return null;
		}
		$rotinaClass = $this->getAttribute('rotina_modulo');
		return  (new $rotinaClass($this->getAttribute('rotina')))->toArray();
	}

}
