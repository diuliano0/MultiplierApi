<?php


namespace Modules\Core\Models;


use App\Models\BaseModel;

class Filial extends BaseModel
{
	protected $table = "filiais";

	protected $fillable = [
		'pessoa_id',
		'nome_conta',
		'valor_repasse',
		'valor_acrescimo',
		'cobra_convenio',
		'cobra_particular',
		'dia_repasse',
		'cobra_particular',
		'convenios',
		'dia_recebimento_cartao',
	];

	function getConvenios(){
        $this->attributes['convenios'] = ($this->attributes['convenios'])? json_decode($this->attributes['convenios'], true) : null;
    }

	public function pessoa(){
		return $this->belongsTo(Pessoa::class, 'pessoa_id');
	}

	public function anexo(){
		return $this->morphOne(Anexo::class, 'anexotable');
	}

	public function modulos_ativos(){
		return $this->hasMany(ModulosAtivo::class, 'filial_id');
	}

}
