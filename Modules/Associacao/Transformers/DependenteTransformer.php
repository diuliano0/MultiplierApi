<?php


namespace Modules\Associacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Associacao\Models\Dependente;
use Modules\Core\Transformers\AnexoTransformer;
use Modules\Core\Transformers\PessoaTransformer;

/**
 * Class DependenteTransformer
 * @package  namespace Modules\Associacao\Transformers;
 */
class DependenteTransformer extends TransformerAbstract
{
	protected $availableIncludes = ['pessoa', 'anexo'];
	/**
	 * Transform the DependenteTransformer entity
	 * @param  Dependente $model
	 *
	 * @return  array
	 */
	public function transform(Dependente $model)
	{
		return [
			'id' => (int)$model->id,
			'trabalhador_id' => (int)$model->trabalhador_id,
		];
	}

	public function includeAnexo(Dependente $model)
	{
		if (is_null($model->anexo)) {
			return null;
		}
		return $this->item($model->anexo, new AnexoTransformer());
	}



	public function includePessoa(Dependente $model)
	{
		if (is_null($model->pessoa)) {
			return null;
		}
		return $this->item($model->pessoa, new PessoaTransformer());
	}
}
