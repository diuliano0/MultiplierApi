<?php

namespace Modules\Core\Models;

use Illuminate\Notifications\Notifiable;
use Modules\Localidade\Models\Endereco;
use Modules\Localidade\Models\Telefone;
use Modules\Saude\Models\Beneficiario;
use App\Models\BaseModel;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Pessoa extends BaseModel implements Transformable
{
    use Notifiable, TransformableTrait;

    const PESSOA_FISICA = 'F';
    const PESSOA_JURIDICA = 'J';


	protected $fillable = [
		'nome',
		'email',
		'cpf_cnpj',
		'estado_civil',
		'regime_uniao',
		'data_nascimento',
		'sexo',
		'rg',
		'filiacao_mae',
		'razao_social',
		'inscricao_municipal',
		'inscricao_estadual',
		'data_fundacao',
		'descricao',
	];

	public function setCpfCnpjAttribute($value)
    {
        if ($value)
            $this->attributes['cpf_cnpj'] = preg_replace('([\.\-\/])', '', $value);
    }

    public function tipo(){
        return (validar_cnpj($this->attributes['cpf_cnpj']))?self::PESSOA_JURIDICA:self::PESSOA_FISICA;
    }

    public function usuario(){
    	return $this->hasOne(User::class, 'pessoa_id');
	}

    public function telefones(){
    	return $this->hasMany(Telefone::class, 'pessoa_id');
	}

	public function enderecos(){
		return $this->morphMany(Endereco::class, 'enderecotable');
	}
}
