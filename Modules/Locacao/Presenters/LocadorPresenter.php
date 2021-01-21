<?php


namespace Modules\Locacao\Presenters;

use Modules\Locacao\Transformers\LocadorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LocadorPresenter
 *
 * @package  namespace ;
 */
class LocadorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LocadorTransformer();
    }
}
