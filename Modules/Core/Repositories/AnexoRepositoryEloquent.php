<?php


namespace Modules\Core\Repositories;


use Modules\Core\Models\Anexo;
use Modules\Core\Presenters\AnexoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class AnexoRepositoryEloquent
 * @package  namespace Modules\Core\Repositories;
 */
class AnexoRepositoryEloquent extends BaseRepository implements AnexoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Anexo::class;
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
		return AnexoPresenter::class;
	}
}
