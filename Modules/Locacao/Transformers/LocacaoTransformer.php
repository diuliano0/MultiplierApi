<?php


namespace Modules\Locacao\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Transformers\AnexoTransformer;
use Modules\Locacao\Enuns\LocacaoStatusEnum;
use Modules\Locacao\Models\Locacao;

/**
 * Class LocacaoTransformer
 * @package  namespace Modules\Locacao\Transformers;
 */
class LocacaoTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['anexos'];

    public function transform(Locacao $model)
    {
        return [
            'id' => (int)$model->id,
            "nome" => $model->nome,
            "categoria_locacao_id" => $model->categoria_locacao_id,
            "categoria_locacao_nome" => $model->categoria->nome,
            "capacidade" => $model->capacidade,
            "status" => $model->status,
            "status_label" => (new LocacaoStatusEnum($model->status))->toArray(),
            "descricao" => $model->descricao,
            "valor_locacao" => $model->valor_locacao,
            "custo_operacional" => $model->custo_operacional,
            "comodidades" => $model->comodidade->pluck('id'),
            "url_360" => $model->url_360,
        ];
    }


    public function includeAnexos(Locacao $model)
    {
        if ($model->anexos->count() == 0) {
            return $this->null();
        }
        return $this->collection($model->anexos, new AnexoTransformer());
    }

}
