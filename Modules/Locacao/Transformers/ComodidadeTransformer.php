<?php


namespace Modules\Locacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Locacao\Models\Comodidade;

/**
 * Class ComodidadeTransformer
 * @package  namespace Modules\Locacao\Transformers;
 */
class ComodidadeTransformer extends TransformerAbstract
{

	/**
	 * Transform the ComodidadeTransformer entity
	 * @param  Comodidade $model
	 *
	 * @return  array
	 */
	public function transform(Comodidade $model)
	{
		return [
			'id' => (int)$model->id,
			'nome' => $model->nome,
			'icon' => $model->icon,
		];
	}
}
