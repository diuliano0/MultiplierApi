<?php

namespace Modules\Core\Http\Requests;


use Modules\Core\Enuns\Modulo;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use App\Rules\EnumRule;

class RotaAcessoRequest extends BaseRequest implements ICustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
		$id = $this->getIdentificador('rotaacesso');
        return [
			"parent_id" => 'nullable|exists:rota_acessos,id',
			"titulo" => 'required|string|min:3|max:255',
			"rota" => 'required|string|max:255',
			"icon" => 'nullable|string',
			"disabled" => 'nullable|boolean',
			"ambiente" => 'nullable',
			"modulo" => [
				'nullable',
				'integer',
				new EnumRule(Modulo::class)
			],
			"prioridade" => 'nullable|integer',
			"is_menu" => 'nullable|boolean',
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
			"parent_id",
			"titulo",
			"rota",
			"icon",
			"disabled",
			"ambiente",
			"modulo",
			"prioridade",
			"is_menu"
		];
	}
}
