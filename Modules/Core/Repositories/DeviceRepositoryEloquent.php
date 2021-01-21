<?php


namespace Modules\Core\Repositories;


use Modules\Core\Models\Device;
use Modules\Core\Presenters\DevicePresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class DeviceRepositoryEloquent
 * @package  namespace Modules\Core\Repositories;
 */
class DeviceRepositoryEloquent extends BaseRepository implements DeviceRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Device::class;
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
		return DevicePresenter::class;
	}
}
