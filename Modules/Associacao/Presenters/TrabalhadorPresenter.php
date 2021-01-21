<?php


namespace Modules\Associacao\Presenters;

use Modules\Associacao\Transformers\TrabalhadorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TrabalhadorPresenter
 *
 * @package  namespace ;
 */
class TrabalhadorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TrabalhadorTransformer();
    }
}
