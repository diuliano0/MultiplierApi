<?php


namespace Modules\Associacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Associacao\Models\Noticia;
use Modules\Core\Transformers\AnexoTransformer;

/**
 * Class NoticiaTransformer
 * @package  namespace Modules\Associacao\Transformers;
 */
class NoticiaTransformer extends TransformerAbstract
{

	protected $availableIncludes = ['anexo'];

	/**
	 * Transform the NoticiaTransformer entity
	 * @param  Noticia $model
	 *
	 * @return  array
	 */
	public function transform(Noticia $model)
	{
		return [
			'id' => (int)$model->id,
			'titulo' => (string)$model->titulo,
			'url' => (string)$model->url,
			'chamada' => (string)$model->chamada,
			'status' => (int)$model->status,
		];
	}

	public function includeAnexo(Noticia $model)
	{
		if (is_null($model->anexo)) {
			return null;
		}
		return $this->item($model->anexo, new AnexoTransformer());
	}
}
