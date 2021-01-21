<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\Grupo;
use Modules\Core\Presenters\GrupoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class GrupoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class GrupoRepositoryEloquent extends BaseRepository implements GrupoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Grupo::class;
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
		return GrupoPresenter::class;
	}

	public function ativarDesativar(int $id)
	{
		$grupo = $this->model->find($id);
		$grupo->fg_ativo = !$grupo->fg_ativo;
		$grupo->save();
	}
}
