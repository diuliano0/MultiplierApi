<?php


namespace Modules\Core\Transformers;


use League\Fractal\TransformerAbstract;
use Modules\Core\Models\Filial;

/**
 * Class GrupoTransformer
 * @package namespace App\Transformers;
 */
class FilialTransformer extends TransformerAbstract
{

	public $availableIncludes = ['pessoa','anexo','modulos_ativos'];

    /**
     * Transform the Filial entity
     * @param Filial $model
     *
     * @return array
     */
    public function transform(Filial $model)
    {
        return [
            'id'         => (int) $model->id,
			'pessoa_id'=> (int) $model->pessoa_id,
			'nome_conta'=> (string) $model->nome_conta,
			'valor_repasse'=> (double) $model->valor_repasse,
			'valor_acrescimo'=> (double) $model->valor_acrescimo,
			'cobra_convenio'=> (boolean) $model->cobra_convenio,
			'cobra_particular'=> (boolean) $model->cobra_particular,
			'dia_repasse'=>  $model->dia_repasse,
			'convenios'=>  $model->convenios,
			'dia_recebimento_cartao'=> (int) $model->dia_recebimento_cartao,
			"nome_filial" => $model->pessoa->nome,
			"email_filial" => $model->pessoa->email,
			"telefone_filial" => (($model->pessoa->telefones->count() > 0) ? '(' . $model->pessoa->telefones->get(0)->ddd . ') ' . $model->pessoa->telefones->get(0)->numero : null),
        ];
    }

	public function includePessoa(Filial $model)
	{
		if (is_null($model->pessoa)) {
			return null;
		}
		return $this->item($model->pessoa, new PessoaTransformer());
	}

	public function includeAnexo(Filial $model)
	{
		if (is_null($model->anexo)) {
			return null;
		}
		return $this->item($model->anexo, new AnexoTransformer());
	}

	public function includeModulosAtivos(Filial $model)
	{
		if ($model->modulos_ativos->count() == 0) {
			return null;
		}
		return $this->collection($model->modulos_ativos, new ModulosAtivoTransformer());
	}

}
