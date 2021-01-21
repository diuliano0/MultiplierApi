<?php

namespace Modules\Core\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Enuns\StatusGrupo;
use Modules\Core\Models\Grupo;

/**
 * Class GrupoTransformer
 * @package namespace App\Transformers;
 */
class GrupoTransformer extends TransformerAbstract
{

	protected $availableIncludes = [
	    'permissoes',
        'rotas',
        "dashboards"
    ];

    /**
     * Transform the Grupo entity
     * @param Grupo $model
     *
     * @return array
     */
    public function transform(Grupo $model)
    {
        return [
            'id'         => (int) $model->id,
			"nome" => (string) $model->nome,
			"descricao" => (string) $model->descricao,
			"status" => (integer) $model->status,
			'status_enum' => (new StatusGrupo($model->status))->toArray(),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];

    }

    public function includePermissoes(Grupo $model){
		if (!$model->permissoes->count() > 0) {
			return null;
		}
		return $this->collection($model->permissoes, new PermissaoTransformer());
	}

    public function includeDashboards(Grupo $model){
		if (!$model->dashboards->count() > 0) {
			return null;
		}
		return $this->collection($model->dashboards, new DashboardTransformer());
	}

    public function includeRotas(Grupo $model){
		if (!$model->rotas->count() > 0) {
			return null;
		}
		return $this->collection($model->rotas, new RotaAcessoTransformer());
	}
}
