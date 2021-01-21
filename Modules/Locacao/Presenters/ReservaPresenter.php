<?php


namespace Modules\Locacao\Presenters;

use Modules\Locacao\Transformers\ReservaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ReservaPresenter
 *
 * @package  namespace ;
 */
class ReservaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ReservaTransformer();
    }
}
