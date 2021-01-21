<?php

namespace Modules\Locacao\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Enuns\Grupo;
use Modules\Core\Models\User;
use Modules\Core\Repositories\PessoaRepository;
use Modules\Core\Services\DBService;
use Modules\Locacao\Presenters\LocadorPresenter;
use Modules\Locacao\Repositories\LocadorRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Modules\Localidade\Services\EnderecoService;
use Modules\Localidade\Services\TelefoneService;
use Prettus\Repository\Exceptions\RepositoryException;

class LocadorService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  LocadorRepository
	 */
	private $locadorRepository;

	private $path;

	/**
	 * @var  PessoaRepository
	 */
	private $pessoaRepository;

	public function __construct(PessoaRepository $pessoaRepository, LocadorRepository $locadorRepository)
	{
		$this->locadorRepository = $locadorRepository;
		$this->path = 'arquivos/img/locador/';
        $this->pessoaRepository = $pessoaRepository;
	}

	public function getDefaultRepository()
	{
		return $this->locadorRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}

    public function create($data){
        try{
            DBService::beginTransaction();
            $locador = $this->getDefaultRepository()->skipPresenter(true)->create($data);
            if(isset($data['pessoa']['id']) && is_null(($data['pessoa']['id']))){
                $locador->pessoa->update($data['pessoa']);
            }else{
                $pessoa = $locador->pessoa()->create($data['pessoa']);
                $locador->pessoa_id = $pessoa->id;
            }

            if (isset($data['pessoa']['telefones'])) {
                TelefoneService::salvarTelefone($data, $locador);
            }

            if (isset($data['pessoa']['enderecos'])) {
                EnderecoService::salvarEndereco($data, $locador);
            }

            if (isset($data['user'])) {
                if (is_null($locador->usuario)) {
                    /** @var User $user */
                    $user = $locador->usuario()->create($data['user']);
                    $locador->user_id = $user->id;
                    $user->grupos()->sync([Grupo::LOCADOR]);
                } else {
                    $locador->usuario->fill($data['user'])->save();
                }
            }

            if (isset($data['anexo'])) {
                try {
                    $this->createAnexo($locador, $data, $this->path);
                } catch (\Exception $e) {
                    return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
                }
            }

            $locador->update();
            DBService::commit();
            return self::transformerData($locador, LocadorPresenter::class);
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function update($data, $id)
    {
        try {
            DBService::beginTransaction();
            $locador = $this->getDefaultRepository()->resetScope()->skipPresenter(true)->find($id);
            $locador->fill($data);
            $locador->pessoa->update($data['pessoa']);


            if (isset($data['pessoa']['telefones'])) {
                TelefoneService::salvarTelefone($data, $locador);
            }

            if (isset($data['pessoa']['enderecos'])) {
                EnderecoService::salvarEndereco($data, $locador);
            }

            if (isset($data['anexo'])) {
                try {
                    $this->createAnexo($locador, $data, $this->path);
                } catch (\Exception $e) {
                    return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
                }
            }

            if (isset($data['user'])) {
                if (is_null($locador->usuario)) {
                    /** @var User $user */
                    $user = $locador->usuario()->create($data['user']);
                    $locador->user_id = $user->id;
                    $user->grupos()->sync([Grupo::LOCADOR]);
                } else {
                    $locador->usuario->fill($data['user'])->save();
                }

            }

            $locador->update();
            DBService::commit();
            return self::transformerData($this->get($id, true), LocadorPresenter::class);
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }


    public function perfil($id, $skip = false)
    {
        try {
            $locador = $this->getDefaultRepository()->resetScope()->skipPresenter(true)->findByField('user_id', $id);
            if(!$skip)
                return self::transformerData($locador->first(), LocadorPresenter::class);
            return $locador->first();
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function pesquisar($string)
    {
        try{
            return $this->getDefaultRepository()->scopeQuery(function ($query) use ($string){
                return $query
                    ->join('core.pessoas', 'core.pessoas.id', '=', 'locacao.locadores.pessoa_id')
                    ->where(function ($query) use ($string){
                        return $query->orWhere('core.pessoas.nome', 'ilike', '%' . $string . '%')
                            ->orWhere('core.pessoas.cpf_cnpj', 'ilike', '%' . $string . '%');
                    })
                    ->select([\DB::raw('DISTINCT locadores.*')])
                    ->limit(25);
            })->all();
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function mudarImagem($id, $data)
    {
        try {
            DBService::beginTransaction();
            $locador = $this->getDefaultRepository()->resetScope()->skipPresenter(true)->findByField('user_id', $id)->first();
            if (isset($data['anexo'])) {
                try {
                    $this->createAnexo($locador, $data, $this->path);
                } catch (\Exception $e) {
                    return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
                }
            }
            DBService::commit();
            return self::responseSuccess(self::$HTTP_CODE_OK, 'Imagem Alterada');
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }



}
