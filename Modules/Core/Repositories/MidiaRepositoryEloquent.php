<?php


namespace Modules\Core\Repositories;


use Modules\Core\Models\Midia;
use Modules\Core\Presenters\MidiaPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class MidiaRepositoryEloquent
 * @package  namespace Modules\Core\Repositories;
 */
class MidiaRepositoryEloquent extends BaseRepository implements MidiaRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Midia::class;
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
		return MidiaPresenter::class;
	}
}
