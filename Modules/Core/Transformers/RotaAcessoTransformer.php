<?php


namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Enuns\AmbienteEnum;
use Modules\Core\Models\RotaAcesso;

/**
 * Class RotaAcessoTransformer
 * @package  namespace Modules\Core\Transformers;
 */
class RotaAcessoTransformer extends TransformerAbstract
{
	protected $availableIncludes = ['filhos'];

	/**
	 * Transform the RotaAcessoTransformer entity
	 * @param  RotaAcesso $model
	 *
	 * @return  array
	 */
	public function transform(RotaAcesso $model)
	{
		return [
			'id' => (int)$model->id,
			"parent_id" => $model->parent_id,
			"modulo" => $model->modulo,
			"titulo" => (string)$model->titulo,
			"rota" => (string)$model->rota,
			"icon" => (string)$model->icon,
			"prioridade" => (integer)$model->prioridade,
			"disabled" => (boolean)$model->disabled,
			"is_menu" => (boolean)$model->is_menu,
			"created_at" => $model->created_at,
			"updated_at" => $model->updated_at,
			"count_filhos" => $model->filhos->count(),
			"ambiente" => (string)$model->ambiente,
			"ambiente_enum" => (new AmbienteEnum($model->ambiente))->toArray(),
		];
	}

	public function includeFilhos(RotaAcesso $model){
		if ($model->filhos->count() == 0) {
			return null;
		}
		return $this->collection($model->filhos, new RotaAcessoTransformer());
	}

}
