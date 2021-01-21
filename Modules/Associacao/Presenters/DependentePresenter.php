<?php


namespace Modules\Associacao\Presenters;

use Modules\Associacao\Transformers\DependenteTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DependentePresenter
 *
 * @package  namespace ;
 */
class DependentePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DependenteTransformer();
    }
}
