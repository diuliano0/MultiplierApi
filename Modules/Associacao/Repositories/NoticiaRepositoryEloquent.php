<?php


namespace Modules\Associacao\Repositories;


use Modules\Associacao\Models\Noticia;
use Modules\Associacao\Presenters\NoticiaPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class NoticiaRepositoryEloquent
 * @package  namespace Modules\Associacao\Repositories;
 */
class NoticiaRepositoryEloquent extends BaseRepository implements NoticiaRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Noticia::class;
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
		return NoticiaPresenter::class;
	}
}
