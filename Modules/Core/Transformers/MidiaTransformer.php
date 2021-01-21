<?php


namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Models\Midia;

/**
 * Class MidiaTransformer
 * @package  namespace Modules\Core\Transformers;
 */
class MidiaTransformer extends TransformerAbstract
{

	/**
	 * Transform the MidiaTransformer entity
	 * @param  Midia $model
	 *
	 * @return  array
	 */
	public function transform(Midia $model)
	{
		return [
			'id' => (int)$model->id,
			"nome" => (string)$model->nome,
			"bloqueado" => (boolean)$model->bloqueado,
			"categoria" => (int)$model->categoria,
			"integracao"=> (boolean)$model->integracao,
		];
	}
}
