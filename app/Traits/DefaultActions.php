<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Criteria\OrderCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

trait DefaultActions
{
	public function __call($method, $parameters)
	{
		$request = $this->getRequest();
		switch ($method){
			case 'index':
				return call_user_func_array(array($this, 'index_'), [$request]);
				break;
			case 'show':
				return call_user_func_array(array($this, 'show_'),$parameters);
				break;
			case 'store':
				return call_user_func_array(array($this, 'store_'),array_merge([$request],$parameters));
				break;
			case 'update':
				return call_user_func_array(array($this, 'update_'),array_merge([$request],$parameters));
				break;
			case 'destroy':
				return call_user_func_array(array($this, 'destroy_'),$parameters);
				break;
			case 'excluir':
				return call_user_func_array(array($this, 'excluir_'),array_merge([$request],$parameters));
				break;
			case 'restaurar':
				return call_user_func_array(array($this, 'restaurar_'),array_merge([$request],$parameters));
				break;
			case 'trasheds':
				return call_user_func_array(array($this, 'trasheds_'),array_merge([$request],$parameters));
				break;
		}
	}

    /**
     * Consultar
     *
     *
     * Endpoint para consultar todos os Anuncio cadastrados
     *
     * Nessa consulta pode ser aplicado os seguintes filtros:
     *
     *  - Consultar Normal:
     *   <br> - Não passar parametros
     *
     *  - Consultar por Cidade:
     *   <br> - ?consulta={"filtro": {"estados.uf": "TO", "cidades.titulo" : "Palmas"}}
     */
    public function index_(Request $request){
        try{
			$paginacao = $request->get('totalitems',self::$_PAGINATION_COUNT);
			if($paginacao > 20){
				$paginacao = 20;
			}

			return $this->defaultRepository
				->pushCriteria(new $this->defaultCriteria($request))
				->pushCriteria(new $this->defaultOrder($request))
				->paginate($paginacao);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
    }

    /**
     * Consulta  por ID
     *
     * Endpoint para consultar passando o ID como parametro
     *
     * @param $id
     * @return retorna um registro
     */
    public function show_($id){
        try{
            return $this->defaultRepository->find($id);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
    }

    /**
     * Cadastrar
     *
     * Endpoint para cadastrar
     *
     * @param Request $request
     * @return retorna um registro criado
     */
    public function store_(Request $request){
        $data = $this->getValidator()->getOnlyDataFields();
        \Validator::make($data, $this->getValidator()->rules())->validate();
        try{
			\DB::beginTransaction();
			$model = $this->defaultRepository->create($data);
			\DB::commit();
            return $model;
        }catch (ModelNotFoundException | RepositoryException | \Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
    }

    /**
     * Alterar
     *
     * Endpoint para alterar
     *
     * @param Request $request
     * @param $id
     * @return retorna registro alterado
     */
    public function update_(Request $request, $id){
        $data = $this->getValidator()->getOnlyDataFields();
        \Validator::make($data, $this->getValidator()->rules($id))->validate();
        try{
            return $this->defaultRepository->update($data,$id);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
    }

    /**
     * Destoy
     *
     * Endpoint para deletar passando o ID
     */
    public function destroy_($id){
        try{
            $this->defaultRepository->delete($id);
            return self::responseSuccess(self::HTTP_CODE_OK, self::MSG_REGISTRO_EXCLUIDO);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
    }

    /**
     * Exlcuir
     *
     * Endpoint para deletar passando o ID
     */
    public function excluir_(Request $request){
        $data = $request->all();
        \Validator::make($data, [
            'ids'=>'array|required'
        ])->validate();

        try{
            app($this->defaultRepository->model())->destroy($data['ids']);
            return self::responseSuccess(self::HTTP_CODE_OK, self::MSG_REGISTRO_EXCLUIDO);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
    }

	/**
	 * Lixeira
	 * @param Request $request
	 * @return mixed
	 */
    public function trasheds_(Request $request){
        $request->merge(['lixeira'=>true]);
        try{
            return $this->defaultRepository
                ->pushCriteria(new $this->defaultCriteria($request))
                ->pushCriteria(new $this->defaultOrder($request))
                ->paginate(self::$_PAGINATION_COUNT);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
    }

    /**
     * Restaurar
     *
     * Endpoint para deletar passando o ID
     */
    public function restaurar_(Request $request){
        $data = $request->all();
        \Validator::make($data, [
            'ids'=>'array|required'
        ])->validate();

        try{
            app($this->defaultRepository->model())->withTrashed()
                ->whereIn('id', $data['ids'])
                ->restore();
            return self::responseSuccess(self::HTTP_CODE_OK, self::MSG_REGISTRO_RESTAURADO);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage(),
				'arquivo'=>$e->getFile(),
				'linha'=>$e->getLine()]));
        }
    }


}
