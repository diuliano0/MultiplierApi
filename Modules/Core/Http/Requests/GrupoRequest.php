<?php

namespace Modules\Core\Http\Requests;


use Modules\Core\Enuns\Modulo;
use Modules\Core\Enuns\Rotina;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;

class GrupoRequest extends BaseRequest implements ICustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($id = null)
    {
		$id = $this->getIdentificador('grupo');
        return [
            'nome' => 'required|unique:grupos,nome'.(is_null($id)?'':",$id"),
			'permissoes' => 'array',
			'permissoes.*.rotina' => [
				'required_if:rotinas,==,array',
				new EnumRule(Rotina::class)
			],
			'permissoes.*.modulo' => [
				'required_if:rotinas,==,array',
				new EnumRule(Modulo::class)
			]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

	public function getOnlyFields()
	{
		return [
			'nome',
			'descricao',
			'dashboards',
			'status',
			'permissoes',
			'rotas',
		];
	}
}
