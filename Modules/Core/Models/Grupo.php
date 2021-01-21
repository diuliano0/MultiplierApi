<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 04/01/2017
 * Time: 11:36
 */

namespace Modules\Core\Models;

use App\Models\BaseModel;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Grupo extends BaseModel implements Transformable
{
    use TransformableTrait;

	public $timestamps = true;

	protected $fillable = [
		"nome",
		"descricao",
		"status"
	];

	public function permissoes(){
		return $this->hasMany(Permissao::class, "grupo_id");
	}

	public function rotas(){
		return $this->belongsToMany(RotaAcesso::class, 'grupo_rota_acessos', 'grupo_id', 'rota_acesso_id');
	}

	public function dashboards(){
        return $this->hasMany(Dashboard::class, "grupo_id");
    }

}
