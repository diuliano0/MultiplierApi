<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\ConfigUploadArquivoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class ConfigUploadArquivoService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  ConfigUploadArquivoRepository
	 */
	private $configuploadarquivoRepository;

	public function __construct(ConfigUploadArquivoRepository $configuploadarquivoRepository)
	{
		$this->configuploadarquivoRepository = $configuploadarquivoRepository;
	}

	public function getDefaultRepository()
	{
		return $this->configuploadarquivoRepository;
	}

	public function getConfig(){
		return $this->getDefaultRepository()->skipPresenter(true)->first();
	}
}
