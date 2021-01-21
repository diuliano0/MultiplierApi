<?php


namespace Modules\Core\Presenters;

use Modules\Core\Transformers\ConfigUploadArquivoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ConfigUploadArquivoPresenter
 *
 * @package  namespace ;
 */
class ConfigUploadArquivoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return  \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ConfigUploadArquivoTransformer();
    }
}
