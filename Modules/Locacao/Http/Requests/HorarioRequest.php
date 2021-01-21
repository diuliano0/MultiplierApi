<?php

namespace Modules\Locacao\Http\Requests;


use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use Modules\Locacao\Rules\HorarioConcorrenteRule;

class HorarioRequest extends BaseRequest implements ICustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
        $id = $this->getIdentificador('horario');
        return [
            'locacao_id' => 'required|exists:locacoes,id',
            'dth_inicio' => [
                'required',
                new HorarioConcorrenteRule($this->request->get('locacao_id'), $this->request->get('dth_inicio').';'.$this->request->get('dth_fim'))
            ],
            'dth_fim' => [
                'required',
                new HorarioConcorrenteRule($this->request->get('locacao_id'), $this->request->get('dth_inicio').';'.$this->request->get('dth_fim'))
            ],
            'hr_ativo_app' => 'boolean',
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
            'locacao_id',
            'dth_inicio',
            'dth_fim',
            'valor',
            'informar_saida',
            'funcionamento_semanal',
            'hr_ativo_app',
            'horarios'
        ];
    }
}
