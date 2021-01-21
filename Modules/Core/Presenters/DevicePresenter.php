<?php


namespace Modules\Core\Presenters;

use Modules\Core\Transformers\DeviceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DevicePresenter
 *
 * @package  namespace ;
 */
class DevicePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DeviceTransformer();
    }
}
