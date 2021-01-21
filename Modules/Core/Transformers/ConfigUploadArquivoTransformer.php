<?php


namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Models\ConfigUploadArquivo;

/**
 * Class ConfigUploadArquivoTransformer
 * @package  namespace Modules\Core\Transformers;
 */
class ConfigUploadArquivoTransformer extends TransformerAbstract
{

	public function transform(ConfigUploadArquivo $model)
	{
		return [
			'id' => (int)$model->id,
			'quantidade_maxima_arquivo' => (int)$model->quantidade_maxima_arquivo,
			'tamanho_maximo_arquivo' => (int)$model->tamanho_maximo_arquivo,
			'quantidade_maxima_img' => (int)$model->quantidade_maxima_img,
			'tamanho_maximo_img' => (int)$model->tamanho_maximo_img,
		];
	}
}
