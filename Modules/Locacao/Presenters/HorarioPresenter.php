<?php


namespace Modules\Locacao\Presenters;

use Modules\Locacao\Transformers\HorarioTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class HorarioPresenter
 *
 * @package  namespace ;
 */
class HorarioPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new HorarioTransformer();
    }
}
