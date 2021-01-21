<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MensagemFinanceiroRepository;
use App\Models\MensagemFinanceiro;
use App\Validators\MensagemFinanceiroValidator;

/**
 * Class MensagemFinanceiroRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MensagemFinanceiroRepositoryEloquent extends BaseRepository implements MensagemFinanceiroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MensagemFinanceiro::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
