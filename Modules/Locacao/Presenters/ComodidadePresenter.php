<?php


namespace Modules\Locacao\Presenters;

use Modules\Locacao\Transformers\ComodidadeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ComodidadePresenter
 *
 * @package  namespace ;
 */
class ComodidadePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ComodidadeTransformer();
    }
}
