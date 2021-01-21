<?php


namespace Modules\Locacao\Repositories;


use Modules\Locacao\Models\Locacao;
use Modules\Locacao\Presenters\LocacaoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class LocacaoRepositoryEloquent
 * @package  namespace Modules\Locacao\Repositories;
 */
class LocacaoRepositoryEloquent extends BaseRepository implements LocacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Locacao::class;
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
		return LocacaoPresenter::class;
	}
}
