<?php


namespace Modules\Associacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Associacao\Models\Trabalhador;
use Modules\Core\Transformers\AnexoTransformer;
use Modules\Core\Transformers\PessoaTransformer;
use Modules\Core\Transformers\UserTransformer;

/**
 * Class TrabalhadorTransformer
 * @package  namespace Modules\Associacao\Transformers;
 */
class TrabalhadorTransformer extends TransformerAbstract
{

	protected $availableIncludes = ['pessoa', 'anexo', 'usuario', 'dependentes', 'carteirinha'];

	/**
	 * Transform the TrabalhadorTransformer entity
	 * @param  Trabalhador $model
	 *
	 * @return  array
	 */
	public function transform(Trabalhador $model)
	{
		return [
			'id' => (int)$model->id,
			'matricula' => $model->matricula,
			'funcao' => $model->funcao,
			'data_filiacao' => $model->data_filiacao,
			"nome_trabalhador" => $model->pessoa->nome,
			"email_trabalhador" => $model->pessoa->email,
			"cpf_cnpj" => mask($model->pessoa->cpf_cnpj, '###.###.###-##'),
			"telefone_trabalhador" => (($model->pessoa->telefones->count() > 0) ? '(' . $model->pessoa->telefones->get(0)->ddd . ') ' . $model->pessoa->telefones->get(0)->numero : null),
		];
	}

	public function includeAnexo(Trabalhador $model)
	{
		if (is_null($model->anexo)) {
			return null;
		}
		return $this->item($model->anexo, new AnexoTransformer());
	}


	public function includePessoa(Trabalhador $model)
	{
		if (is_null($model->pessoa)) {
			return null;
		}
		return $this->item($model->pessoa, new PessoaTransformer());
	}

	public function includeDependentes(Trabalhador $model)
	{
		if (is_null($model->dependentes)) {
			return null;
		}
		return $this->collection($model->dependentes, new DependenteTransformer());
	}

	public function includeCarteirinha(Trabalhador $model)
	{
		if (is_null($model->carteirinha)) {
			return null;
		}
		return $this->item($model->carteirinha, new CarteirinhaTransformer());
	}


	public function includeUsuario(Trabalhador $model)

	{

		if (is_null($model->usuario)) {

			return null;

		}

		return $this->item($model->usuario, new UserTransformer());


	}
}
