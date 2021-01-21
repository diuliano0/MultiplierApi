<?php

namespace Modules\Core\Criteria;

use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;

/**
 * Class UserCriteria
 * @package namespace App\Criteria;
 */
class GrupoCriteria extends BaseCriteria implements CriteriaInterface
{
	protected $filterCriteria = [
		'core.grupos.nome' => 'ilike',
		'core.grupos.status' => '=',
	];
}
