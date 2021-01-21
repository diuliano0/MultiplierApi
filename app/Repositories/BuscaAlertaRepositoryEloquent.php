<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BuscaAlertaRepository;
use App\Models\BuscaAlerta;
use App\Validators\BuscaAlertaValidator;

/**
 * Class BuscaAlertaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class BuscaAlertaRepositoryEloquent extends BaseRepository implements BuscaAlertaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BuscaAlerta::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
