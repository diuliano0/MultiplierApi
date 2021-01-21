<?php

namespace Modules\Core\Http\Requests;


use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class ConfigUploadArquivoRequest extends BaseRequest implements ICustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
		$id = $this->getIdentificador('configuploadarquivo');
        return [
        	'quantidade_maxima_arquivo' => 'required',
        	'tamanho_maximo_arquivo' => 'required',
        	'quantidade_maxima_img' => 'required',
        	'tamanho_maximo_img' => 'required',
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
			'quantidade_maxima_arquivo',
			'tamanho_maximo_arquivo',
			'quantidade_maxima_img',
			'tamanho_maximo_img',
		];
	}
}
