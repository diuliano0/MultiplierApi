<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\SessionManager;
use App\Traits\ResponseActions;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserContextMiddleware extends StartSession
{
	use ResponseActions;

	public function __construct(SessionManager $manager)
	{
		parent::__construct($manager);
	}

	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

		$context_user = $request->header('context_user');

		if($request->route()->getName() != "auth.login" && !preg_match('/no_context_md/i', $request->route()->getName())){
			$context_user = is_null($context_user)?$_SERVER['REDIRECT_HTTP_CONTEXT_USER']:$context_user;
			if(is_null($context_user)){
				return \Response::json(array('message'=>'context_user não encontrato no header da requisição.'), self::$HTTP_CODE_BAD_REQUEST['status']);
			}
			$request->merge([
				'context_user' => \Crypt::decrypt($context_user)
			]);
		}
        return $next($request);
    }
}
