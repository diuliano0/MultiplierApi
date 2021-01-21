<?php


namespace Modules\Core\Presenters;

use Modules\Core\Transformers\ModulosAtivoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ModulosAtivoPresenter
 *
 * @package  namespace ;
 */
class ModulosAtivoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ModulosAtivoTransformer();
    }
}
