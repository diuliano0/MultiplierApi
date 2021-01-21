<?php


namespace Modules\Core\Repositories;


use Modules\Core\Models\ConfigUploadArquivo;
use Modules\Core\Presenters\ConfigUploadArquivoPresenter;
use App\Repositories\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ConfigUploadArquivoRepositoryEloquent
 * @package  namespace Modules\Core\Repositories;
 */
class ConfigUploadArquivoRepositoryEloquent extends BaseRepository implements ConfigUploadArquivoRepository
{
    /**
     * Specify Model class name
     *
     * @return  string
     */
    public function model()
    {
        return ConfigUploadArquivo::class;
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
		return ConfigUploadArquivoPresenter::class;
	}
}
