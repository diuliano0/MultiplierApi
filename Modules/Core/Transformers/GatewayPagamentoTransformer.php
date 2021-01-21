<?php


namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Models\GatewayPagamento;

/**
 * Class GatewayPagamentoTransformer
 * @package  namespace Modules\Core\Transformers;
 */
class GatewayPagamentoTransformer extends TransformerAbstract
{

	/**
	 * Transform the GatewayPagamentoTransformer entity
	 * @param  GatewayPagamento $model
	 *
	 * @return  array
	 */
	public function transform(GatewayPagamento $model)
	{
		return [
			'id' => (int)$model->id,
		];
	}
}
