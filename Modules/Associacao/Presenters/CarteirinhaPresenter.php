<?php


namespace Modules\Associacao\Presenters;

use Modules\Associacao\Transformers\CarteirinhaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CarteirinhaPresenter
 *
 * @package  namespace ;
 */
class CarteirinhaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CarteirinhaTransformer();
    }
}
