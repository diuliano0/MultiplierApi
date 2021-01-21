<?php


namespace Modules\Associacao\Presenters;

use Modules\Associacao\Transformers\NoticiaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NoticiaPresenter
 *
 * @package  namespace ;
 */
class NoticiaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NoticiaTransformer();
    }
}
