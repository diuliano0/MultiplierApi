<?php

namespace Modules\Associacao\Http\Requests;


use Modules\Associacao\Services\TrabalhadorService;
use Modules\Core\Rules\CnpjCpfRole;
use Modules\Core\Traits\FilableEndereco;
use Modules\Core\Traits\FilableGrupo;
use Modules\Core\Traits\FilablePessoa;
use Modules\Core\Traits\FilableTelefone;
use Modules\Core\Traits\FilableUsuario;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class TrabalhadorRequest extends BaseRequest implements ICustomRequest
{
	use FilablePessoa, FilableEndereco, FilableTelefone, FilableUsuario, FilableGrupo;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return  array
	 */
	public function rules($id = null)
	{
		$id = $this->getIdentificador('trabalhador');
		$representante = [];

		if ($id) {

			/** @var TrabalhadorService $representante */

			$representante = app(TrabalhadorService::class);
			$representante = $representante->get($id, true);

		}
		$rules = array_merge([
			"funcao" => 'required',
			"matricula" => 'required',
			'pessoa' => 'array',

			'pessoa.nome' => 'required|string|min:3|max:255',

			'pessoa.rg' => 'required',

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

			'user' => 'nullable|array',

			'user.username' => 'required_if:user,array|string|unique:users,username' . (isset($id) ? (!is_null($representante->user_id)?','.$representante->user_id:null) : ''),

			'user.password' => 'AlphaNum|min:6|Confirmed' . (isset($id) ? '|' . 'nullable' : '|required_if:user,array'),

			'user.password_confirmation' => 'required_with:password',

			'user.email' => 'required_if:user,array|email|unique:users,email' . (($id) ? (!is_null($representante->user_id)?','.$representante->user_id:null) : ''),

			'user.nome' => 'required_if:user,array|min:2|max:255',

			'user.status' => 'required_if:user,array',

		],

			self::rulesEnderecoExtended('pessoa.'),

			self::rulesTelefoneExtended('pessoa.'));
		return $rules;
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
				"funcao",
				"data_filiacao",
				"matricula",
				'anexo',
				'grupos'
			],

			self::$pessoaFields,

			self::injectKeyDepencence('user.', self::$usuarioFields),

			self::injectKeyDepencence('pessoa.', self::$enderecoFields),

			self::injectKeyDepencence('pessoa.', self::$telefoneFields)

		);
	}
}
