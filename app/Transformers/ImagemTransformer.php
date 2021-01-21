<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Imagem;

/**
 * Class ImagemTransformer
 * @package namespace App\Transformers;
 */
class ImagemTransformer extends TransformerAbstract
{

    /**
     * Transform the \Imagem entity
     * @param \Imagem $model
     *
     * @return array
     */
    public function transform(Imagem $model)
    {
        $ligacao = strtolower(class_basename($model->imagemtable_type));
        $tamanos = null;
        if ($model->img && $ligacao == 'anuncio') {
            $tamanos = [];
            $imagem_list = Imagem::$tamanhos;
            $filemake = explode('.', $model->img);
            foreach ($imagem_list['anuncio'] as $index => $item) {
                $tamanos[$index] = \URL::to('/') . '/arquivos/img/' . $ligacao . '/' . $filemake[0] . '_' . $index . '.' . $filemake[1];
            }

        }
        return [
            'id' => (int)$model->id,
            'img' => is_null($tamanos) ? \URL::to('/') . '/arquivos/img/' . $ligacao . '/' . $model->img : $tamanos,
            'principal' => (boolean)$model->principal,
            'prioridade' => (int)$model->prioridade,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
