<?php

namespace Modules\Core\Http\Requests;

use Modules\Core\Traits\FilableGrupo;
use Modules\Core\Traits\FilableUsuario;
use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;

class UserUpdateCurrentRequest extends BaseRequest implements ICustomRequest
{
	use FilableGrupo, FilableUsuario;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @param null $id
	 * @return array
	 */
	public function rules($id = null)
	{
		$rules = array_merge(
			self::rulesUsuarioExtended(null, $this->user()->id)
		);

		switch($_SERVER['REQUEST_METHOD']) {
			case 'POST': {
				return $rules;
			}
			case 'PUT': {
				return self::removeFiels($rules, ['password']);
			}
		}
		return $rules;
	}

	public function getOnlyFields(){
		return array_merge(
			self::$usuarioFields);
	}
}
