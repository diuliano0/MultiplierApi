<?php

namespace Modules\Core\Transformers;

use Modules\Core\Enuns\StatusUser;
use Modules\Core\Models\User;
use App\Transformers\BaseTransformer;

/**
 * Class UserTransformer
 * @package namespace Modules\Core\Transformers;
 */
class UserTransformer extends BaseTransformer
{

	public $availableIncludes = [ 'anexo', 'grupos', 'rotas', 'menu'];

	/**
	 * Transform the \User entity
	 * @param \User $model
	 *
	 * @return array
	 */
	public function transform(User $model)
	{
		$result = [
			'id' => (integer)$model->id,
			'username' => (string)$model->username,
			'email' => (string)$model->email,
			'img' => $model->img,
			'cpf' => (string)$model->cpf,
			'nome' => (string)$model->nome,
			'status' => (integer)$model->status,
			'is_admin' => (boolean)$model->is_admin,
			'status_enum' => (new StatusUser($model->status))->toArray(),
		];

		return self::removeNull($result);
	}

	public function includeAnexo(User $model)
	{
		if (is_null($model->anexo)) {
			return null;
		}
		return $this->item($model->anexo, new AnexoTransformer());
	}

	public function includeGrupos(User $model)
	{
		if ($model->grupos->count() == 0) {
			return null;
		}
		return $this->collection($model->grupos, new GrupoTransformer());
	}

	public function includeRotas(User $model)
	{
		$rotas = $model->rotas();
		if ($rotas->count() == 0) {
			return null;
		}
		return $this->collection($rotas, new RotaAcessoTransformer());
	}

	public function includeMenu(User $model)
	{
		$rotas = $model->rotas()
			->where('is_menu','=',true);
		if ($rotas->count() == 0) {
			return null;
		}
		return $this->collection($rotas, new RotaAcessoTransformer());
	}

}
