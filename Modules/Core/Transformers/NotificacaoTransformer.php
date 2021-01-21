<?php


namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Models\Notificacao;

/**
 * Class NotificacaoTransformer
 * @package  namespace Modules\Core\Transformers;
 */
class NotificacaoTransformer extends TransformerAbstract
{

	/**
	 * Transform the NotificacaoTransformer entity
	 * @param  Notificacao $model
	 *
	 * @return  array
	 */
	public function transform(Notificacao $model)
	{
		return [
			'id' => (int)$model->id,
			'data' => json_decode($model->data, true),
            'read_at' => $model->read_at,
            'type' => $model->type,
		];
	}
}
