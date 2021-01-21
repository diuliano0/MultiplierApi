<?php

namespace App\Presenters;

use App\Transformers\MensagemFinanceiroTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MensagemFinanceiroPresenter
 *
 * @package namespace App\Presenters;
 */
class MensagemFinanceiroPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MensagemFinanceiroTransformer();
    }
}
