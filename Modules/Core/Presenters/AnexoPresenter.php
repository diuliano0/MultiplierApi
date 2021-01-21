<?php


namespace Modules\Core\Presenters;

use Modules\Core\Transformers\AnexoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AnexoPresenter
 *
 * @package  namespace ;
 */
class AnexoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AnexoTransformer();
    }
}
