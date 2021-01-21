<?php


namespace Modules\Associacao\Repositories;


use Modules\Associacao\Models\Dependente;
use Modules\Associacao\Presenters\DependentePresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class DependenteRepositoryEloquent
 * @package  namespace Modules\Associacao\Repositories;
 */
class DependenteRepositoryEloquent extends BaseRepository implements DependenteRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Dependente::class;
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
		return DependentePresenter::class;
	}
}
