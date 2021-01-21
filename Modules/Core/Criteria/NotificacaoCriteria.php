<?php

namespace Modules\Core\Criteria;

use Illuminate\Http\Request;
use Modules\Core\Models\User;
use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class NotificacaoCriteria
 * @package  Modules\Core\Criteria;
 */
class NotificacaoCriteria extends BaseCriteria
{

    protected $filterCriteria = [];
    private $userId;

    public function __construct(Request $request, $userId)
    {
        parent::__construct($request);
        $this->userId = $userId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = parent::apply($model, $repository);
        return $model->where('notificacoes_id', '=', $this->userId)
                      ->where('notificacoes_type', '=', User::class);
    }

}
