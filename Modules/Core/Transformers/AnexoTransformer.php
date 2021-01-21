<?php


namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Models\Anexo;
use App\Services\BaseStorageService;

/**
 * Class AnexoTransformer
 * @package  namespace Modules\Core\Transformers;
 */
class AnexoTransformer extends TransformerAbstract
{

	/**
	 * @var BaseStorageService
	 */
	private $baseStorageService;

	public function __construct()
	{
		$this->baseStorageService = app(BaseStorageService::class);
	}

	/**
	 * Transform the AnexoTransformer entity
	 * @param  Anexo $model
	 *
	 * @return  array
	 */
	public function transform(Anexo $model)
	{
		return [
			'id' => (int)$model->id,
			'nome' => (string)$model->nome,
			'alias' => (string)$model->alias,
			'diretorio' => (string)$model->diretorio,
			'url' => (string) get_ip_address() . $model->diretorio . $model->nome,
			'url_thumb' => (string) get_ip_address(). $model->diretorio . 'img_230_160_'.$model->nome,
			'extensao' => (string)$model->extensao,
			'created_at' => $model->created_at,
			'updated_at' => $model->updated_at,
		];
	}
}
