<?php


namespace Modules\Associacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Associacao\Models\BannerAssociado;
use Modules\Core\Transformers\AnexoTransformer;

/**
 * Class BannerAssociadoTransformer
 * @package  namespace Modules\Associacao\Transformers;
 */
class BannerAssociadoTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['anexo'];

	/**
	 * Transform the BannerAssociadoTransformer entity
	 * @param  BannerAssociado $model
	 *
	 * @return  array
	 */
	public function transform(BannerAssociado $model)
	{
		return [
			'id' => (int)$model->id,
            "titulo" => $model->titulo,
            "data_limite" => $model->data_limite,
            "prioridade"  => $model->prioridade,
            "status"  => $model->status,
            "url"  => $model->url,
            "created_at"  => $model->created_at,
            "updated_at"  => $model->updated_at,
		];
	}

    public function includeAnexo(BannerAssociado $model)
    {

        if (is_null($model->anexo)) {
            return null;
        }

        return $this->item($model->anexo, new AnexoTransformer());

    }
}
