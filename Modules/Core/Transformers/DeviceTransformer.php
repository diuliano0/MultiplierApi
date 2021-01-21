<?php


namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Models\Device;

/**
 * Class DeviceTransformer
 * @package  namespace Modules\Core\Transformers;
 */
class DeviceTransformer extends TransformerAbstract
{

	/**
	 * Transform the DeviceTransformer entity
	 * @param  Device $model
	 *
	 * @return  array
	 */
	public function transform(Device $model)
	{
		return [
			'id' => (int)$model->id,
		];
	}
}
