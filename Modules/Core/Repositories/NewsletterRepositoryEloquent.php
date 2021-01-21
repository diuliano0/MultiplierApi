<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\Newsletter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Validators\NewsletterValidator;

/**
 * Class NewsletterRepositoryEloquent
 * @package namespace App\Repositories;
 */
class NewsletterRepositoryEloquent extends BaseRepository implements NewsletterRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Newsletter::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
		parent::boot();
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
