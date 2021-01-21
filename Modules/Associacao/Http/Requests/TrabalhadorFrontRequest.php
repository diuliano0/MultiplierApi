<?php

namespace Modules\Associacao\Http\Requests;


use Modules\Associacao\Models\Trabalhador;
use Modules\Associacao\Services\TrabalhadorService;
use Modules\Core\Traits\FilableEndereco;
use Modules\Core\Traits\FilableGrupo;
use Modules\Core\Traits\FilablePessoa;
use Modules\Core\Traits\FilableTelefone;
use Modules\Core\Traits\FilableUsuario;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class TrabalhadorFrontRequest extends BaseRequest implements ICustomRequest
{
	use FilablePessoa, FilableEndereco, FilableTelefone, FilableUsuario, FilableGrupo;
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return  array
	 */
	public function rules($id = null)
	{
		$id = $this->getIdentificador('anunciante');

		$trabalhado = null;
		if($_SERVER['REQUEST_METHOD'] == 'PUT'){

			/** @var TrabalhadorService $trabalhador */
			$trabalhador = app(TrabalhadorService::class);
			$trabalhador = $trabalhador->perfil($this->user()->id, true);

			/** @var Trabalhador $trabalhador */
			$id = $trabalhador->id;
		}

		return array_merge([
			'pessoa' => 'array',
			'pessoa.nome' => 'required|string|min:3|max:255',
			'pessoa.email' => [
				'required',
				'unique:pessoas,email' . (($id) ? ',' . $trabalhador->pessoa_id : ''),
				'string',
			],
			'user'=>'nullable|array',
			'user.username' => 'required_if:user,array|unique:users,username' . (isset($id) ? ',' . $trabalhador->user_id : ''),
			'user.password' => 'AlphaNum|min:6|Confirmed' . (isset($id) ? '|' . 'nullable' : '|required_if:user,array'),
			'user.password_confirmation' => 'required_with:password',
			'user.email' => 'required_if:user,array|email|unique:users,email' . (($id) ? ',' . $trabalhador->user_id : ''),
			'user.nome' => 'required_if:user,array|min:2|max:255',
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
				'status'
			],
			self::$pessoaFields,
			self::injectKeyDepencence('user.', self::$usuarioFields),
			self::injectKeyDepencence('pessoa.', self::$enderecoFields),
			self::injectKeyDepencence('pessoa.', self::$telefoneFields)
		);
	}
}
