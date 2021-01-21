<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 12/6/2018
 * Time: 4:55 PM
 */

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\SessionManager;
use Modules\Core\Models\Filial;
use Modules\Core\Services\AuthService;
use Modules\Core\Services\UserService;

class FilialSessionMiddleware  extends StartSession
{
	/**
	 * @var AuthService
	 */
	private $authService;

	public function __construct(SessionManager $manager, AuthService $authService)
	{
		parent::__construct($manager);
		$this->authService = $authService;
	}

	public function handle($request, Closure $next)
	{
		$respose = $next($request);
		//dd(json_encode(get_class_methods($respose)));
		if($respose->status() == 200){
			$token = json_decode($respose->getContent(), true);
			$token['context_user'] = $this->authService->setContextSession($request->username, $request->nome_conta);
			$respose->setContent(json_encode($token));
		}
		return $respose;
	}


}
