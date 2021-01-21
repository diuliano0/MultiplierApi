<?php

namespace App\Http\Controllers\Api\Admin;


use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Criteria\ClientCriteria;
use App\Criteria\OrderCriteria;
use App\Http\Controllers\BaseController;
use App\Repositories\ClientRepository;


/**
 * @resource API Client Token - Backend
 *
 * Essa API é responsável pelo gerenciamento dos tokens no App qImob.
 * Os próximos tópicos apresentara os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class ClientTokenController extends BaseController
{
    /**
     * The client repository instance.
     *
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * The validation factory implementation.
     *
     * @var ValidationFactory
     */
    protected $validation;

    /**
     * Create a client controller instance
     *
     * @param  ClientRepository  $clients
     * @param  ValidationFactory  $validation
     * @return void
     */
    public function __construct(
        ClientRepository $clientRepository,
        ValidationFactory $validation
    )
    {
        $this->clientRepository = $clientRepository;
        $this->validation = $validation;
        parent::__construct($clientRepository,ClientCriteria::class);
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        return $this->validator;
    }

    /**
     * Remover Client Token
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function userRevoke($id){
        try{
            if(!$this->clientRepository->revoked($id))
                throw new \Exception(trans('errors.invalid_client',['recurso'=>'Cliente']));
            return parent::responseSuccess(parent::HTTP_CODE_OK,trans('success.client.revoke'));
        }catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage()."[{$e->getLine()}]");
        }
    }

    /**
     * Atualizar Client Token
     *
     * @param $clientId
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateToken($clientId){
        try{
            return $this->clientRepository->regenerateSecret($clientId);
        }catch (\PDOException $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.sql_state.error_search_list', ['code'=>$e->getCode()]));
        }catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage()."[{$e->getLine()}]");
        }
    }

    /**
     * Get all of the clients for the authenticated user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function forUser(Request $request)
    {
        $userId = $request->user()->getKey();
        return $this->clientRepository->activeForUser($userId)->makeVisible('secret');
    }

    /**
     * Cadastrar Client Token
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validation->make($request->all(), [
            'name' => 'required|max:255',
            'redirect' => 'required|url',
        ])->validate();

        return $this->clientRepository->create(
            $request->user()->getKey(), $request->name, $request->redirect
        )->makeVisible('secret');
    }

    /**
     * Atualizar Client Token
     *
     * @param  Request  $request
     * @param  string  $clientId
     * @return Response
     */
    public function update(Request $request, $clientId)
    {
        if (! $request->user()->clientRepository->find($clientId)) {
            return new Response('', 404);
        }

        $this->validation->make($request->all(), [
            'name' => 'required|max:255',
            'redirect' => 'required|url',
        ])->validate();

        return $this->clientRepository->update(
            $request->user()->clients->find($clientId),
            $request->name, $request->redirect
        );
    }

    public function createPersonalAccessClient(){

    }

    /**
     * Deletar Client Token
     *
     * @param  Request  $request
     * @param  string  $clientId
     * @return Response
     */
    public function destroy($clientId)
    {
        try{
            $this->clientRepository->revogarTokens($clientId);
            return parent::responseSuccess(parent::HTTP_CODE_OK,trans('success.client.revoke'));
        }catch (\PDOException $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.sql_state.error_search_list', ['code'=>$e->getCode()]));
        }catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage()."[{$e->getLine()}]");
        }
    }
}
