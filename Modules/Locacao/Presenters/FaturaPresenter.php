<?php


namespace Modules\Locacao\Presenters;

use Modules\Locacao\Transformers\FaturaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FaturaPresenter
 *
 * @package  namespace ;
 */
class FaturaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FaturaTransformer();
    }
}
