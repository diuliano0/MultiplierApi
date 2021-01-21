<?php


namespace Modules\Locacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Locacao\Models\CategoriaLocacao;

/**
 * Class CategoriaLocacaoTransformer
 * @package  namespace Modules\Locacao\Transformers;
 */
class CategoriaLocacaoTransformer extends TransformerAbstract
{

	/**
	 * Transform the CategoriaLocacaoTransformer entity
	 * @param  CategoriaLocacao $model
	 *
	 * @return  array
	 */
	public function transform(CategoriaLocacao $model)
	{
		return [
			'id' => (int)$model->id,
			'nome' => $model->nome,
			'status' => $model->status,
		];
	}
}
