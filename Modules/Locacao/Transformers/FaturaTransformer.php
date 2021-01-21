<?php


namespace Modules\Locacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Locacao\Models\Fatura;

/**
 * Class FaturaTransformer
 * @package  namespace Modules\Locacao\Transformers;
 */
class FaturaTransformer extends TransformerAbstract
{

	/**
	 * Transform the FaturaTransformer entity
	 * @param  Fatura $model
	 *
	 * @return  array
	 */
	public function transform(Fatura $model)
	{
		return [
			'id' => (int)$model->id,
		];
	}
}
