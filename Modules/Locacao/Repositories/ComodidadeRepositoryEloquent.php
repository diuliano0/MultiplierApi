<?php


namespace Modules\Locacao\Repositories;


use Modules\Locacao\Models\Comodidade;
use Modules\Locacao\Presenters\ComodidadePresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ComodidadeRepositoryEloquent
 * @package  namespace Modules\Locacao\Repositories;
 */
class ComodidadeRepositoryEloquent extends BaseRepository implements ComodidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Comodidade::class;
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
		return ComodidadePresenter::class;
	}
}
