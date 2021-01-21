<?php


namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Enuns\Modulo;
use Modules\Core\Models\ModulosAtivo;

/**
 * Class ModulosAtivoTransformer
 * @package  namespace Modules\Core\Transformers;
 */
class ModulosAtivoTransformer extends TransformerAbstract
{

	/**
	 * Transform the ModulosAtivoTransformer entity
	 * @param  ModulosAtivo $model
	 *
	 * @return  array
	 */
	public function transform(ModulosAtivo $model)
	{
		return [
			'id' => (int)$model->id,
			"filial_id" => (int)$model->filial_id,
			"modulo" => (int)$model->modulo,
			"modulo_enum" => (new Modulo($model->modulo))->toArray(),
		];
	}
}
