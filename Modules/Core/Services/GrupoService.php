<?php

namespace Modules\Core\Services;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Enuns\Rotina;
use Modules\Core\Repositories\GrupoRepository;
use Modules\Core\Transformers\GrupoTransformer;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class GrupoService extends BaseService implements IService
{
    use ResponseActions;
    /**
     * @var GrupoRepository
     */
    private $grupoRepository;
    /**
     * @var Rotina
     */
    private $rotina;

    public function __construct(GrupoRepository $grupoRepository, Rotina $rotina)
    {
        $this->grupoRepository = $grupoRepository;
        $this->rotina = $rotina;
    }

    public function update($data, $id)
    {
        try {
            DBService::beginTransaction();
            $grupo = $this->grupoRepository->skipPresenter(true)->update($data, $id);
            $rotinaClass = $this->rotina;
            if (isset($data['permissoes'])) {
                $grupo->permissoes()->delete();
                array_map(function ($rotina) use ($grupo, $rotinaClass) {
                    $modulo = $rotinaClass->getModulo($rotina['rotina']);
                    $grupo->permissoes()->create([
                        'grupo_id' => $grupo->id,
                        'rotina' => $rotina['rotina'],
                        'modulo' => $modulo['id'],
                        'rotina_modulo' => $modulo['tipo_rotina'],
                    ]);
                }, $data['permissoes']);
            }
            if (isset($data['rotas'])) {
                $grupo->rotas()->sync($data['rotas']);

            }

            if (isset($data['dashboards'])) {
                $grupo->dashboards()->delete();
                foreach ($data['dashboards'] as $item)
                    $grupo->dashboards()->create(["modelo_dashboard" => $item]);


            }
            DBService::commit();
            return $this->grupoRepository->skipPresenter(false)->find($grupo->id);
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            \DB::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function create($data)
    {
        try {
            DBService::beginTransaction();
            $grupo = $this->grupoRepository->skipPresenter(true)->create($data);
            $rotinaClass = $this->rotina;
            if (isset($data['permissoes'])) {
                array_map(function ($permissao) use ($grupo, $rotinaClass) {
                    $modulo = $rotinaClass->getModulo($permissao['rotina']);
                    $grupo->permissoes()->create([
                        'grupo_id' => $grupo->id,
                        'rotina' => $permissao['rotina'],
                        'modulo' => $modulo['id'],
                        'rotina_modulo' => $modulo['tipo_rotina'],
                    ]);
                }, $data['permissoes']);
            }
            if (isset($data['rotas'])) {
                $grupo->rotas()->attach($data['rotas']);
            }
            if (isset($data['dashboards'])) {
                $grupo->dashboards()->delete();
                foreach ($data['dashboards'] as $item)
                    $grupo->dashboards()->create(["modelo_dashboard" => $item]);
            }
            DBService::commit();
            return $this->grupoRepository->skipPresenter(false)->find($grupo->id);
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            \DB::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function getDefaultRepository()
    {
        return $this->grupoRepository;
    }

    public function deleteOnCascade($id)
    {
        try {
            DBService::beginTransaction();
            $rota = $this->getDefaultRepository()->skipPresenter(true)->find($id);
            $rota->delete($id);
            DBService::commit();
            return self::responseSuccess(self::$HTTP_CODE_OK, self::$MSG_REGISTRO_EXCLUIDO);
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }
}
