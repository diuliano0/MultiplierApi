<?php

namespace Modules\Core\Models;

use Closure;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Modules\Core\Traits\InsertFilialTrait;
use OwenIt\Auditing\Contracts\UserResolver;
use App\Notifications\PasswordReset;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use OwenIt\Auditing\Contracts\Auditable as IAuditable;
use OwenIt\Auditing\Auditable;

class User extends Authenticatable implements Transformable, IAuditable
{
	use Notifiable, HasApiTokens, TransformableTrait, Auditable, InsertFilialTrait;

	/**
	 * {@inheritdoc}
	 */
	public static function resolveId()
	{
		return \Auth::check() ? \Auth::user()->getAuthIdentifier() : null;
	}

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'username',
		'password',
		'email',
		'img',
		'nome',
		'cpf',
		'status',
	];

	protected static function boot()
	{
		parent::boot();
		static::created(function ($query){
            if(!is_null(\Modules\Core\Services\AuthService::getFilialId()) && !empty(\Modules\Core\Services\AuthService::getFilialId())){
				$query->filiais()->attach(\Modules\Core\Services\AuthService::getFilialId());
			}
			return $query;
		});
		static::updating(function ($query){
            if(!is_null(\Modules\Core\Services\AuthService::getFilialId()) && !empty(\Modules\Core\Services\AuthService::getFilialId())){
				$array = array_merge([\Modules\Core\Services\AuthService::getFilialId()],array_column($query->filiais->toArray(), 'id'));
				$query->filiais()->sync($array);
			}
			return $query;
		});
	}

	protected $casts = [
		'status' => 'integer',
	];

	public function findForPassport($username)
	{
		$return = $this->where('username', $username)->first();
		if(is_null($return)){
			return false;
		}

		return $return;
	}

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new PasswordReset($token));
	}

	public  function setPasswordAttribute($value)
    {
		$this->attributes['password'] = bcrypt($value);
	}

	public function anexo(){
		return $this->morphOne(Anexo::class, 'anexotable');
	}

	public function notificacaoes(){
		return $this->morphMany(Notificacao::class, 'notificacoes');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function grupos(){
		return $this->belongsToMany(Grupo::class, 'usuario_grupos', 'user_id', 'grupo_id');
	}

	public function filiais(){
		return $this->belongsToMany(Filial::class, 'user_filiais', 'user_id', 'filial_id');
	}

	public function rotas(){
		return RotaAcesso::query()
			->join('grupo_rota_acessos' ,'rota_acessos.id', '=','grupo_rota_acessos.rota_acesso_id')
			->join('grupos' ,'grupo_rota_acessos.grupo_id', '=','grupos.id')
			->join('usuario_grupos' ,'grupos.id', '=','usuario_grupos.grupo_id')
			->join('users' ,'usuario_grupos.user_id', '=','users.id')
			->where('users.id','=', $this->attributes['id'])
			->orderBy('prioridade', 'asc')
			->orderBy('titulo', 'asc')
			->select([\DB::raw('DISTINCT rota_acessos.*')])
			->get();
	}

	public function devices(){
	    return $this->hasMany(Device::class, 'user_id');
    }

}
