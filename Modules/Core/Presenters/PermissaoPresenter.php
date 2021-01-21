<?php

namespace Modules\Core\Presenters;

use Modules\Core\Transformers\PermissaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PermissaoPresenter
 *
 * @package namespace App\Presenters;
 */
class PermissaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PermissaoTransformer();
    }
}
