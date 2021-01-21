<?php


namespace Modules\Core\Repositories;


use Modules\Core\Models\Notificacao;
use Modules\Core\Presenters\NotificacaoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class NotificacaoRepositoryEloquent
 * @package  namespace Modules\Core\Repositories;
 */
class NotificacaoRepositoryEloquent extends BaseRepository implements NotificacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return Notificacao::class;
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
		return NotificacaoPresenter::class;
	}
}
