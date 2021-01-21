<?php


namespace Modules\Locacao\Repositories;


use Modules\Locacao\Models\Fatura;
use Modules\Locacao\Presenters\FaturaPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class FaturaRepositoryEloquent
 * @package  namespace Modules\Locacao\Repositories;
 */
class FaturaRepositoryEloquent extends BaseRepository implements FaturaRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Fatura::class;
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
		return FaturaPresenter::class;
	}
}
