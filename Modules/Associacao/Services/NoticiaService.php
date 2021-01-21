<?php

namespace Modules\Associacao\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Associacao\Presenters\NoticiaPresenter;
use Modules\Associacao\Repositories\NoticiaRepository;
use Modules\Core\Services\DBService;
use Modules\Core\Services\ImageUploadService;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class NoticiaService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  NoticiaRepository
	 */
	private $noticiaRepository;

	private $path;
	/**
	 * @var ImageUploadService
	 */
	private $imageUploadService;

	public function __construct(
		NoticiaRepository $noticiaRepository,
		ImageUploadService $imageUploadService)
	{
		$this->noticiaRepository = $noticiaRepository;
		$this->path = '/arquivos/img/noticia/';
		$this->imageUploadService = $imageUploadService;
	}

	public function getDefaultRepository()
	{
		return $this->noticiaRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}



	public function update($data, $id)
	{
		try{
			DBService::beginTransaction();


			$noticia = $this->get($id, true);

			$noticia->fill($data);

			if (isset($data['anexo'])) {

				try {

					$this->createAnexo($noticia, $data, $this->path);
					$trabalhador = $this->get($id, true);
					$this->imageUploadService->cropPhoto('arquivos/img/noticia/' . $trabalhador->anexo->nome, array(
						'width' => 500,
						'height' => 500,
						'grayscale' => false
					), 'arquivos/img/noticia/img_230_160_' . $trabalhador->anexo->nome);

				} catch (\Exception $e) {

					return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

				}

			}

			$noticia->update();

			DBService::commit();

			return self::transformerData($noticia, NoticiaPresenter::class);
		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {

			\DB::rollBack();

			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

		}
	}

	public function create($data)
	{
		try{
			DBService::beginTransaction();
			$noticia = $this->getDefaultRepository()->skipPresenter(true)->create($data);

			if (isset($data['anexo'])) {

				try {

					$this->createAnexo($noticia, $data, $this->path);
					$trabalhador = $this->get($noticia->id, true);
					$this->imageUploadService->cropPhoto('arquivos/img/noticia/' . $trabalhador->anexo->nome, array(
						'width' => 500,
						'height' => 500,
						'grayscale' => false
					), 'arquivos/img/noticia/img_230_160_' . $trabalhador->anexo->nome);

				} catch (\Exception $e) {

					return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

				}

			}

			$noticia->update();

			DBService::commit();

			return self::transformerData($noticia, NoticiaPresenter::class);
		} catch (ModelNotFoundException | RepositoryException | \Exception $e) {

			\DB::rollBack();

			return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));

		}
	}
}
