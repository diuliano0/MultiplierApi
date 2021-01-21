<?php


namespace Modules\Associacao\Presenters;

use Modules\Associacao\Transformers\BannerAssociadoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BannerAssociadoPresenter
 *
 * @package  namespace ;
 */
class BannerAssociadoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BannerAssociadoTransformer();
    }
}
