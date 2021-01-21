<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Criteria\OrderCriteria;
use App\Criteria\PaginaCriteria;
use App\Http\Controllers\BaseController;
use App\Http\Requests\PaginaRequest;
use App\Repositories\PaginaRepository;
use Prettus\Repository\Exceptions\RepositoryException;


/**
 * @resource API Página - Backend qImob
 *
 * Essa API é responsável pelo gerenciamento de Página no App qImob.
 * Os próximos tópicos apresentara os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class PaginaController extends BaseController
{
    /**
     * @var PaginaRepository
     */
    private $paginaRepository;

    /***
     * @resource PaginaController constructor.
     * @param PaginaRepository $paginaRepository
     */

    public function __construct(PaginaRepository $paginaRepository)
    {
        $this->paginaRepository = $paginaRepository;
        parent::__construct($paginaRepository,PaginaCriteria::class);
    }
    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new PaginaRequest())->rules();
        return $this->validator;
    }

    /**
     * Consulta Página por SLUG
     *
     * Endpoint para consulta página passando o SLUG como parametro
     * @param $slug
     * @return retorna um registro
     */
    public function showSlug($slug){
        try{
            return $this->paginaRepository->findBySlug($slug);
        }catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }


}

