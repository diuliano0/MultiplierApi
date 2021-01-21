<?php

namespace Modules\Core\Presenters;


use Modules\Core\Transformers\GrupoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GrupoPresenter
 *
 * @package namespace App\Presenters;
 */
class GrupoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GrupoTransformer();
    }
}
