<?php

namespace Modules\Core\Criteria;

use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class NewsletterCriteria
 * @package namespace App\Criteria;
 */
class NewsletterCriteria extends BaseCriteria
{
    protected $filterCriteria = [
        'newsletters.nome',
        'newsletters.email',
        'newsletters.plataforma',
    ];
}
