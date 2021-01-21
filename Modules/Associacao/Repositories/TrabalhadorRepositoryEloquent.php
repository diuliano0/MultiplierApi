<?php


namespace Modules\Associacao\Repositories;


use Modules\Associacao\Models\Trabalhador;
use Modules\Associacao\Presenters\TrabalhadorPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class TrabalhadorRepositoryEloquent
 * @package  namespace Modules\Associacao\Repositories;
 */
class TrabalhadorRepositoryEloquent extends BaseRepository implements TrabalhadorRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Trabalhador::class;
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
		return TrabalhadorPresenter::class;
	}
}
