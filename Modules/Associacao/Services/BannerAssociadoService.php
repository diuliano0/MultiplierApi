<?php

namespace Modules\Associacao\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Associacao\Models\BannerAssociado;
use Modules\Associacao\Presenters\BannerAssociadoPresenter;
use Modules\Associacao\Repositories\BannerAssociadoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Modules\Core\Services\DBService;
use Modules\Core\Services\ImageUploadService;
use Prettus\Repository\Exceptions\RepositoryException;

class BannerAssociadoService extends BaseService implements IService
{
    use ResponseActions;

    /**
     * @var  BannerAssociadoRepository
     */
    private $bannerassociadoRepository;
    /**
     * @var ImageUploadService
     */
    private $imageUploadService;

    private $path;

    public function __construct(BannerAssociadoRepository $bannerassociadoRepository,
                                ImageUploadService $imageUploadService)
    {
        $this->bannerassociadoRepository = $bannerassociadoRepository;
        $this->imageUploadService = $imageUploadService;
        $this->path = '/arquivos/img/banner-associado/';
    }

    public function getDefaultRepository()
    {
        return $this->bannerassociadoRepository;
    }

    public function get(int $id = null, bool $presenter = false)
    {
        if (is_null($id))
            return $this->getDefaultRepository()->skipPresenter($presenter)->first();

        return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

    }

    public function create($data)
    {

        try {

            DBService::beginTransaction();
            $bannerAssociado = $this->getDefaultRepository()->skipPresenter(true)->create($data);
            if (isset($data['anexo'])) {
                try {
                    $this->createAnexo($bannerAssociado, $data, $this->path);
                    $this->imageUploadService->cropPhoto('arquivos/img/banner-associado/' . $data['anexo']['conteudo'], array(
                        'width' => 750,
                        'height' => 200,
                        'grayscale' => false,
                        'crop' => true
                    ), 'arquivos/img/banner-associado/img_230_160_' . $data['anexo']['conteudo']);
                } catch (\Exception $e) {
                    return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
                }
            }
            $bannerAssociado->update();
            DBService::commit();
            return self::transformerData($bannerAssociado, BannerAssociadoPresenter::class);

        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

        }
    }

    public function update($data, $id)
    {
        try {
            DBService::beginTransaction();
            $bannerAssociado = $this->getDefaultRepository()->skipPresenter(true)->find($id);
            $bannerAssociado->fill($data);
            if (isset($data['anexo'])) {
                try {
                    $this->createAnexo($bannerAssociado, $data, $this->path);
                    $this->imageUploadService->cropPhoto('arquivos/img/banner-associado/' . $bannerAssociado->anexo->nome, array(
                        'width' => 750,
                        'height' => 200,
                        'grayscale' => false,
                        'crop' => true
                    ), 'arquivos/img/banner-associado/img_230_160_' . $bannerAssociado->anexo->nome);
                } catch (\Exception $e) {
                    return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
                }

            }
            $bannerAssociado->update();
            DBService::commit();
            return self::transformerData($bannerAssociado, BannerAssociadoPresenter::class);
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

        }
    }

    public function bannerAleatorio()
    {
        try {
            return self::transformerData(BannerAssociado::inRandomOrder()->first(), BannerAssociadoPresenter::class);
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

        }
    }
}
