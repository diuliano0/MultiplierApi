<?php


namespace Modules\Locacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Transformers\AnexoTransformer;
use Modules\Core\Transformers\PessoaTransformer;
use Modules\Core\Transformers\UserTransformer;
use Modules\Locacao\Models\Locador;

/**
 * Class LocadorTransformer
 * @package  namespace Modules\Locacao\Transformers;
 */
class LocadorTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['pessoa', 'anexo', 'usuario'];

	/**
	 * Transform the LocadorTransformer entity
	 * @param  Locador $model
	 *
	 * @return  array
	 */
	public function transform(Locador $model)
	{
		return [
			'id' => (int)$model->id,
            "user_id" => (int)$model->user_id,
            "pessoa_id" => (int)$model->pessoa_id,
            "nome_locador" => $model->pessoa->nome,
			"email_locador" => $model->pessoa->email,
            "telefone_locador" => (($model->pessoa->telefones->count() > 0) ? '(' . $model->pessoa->telefones->get(0)->ddd . ') ' . $model->pessoa->telefones->get(0)->numero : null),
		];
	}

    public function includeAnexo(Locador $model)
    {
        if (is_null($model->anexo)) {
            return null;
        }
        return $this->item($model->anexo, new AnexoTransformer());
    }

    public function includePessoa(Locador $model)
    {
        if (is_null($model->pessoa)) {
            return null;
        }
        return $this->item($model->pessoa, new PessoaTransformer());
    }

    public function includeUsuario(Locador $model)
    {
        if (is_null($model->usuario)) {
            return null;
        }
        return $this->item($model->usuario, new UserTransformer());

    }
}
