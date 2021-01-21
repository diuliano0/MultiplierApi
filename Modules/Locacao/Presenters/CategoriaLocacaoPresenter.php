<?php


namespace Modules\Locacao\Presenters;

use Modules\Locacao\Transformers\CategoriaLocacaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CategoriaLocacaoPresenter
 *
 * @package  namespace ;
 */
class CategoriaLocacaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CategoriaLocacaoTransformer();
    }
}
