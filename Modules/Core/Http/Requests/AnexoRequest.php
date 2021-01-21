<?php

namespace Modules\Core\Http\Requests;


use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;
use App\Rules\HexadecimalRule;

class AnexoRequest extends BaseRequest implements ICustomRequest
{

    public function rules($id = null)
    {
        return [
			'extensao'=>'required',
			'conteudo'=>'required',
		];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return  bool
     */
    public function authorize()
    {
        return true;
    }

	public function getOnlyFields()
	{
		return [
			'nome',
			'alias',
			'conteudo',
			'extensao',
		];
	}
}
