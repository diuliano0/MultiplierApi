<?php


namespace Modules\Locacao\Repositories;


use Modules\Locacao\Models\Reserva;
use Modules\Locacao\Presenters\ReservaPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ReservaRepositoryEloquent
 * @package  namespace Modules\Locacao\Repositories;
 */
class ReservaRepositoryEloquent extends BaseRepository implements ReservaRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Reserva::class;
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
		return ReservaPresenter::class;
	}
}
