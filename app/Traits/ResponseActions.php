<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 21/02/2018
 * Time: 16:33
 */

namespace App\Traits;


trait ResponseActions
{

	protected static $MSG_REGISTRO_EXCLUIDO = 'Registro excluido com sucesso.';
	protected static $MSG_REGISTRO_ALTERADO = 'Registro alterado com sucesso.';
	protected static $MSG_REGISTRO_RESTAURADO = 'Registro restaurado com sucesso.';

	private static $HTTP_CODE_UNPROCESSABLE_ENTITY = [
		'status'=>422,
		'code'=>'HTTP_CODE_UNPROCESSABLE_ENTITY'
	];

	private static $HTTP_CODE_BAD_REQUEST = [
		'status'=>400,
		'code'=>'HTTP_CODE_BAD_REQUEST'
	];

	private static $HTTP_CODE_UNAUTHORIED = [
		'status'=>401,
		'code'=>'HTTP_CODE_UNAUTHORIED'
	];

	private static $HTTP_CODE_NOT_FOUND = [
		'status'=>404,
		'code'=>'HTTP_CODE_NOT_FOUND'
	];
	private static $HTTP_CODE_OK = [
		'status'=>200,
		'code'=>'HTTP_CODE_OK'
	];
	private static $HTTP_CODE_CREATED = [
		'status'=>201,
		'code'=>'HTTP_CODE_CREATED'
	];

	private static $HTTP_CODE_UNPROCE = [
		'status'=>201,
		'code'=>'HTTP_CODE_CREATED'
	];

	protected static function responseSuccess (array $status_code,string $message = null){

		return  response()->json([
			"success"=> [
				"status_code"=>  $status_code['status'],
				"code"=> $status_code['code'],
				"description"=> $message
			]
		], $status_code['status']);
	}

	protected static function responseError (array $status_code, string $message = null){

		return response()->json([
			"error"=> [
				"status_code"=>  $status_code['status'],
				"code"=> $status_code['code'],
				"description"=> $message
			]
		], $status_code['status']);

	}
}
