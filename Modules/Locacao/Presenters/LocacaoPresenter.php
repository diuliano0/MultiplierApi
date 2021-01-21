<?php


namespace Modules\Locacao\Presenters;

use Modules\Locacao\Transformers\LocacaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LocacaoPresenter
 *
 * @package  namespace ;
 */
class LocacaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LocacaoTransformer();
    }
}
