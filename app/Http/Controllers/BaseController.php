<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 09/01/2017
 * Time: 10:05
 */

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Criteria\OrderCriteria;
use App\Interfaces\ICustomController;
use App\Traits\DefaultActions;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

abstract class BaseController extends Controller implements ICustomController
{

	const MSG_REGISTRO_EXCLUIDO = 'Registro excluido com sucesso.';
	const MSG_REGISTRO_ALTERADO = 'Registro alterado com sucesso.';
	const MSG_REGISTRO_RESTAURADO = 'Registro restaurado com sucesso.';

	const HTTP_CODE_BAD_REQUEST = [
		'status'=>301,
		'code'=>'HTTP_CODE_BAD_REQUEST'
	];

	const HTTP_CODE_NOT_FOUND = [
		'status'=>404,
		'code'=>'HTTP_CODE_NOT_FOUND'
	];

	const HTTP_CODE_OK = [
		'status'=>200,
		'code'=>'HTTP_CODE_OK'
	];

	const HTTP_CODE_CREATED = [
		'status'=>201,
		'code'=>'HTTP_CODE_CREATED'
	];

    use DefaultActions, ResponseActions;

    protected static $_PAGINATION_COUNT = 8;

    protected $defaultRepository;
    /**
     * @var
     */
    private $defaultCriteria;

    /**
     * @var string
     */
    private $defaultOrder;

    public function __construct($defaultRepository, $defaultCriteria, $defaultOrder = OrderCriteria::class)
    {
        $this->defaultRepository = $defaultRepository;
        $this->defaultCriteria = $defaultCriteria;
        $this->defaultOrder = $defaultOrder;
    }




    private $pathFile = null;

    /**
     * @return mixed
     */
    public function getDefaultCriteria()
    {
        return $this->defaultCriteria;
    }

    /**
     * @param mixed $defaultCriteria
     */
    public function setDefaultCriteria($defaultCriteria)
    {
        $this->defaultCriteria = $defaultCriteria;
    }

    protected function getUserId(){
        $user = app(Request::class)->user();
        if(isset($user->id)){
            return $user->id;
        }
        return null;
    }

    /*
     get User
     * */
    protected function getUser(){
        return app(Request::class)->user();
    }

    /**
     * @return Request
     */
    protected function getRequest(){
        return app(Request::class);
    }

    /**
     * @return null
     */
    protected function getPathFile()
    {
        return $this->pathFile;
    }

    /**
     * @param null $pathFile
     */
    protected function setPathFile($pathFile)
    {
        $this->pathFile = $pathFile;
    }



}
