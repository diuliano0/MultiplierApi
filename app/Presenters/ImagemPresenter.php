<?php

namespace App\Presenters;

use App\Transformers\ImagemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ImagemPresenter
 *
 * @package namespace App\Presenters;
 */
class ImagemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ImagemTransformer();
    }
}
