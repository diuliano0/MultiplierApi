<?php

namespace Modules\Locacao\Http\Requests;


use App\Http\Controllers\Request\BaseRequest;
use App\Interfaces\ICustomRequest;
use Modules\Core\Rules\CnpjCpfRole;
use Modules\Core\Traits\FilableEndereco;
use Modules\Core\Traits\FilableGrupo;
use Modules\Core\Traits\FilablePessoa;
use Modules\Core\Traits\FilableTelefone;
use Modules\Core\Traits\FilableUsuario;
use Modules\Locacao\Models\Locador;
use Modules\Locacao\Services\LocadorService;
use Modules\Saude\Models\Beneficiario;
use Modules\Saude\Services\BeneficiarioService;

class LocadorRequest extends BaseRequest implements ICustomRequest
{
    use FilablePessoa, FilableEndereco, FilableTelefone, FilableUsuario, FilableGrupo;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules($id = null)
    {
		$id = $this->getIdentificador('locador');
        $locador = [];
        if($id){
            /** @var LocadorService $locadorService */
            $locadorService = app(LocadorService::class);
            /** @var Locador $locador */
            $locador = $locadorService->get($id, true);
        }

        return array_merge([
            'pessoa' => 'array',
            'pessoa.nome' => 'required|string|min:3|max:255',
            'pessoa.razao_social' => 'nullable|required_if:tipo,1|string|min:3|max:255',
            'pessoa.email' => [
                'required',
                'unique:pessoas,email' . (($id) ? ',' . $locador->pessoa_id : ''),
                'string',
            ],
            'pessoa.cpf_cnpj' => [
                'required',
                'unique:pessoas,cpf_cnpj' . (($id) ? ',' . $locador->pessoa_id : ''),
                'string',
                new CnpjCpfRole()
            ],
            'user'=>'nullable|array',
            'user.username' => 'required_if:user,array|string|unique:users,username' . (isset($id) ? (!is_null($locador->user_id)?','.$locador->user_id:null) : ''),
            'user.password' => 'AlphaNum|min:6|Confirmed' . (isset($id) ? '|' . 'nullable' : '|required_if:user,array'),
            'user.password_confirmation' => 'required_with:password',
            'user.email' => 'required_if:user,array|email|unique:users,email' . (($id) ? (!is_null($locador->user_id)?','.$locador->user_id:null) : ''),
            'user.nome' => 'required_if:user,array|min:2|max:255',
            'user.status' => 'required_if:user,array',
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
                'anexo',
                'grupos',
                'plataforma',
            ],
            self::$pessoaFields,
            self::injectKeyDepencence('user.', self::$usuarioFields),
            self::injectKeyDepencence('pessoa.', self::$enderecoFields),
            self::injectKeyDepencence('pessoa.', self::$telefoneFields)
        );
	}
}
