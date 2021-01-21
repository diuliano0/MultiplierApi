<?php


namespace Modules\Core\Repositories;


use Modules\Core\Models\Dashboard;
use Modules\Core\Presenters\DashboardPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class DashboardRepositoryEloquent
 * @package  namespace Modules\Core\Repositories;
 */
class DashboardRepositoryEloquent extends BaseRepository implements DashboardRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Dashboard::class;
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
		return DashboardPresenter::class;
	}
}
