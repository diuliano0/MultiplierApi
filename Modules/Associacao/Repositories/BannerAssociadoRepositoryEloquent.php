<?php


namespace Modules\Associacao\Repositories;


use Modules\Associacao\Models\BannerAssociado;
use Modules\Associacao\Presenters\BannerAssociadoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class BannerAssociadoRepositoryEloquent
 * @package  namespace Modules\Associacao\Repositories;
 */
class BannerAssociadoRepositoryEloquent extends BaseRepository implements BannerAssociadoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return BannerAssociado::class;
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
		return BannerAssociadoPresenter::class;
	}
}
