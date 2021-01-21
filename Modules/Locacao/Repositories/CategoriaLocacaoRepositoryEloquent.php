<?php


namespace Modules\Locacao\Repositories;


use Modules\Locacao\Models\CategoriaLocacao;
use Modules\Locacao\Presenters\CategoriaLocacaoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CategoriaLocacaoRepositoryEloquent
 * @package  namespace Modules\Locacao\Repositories;
 */
class CategoriaLocacaoRepositoryEloquent extends BaseRepository implements CategoriaLocacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return CategoriaLocacao::class;
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
		return CategoriaLocacaoPresenter::class;
	}
}
