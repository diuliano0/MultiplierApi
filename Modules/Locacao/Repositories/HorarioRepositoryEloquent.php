<?php


namespace Modules\Locacao\Repositories;


use Modules\Locacao\Models\Horario;
use Modules\Locacao\Presenters\HorarioPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class HorarioRepositoryEloquent
 * @package  namespace Modules\Locacao\Repositories;
 */
class HorarioRepositoryEloquent extends BaseRepository implements HorarioRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Horario::class;
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
		return HorarioPresenter::class;
	}
}
