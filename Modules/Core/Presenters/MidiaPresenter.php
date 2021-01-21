<?php


namespace Modules\Core\Presenters;

use Modules\Core\Transformers\MidiaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MidiaPresenter
 *
 * @package  namespace ;
 */
class MidiaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MidiaTransformer();
    }
}
