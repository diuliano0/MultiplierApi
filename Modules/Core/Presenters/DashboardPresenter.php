<?php


namespace Modules\Core\Presenters;

use Modules\Core\Transformers\DashboardTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DashboardPresenter
 *
 * @package  namespace ;
 */
class DashboardPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DashboardTransformer();
    }
}
