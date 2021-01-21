<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 09/02/2018
 * Time: 17:01
 */

namespace Modules\Core\Services;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Presenters\UserPresenter;
use Modules\Core\Repositories\FilialRepository;
use Modules\Core\Repositories\PessoaRepository;
use Modules\Core\Repositories\UserRepository;
use Modules\Localidade\Repositories\EnderecoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class UserService extends BaseService implements IService
{
	use ResponseActions;
	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @var PessoaRepository
	 */
	private $pessoaRepository;

	/**
	 * @var EnderecoRepository
	 */
	private $enderecoRepository;

	private $path;
	/**
	 * @var FilialRepository
	 */
	private $filialRepository;

	public function __construct(
		UserRepository $userRepository,
		FilialRepository $filialRepository,
		PessoaRepository $pessoaRepository,
		EnderecoRepository $enderecoRepository)
	{
		$this->userRepository = $userRepository;
		$this->pessoaRepository = $pessoaRepository;
		$this->enderecoRepository = $enderecoRepository;
		$this->path =  '/arquivos/img/user/';
		$this->filialRepository = $filialRepository;
	}

	public function create(array $data)
	{
		try {
			\DB::beginTransaction();
			$user = $this->userRepository->skipPresenter(true)->create($data);
			if (isset($data['grupos'])) {
				$user->grupos()->attach(array_map(function ($item) {
					return $item['id'];
				}, $data['grupos']));
			}
			if (isset($data['anexo'])) {
				try {
					$this->createAnexo($user, $data, $this->path);
				} catch (\Exception $e) {
					return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
				}
			}
			$user->save();
			\DB::commit();
			return self::transformerData($user, UserPresenter::class);
		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {
			\DB::rollBack();
			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
		}
	}

	public function update(array $data, $id)
	{
		try {
			\DB::beginTransaction();
			$user = $this->userRepository->skipPresenter(true)->update($data, $id);
			if (isset($data['pessoa'])) {
				$user->pessoa->update($data['pessoa']);
			}
			if (isset($data['grupos'])) {
				$user->grupos()->sync(array_map(function ($item) {
					return $item['id'];
				}, $data['grupos']));
			}
			if (isset($data['anexo'])) {
				try {
					$this->createAnexo($user, $data, $this->path);
				} catch (\Exception $e) {
					return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
				}
			}
			\DB::commit();
			return self::transformerData($user, UserPresenter::class);
		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {
			\DB::rollBack();
			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
		}
	}

	public function show($id)
	{
		try {
			$user = transformer_data(AuthService::getUser(), UserPresenter::class);
			if(isset($user['data']['menu'])){
				$user['data']['menu']['data'] = array_values(RotaAcessoService::montarMenu($user['data']['menu']['data']));
			}
            $user['data']['filial_id'] = AuthService::getFilialId();
			$filial = AuthService::getFilial();
            $user['data']['filial'] = $filial->toArray();
            $user['data']['filial']['nome_filial'] = $filial->pessoa->nome;
            if($filial->convenios)
			    $user['data']['filial']['convenios'] = json_encode($filial->convenios);
			unset($user['data']['id']);
			return $user;
		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {
			\DB::rollBack();
			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
		}
	}

	public function delete($id)
	{
		try {
			$this->userRepository->delete($id);
			return self::responseSuccess(self::$HTTP_CODE_OK, self::$MSG_REGISTRO_EXCLUIDO);
		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {
			\DB::rollBack();
			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
		}
	}

	public function getDefaultRepository()
	{
		return $this->userRepository;
	}

	public function checkFilial($user_name, $nome_conta){
		$user = $this->userRepository->skipPresenter(true)->resetScope()->findByField('username',$user_name)->first();

		if(is_null($user)){
			return false;
		}
		if($user->is_admin){
			return true;
		}//dd($user->filiais->toArray());
		return $user->filiais->where('nome_conta', $nome_conta)->count() > 0;
	}

	public function getFilialByUser($user_name, $nome_conta){
		$user = $this->userRepository->skipPresenter(true)->resetScope()->findByField('username',$user_name)->first();
		if($user->is_admin){
			return $this->filialRepository->skipPresenter(true)->findByField('nome_conta', $nome_conta)->first();
		}
		return $user->filiais->where('nome_conta', $nome_conta)->first();
	}

	public function pesquisar($string)
	{
		try{
			return $this->userRepository->resetScope()->findByField('email', $string);
		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {
			\DB::rollBack();
			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
		}
	}
}
