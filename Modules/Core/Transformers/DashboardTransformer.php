<?php


namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Models\Dashboard;

/**
 * Class DashboardTransformer
 * @package  namespace Modules\Core\Transformers;
 */
class DashboardTransformer extends TransformerAbstract
{

	/**
	 * Transform the DashboardTransformer entity
	 * @param  Dashboard $model
	 *
	 * @return  array
	 */
	public function transform(Dashboard $model)
	{
		return [
			'id' => (int)$model->id,
			'grupo_id' => (int)$model->grupo_id,
			'modelos' => $model->modelo(),
		];
	}
}
