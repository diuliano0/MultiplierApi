<?php

namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Models\Permissao;

/**
 * Class PermissaoTransformer
 * @package namespace App\Transformers;
 */
class PermissaoTransformer extends TransformerAbstract
{

	/**
	 * Transform the Permissao entity
	 * @param Permissao $model
	 *
	 * @return array
	 */
	public function transform(Permissao $model)
	{
		return [
			'id' => (int)$model->id,
			'grupo_id' => (int)$model->grupo_id,
			'modulo' => (int)$model->modulo,
			'id_tb_filial' => (int)$model->id_tb_filial,
			'rotina_modulo' => (string)$model->rotina_modulo,
			'rotina'=> $model->rotina(),
			'created_at' => $model->created_at,
			'updated_at' => $model->updated_at
		];
	}
}
