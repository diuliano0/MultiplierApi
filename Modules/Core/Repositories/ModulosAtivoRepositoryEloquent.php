<?php


namespace Modules\Core\Repositories;


use Modules\Core\Models\ModulosAtivo;
use Modules\Core\Presenters\ModulosAtivoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ModulosAtivoRepositoryEloquent
 * @package  namespace Modules\Core\Repositories;
 */
class ModulosAtivoRepositoryEloquent extends BaseRepository implements ModulosAtivoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return ModulosAtivo::class;
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
		return ModulosAtivoPresenter::class;
	}
}
