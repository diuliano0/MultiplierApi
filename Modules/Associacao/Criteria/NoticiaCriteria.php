<?php

namespace Modules\Associacao\Criteria;

use App\Criteria\BaseCriteria;

/**
 * Class NoticiaCriteria
 * @package  Modules\Associacao\Criteria;
 */
class NoticiaCriteria extends BaseCriteria
{
    protected $filterCriteria = [
		'associacao.noticias.chamada' => 'ilike',

		'associacao.noticias.id' => '=',
	];
}
