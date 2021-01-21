<?php


namespace Modules\Core\Presenters;

use Modules\Core\Transformers\GatewayPagamentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GatewayPagamentoPresenter
 *
 * @package  namespace ;
 */
class GatewayPagamentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GatewayPagamentoTransformer();
    }
}
