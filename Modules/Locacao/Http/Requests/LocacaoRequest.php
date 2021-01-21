<?php

namespace Modules\Locacao\Http\Requests;


use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class LocacaoRequest extends BaseRequest implements ICustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
        $id = $this->getIdentificador('locacao');
        return [
            "nome" => 'required',
            "capacidade" => 'required',
            "comodidades" => 'exists:comodidades,id',
            "categoria_locacao_id" => 'required|exists:categoria_locacoes,id',
            "status",
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
            "nome",
            "categoria_locacao_id",
            "capacidade",
            "status",
            "descricao",
            "valor_locacao",
            "custo_operacional",
            "comodidades",
            "url_360",
        ];
    }
}
