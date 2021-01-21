<?php


namespace Modules\Core\Presenters;

use Modules\Core\Transformers\NotificacaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NotificacaoPresenter
 *
 * @package  namespace ;
 */
class NotificacaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NotificacaoTransformer();
    }
}
