<?php

namespace Modules\Core\Criteria;

use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class RotaAcessoCriteria
 * @package  Modules\Core\Criteria;
 */
class RotaAcessoCriteria extends BaseCriteria
{
    protected $filterCriteria = [
    	'core.rota_acessos.titulo' => 'ilike'
	];

    public function apply($model, RepositoryInterface $repository)
	{
		$model = parent::apply($model, $repository);
		return $model->where('parent_id',null)
			->orderBy('prioridade','ASC');
	}
}
