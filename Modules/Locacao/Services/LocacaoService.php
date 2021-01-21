<?php

namespace Modules\Locacao\Services;

use Modules\Core\Services\AnexoService;
use Modules\Locacao\Models\Locacao;
use Modules\Locacao\Presenters\LocacaoPresenter;
use Modules\Locacao\Repositories\LocacaoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class LocacaoService extends BaseService implements IService
{
    use ResponseActions;

    /**
     * @var  LocacaoRepository
     */
    private $locacaoRepository;

    private $path;
    /**
     * @var AnexoService
     */
    private $anexoService;

    public function __construct(LocacaoRepository $locacaoRepository, AnexoService $anexoService)
    {
        $this->locacaoRepository = $locacaoRepository;
        $this->path = '/arquivos/img/locacao/';
        $this->anexoService = $anexoService;
    }

    public function getDefaultRepository()
    {
        return $this->locacaoRepository;
    }

    public function get(int $id = null, bool $presenter = false)
    {
        if (is_null($id))
            return $this->getDefaultRepository()->skipPresenter($presenter)->first();

        return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store($data)
    {
        try {
            /**
             * @param $locacao Locacao
             */
            $locacao = $this->getDefaultRepository()->skipPresenter(true)->create($data);
            if(isset($data['comodidades'])){
                $locacao->comodidade()->attach($data['comodidades']);
            }
            return self::transformerData($locacao, LocacaoPresenter::class);
        } catch (\Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function update($id, $data)
    {
        try {
            $locacao = $this->get($id, true);
            $locacao->comodidade()->detach();
            if(isset($data['comodidades'])){
                $locacao->comodidade()->sync($data['comodidades']);
            }
            return self::transformerData($locacao, LocacaoPresenter::class);
        } catch (\Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function addImage($id, $data)
    {
        try {
            $locacao = $this->get($id, true);
            $this->addAnexo($locacao, $data, $this->path);
            return ['data' => ['id' => $locacao->anexo->id]];
        } catch (\Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function removeImage($id)
    {
        try {
            $this->anexoService->getDefaultRepository()->delete($id);
            return self::responseSuccess(self::$HTTP_CODE_OK, 'Removida Adicionada!');
        } catch (\Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function listaLocacoes()
    {
        try {
            return $this->getDefaultRepository()->all();
        } catch (\Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }
}
