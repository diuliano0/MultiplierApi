<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 12/6/2018
 * Time: 1:46 PM
 */

namespace Modules\Core\Services;


use Illuminate\Http\Request;
use Modules\Core\Models\Filial;
use App\Services\BaseService;

class AuthService extends BaseService
{

	/**
	 * @var UserService
	 */
	private $userService;
	/**
	 * @var Request
	 */
	private $request;

	function __construct(UserService $userService, Request $request)
	{
		$this->userService = $userService;
		$this->request = $request;
	}

	public function getDefaultRepository()
	{
		return null;
	}

	public function setContextSession($username, $nome_conta){

		/** @var Filial $filial */
		$filial = $this->userService->getFilialByUser($username, $nome_conta);

		//$teste = \Crypt::decrypt($teste);
		return \Crypt::encrypt($filial->toArray());
	}

	public static function getFilialId(){
	    if(!isset(self::geteFilialContext()['id']))
	        return [];

		return self::geteFilialContext()['id'];
	}

	public static function getFilial(){
		return Filial::find(self::geteFilialContext()['id']);
	}

	private static function geteFilialContext(){

		/** @var Request $request */
		$request = self::getRequest();
		return $request->context_user;
	}

	public static function getRequest(){
		return app(Request::class);
	}

	public static function isAdmin(){
		return self::getUser()->is_admin;
	}

	public static function getUser(){
		return self::getRequest()->user();
	}

}
