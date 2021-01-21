<?php


namespace Modules\Associacao\Repositories;


use Modules\Associacao\Models\Carteirinha;
use Modules\Associacao\Presenters\CarteirinhaPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CarteirinhaRepositoryEloquent
 * @package  namespace Modules\Associacao\Repositories;
 */
class CarteirinhaRepositoryEloquent extends BaseRepository implements CarteirinhaRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Carteirinha::class;
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
		return CarteirinhaPresenter::class;
	}
}
