<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 02/01/2017
 * Time: 15:19
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    protected function removeNull(array $itens){
		return array_remove_null($itens);
	}
}
