<?php


namespace Modules\Core\Repositories;


use Modules\Core\Models\GatewayPagamento;
use Modules\Core\Presenters\GatewayPagamentoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class GatewayPagamentoRepositoryEloquent
 * @package  namespace Modules\Core\Repositories;
 */
class GatewayPagamentoRepositoryEloquent extends BaseRepository implements GatewayPagamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return GatewayPagamento::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
		parent::boot();
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
	{
		return GatewayPagamentoPresenter::class;
	}
}
