<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Illuminate\Routing\Controller;
use Modules\Core\Criteria\AuthCriteria;
use Modules\Core\Services\AuthService;
use Modules\Core\Http\Requests\AuthRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class AuthController extends Controller
{

	public function getValidator()
	{
		return new AuthRequest();
	}

	public function token(AuthRequest $request){
		return $this->issueToken($request, 'password');
	}

	private function issueToken(AuthRequest $request, $grant_type, $scope = '*') {
		$params = [
			'grant_type' => $grant_type,
			'scope' => $scope,
		];
		$proxy = $request::create('api/v1/token', 'POST');
		$proxy->request->add(array_merge($params, $request->getOnlyDataFields()));
		$dispatch = \Route::dispatch($proxy);
		return $dispatch ;
	}
}

