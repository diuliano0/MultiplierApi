<?php


namespace Modules\Associacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Associacao\Models\Carteirinha;

/**
 * Class CarteirinhaTransformer
 * @package  namespace Modules\Associacao\Transformers;
 */
class CarteirinhaTransformer extends TransformerAbstract
{

	protected $availableIncludes = ['trabalhador'];

	/**
	 * Transform the CarteirinhaTransformer entity
	 * @param  Carteirinha $model
	 *
	 * @return  array
	 */
	public function transform(Carteirinha $model)
	{
		return [
			'id' => (int)$model->id,
			'validade' => $model->validade,
			'status' => (boolean)$model->status,
			'url' => $model->url,
		];
	}


	public function includeTrabalhador(Carteirinha $model)
	{
		if (is_null($model->trabalhador)) {
			return null;
		}
		return $this->item($model->pessoa, new TrabalhadorTransformer());
	}
}
