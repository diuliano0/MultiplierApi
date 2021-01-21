<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\Permissao;
use Modules\Core\Transformers\PermissaoTransformer;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PermissaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PermissaoRepositoryEloquent extends BaseRepository implements PermissaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permissao::class;
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
		return PermissaoTransformer::class;
	}
}
