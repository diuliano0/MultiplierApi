<?php


namespace Modules\Locacao\Repositories;


use Modules\Locacao\Models\Locador;
use Modules\Locacao\Presenters\LocadorPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class LocadorRepositoryEloquent
 * @package  namespace Modules\Locacao\Repositories;
 */
class LocadorRepositoryEloquent extends BaseRepository implements LocadorRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Locador::class;
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
		return LocadorPresenter::class;
	}
}
