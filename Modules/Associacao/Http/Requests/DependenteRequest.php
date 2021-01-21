<?php

namespace Modules\Associacao\Http\Requests;


use Modules\Associacao\Services\DependenteService;
use Modules\Core\Rules\CnpjCpfRole;
use Modules\Core\Traits\FilableEndereco;
use Modules\Core\Traits\FilablePessoa;
use Modules\Core\Traits\FilableTelefone;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class DependenteRequest extends BaseRequest implements ICustomRequest
{
	use FilablePessoa, FilableEndereco, FilableTelefone;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return  array
	 */
	public function rules($id = null)
	{
		$id = $this->getIdentificador('dependente');
		$representante = [];

		if ($id) {

			/** @var DependenteService $representante */

			$representante = app(DependenteService::class);

			$representante = $representante->get($id, true);

		}

		return array_merge([

			'trabalhador_id' => 'required',
			'pessoa' => 'array',

			'pessoa.nome' => 'required|string|min:3|max:255',

			'pessoa.razao_social' => 'nullable|required_if:tipo,1|string|min:3|max:255',

			'pessoa.email' => [

				'required',

				'unique:pessoas,email' . (($id) ? ',' . $representante->pessoa_id : ''),

				'string',

			],

			'pessoa.cpf_cnpj' => [

				'required',

				'unique:pessoas,cpf_cnpj' . (($id) ? ',' . $representante->pessoa_id : ''),

				'string',

				new CnpjCpfRole()

			],


		],

			self::rulesEnderecoExtended('pessoa.'),

			self::rulesTelefoneExtended('pessoa.'));
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
		return array_merge(
			[
				'trabalhador_id',
				'anexo',
			],

			self::$pessoaFields,

			self::injectKeyDepencence('pessoa.', self::$enderecoFields),

			self::injectKeyDepencence('pessoa.', self::$telefoneFields)

		);
	}
}
