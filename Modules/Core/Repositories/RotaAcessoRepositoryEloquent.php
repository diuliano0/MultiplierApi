<?php


namespace Modules\Core\Repositories;


use Modules\Core\Models\RotaAcesso;
use Modules\Core\Presenters\RotaAcessoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class RotaAcessoRepositoryEloquent
 * @package  namespace Modules\Core\Repositories;
 */
class RotaAcessoRepositoryEloquent extends BaseRepository implements RotaAcessoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return RotaAcesso::class;
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
		return RotaAcessoPresenter::class;
	}
}
