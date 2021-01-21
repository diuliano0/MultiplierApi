<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Modules\Core\Criteria\ConfigUploadArquivoCriteria;
use Modules\Core\Services\ConfigUploadArquivoService;
use Modules\Core\Http\Requests\ConfigUploadArquivoRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class ConfigUploadArquivoController extends BaseController implements ICustomController
{

	/**
	 * @var  ConfigUploadArquivoCriteria
	 */
	private $configuploadarquivoCriteria;

	/**
	 * @var  ConfigUploadArquivoService
	 */
	private $configuploadarquivoService;

	public function __construct(ConfigUploadArquivoService $configuploadarquivoService, ConfigUploadArquivoCriteria $configuploadarquivoCriteria)
	{
		parent::__construct($configuploadarquivoService->getDefaultRepository(), $configuploadarquivoCriteria);
		$this->configuploadarquivoCriteria = $configuploadarquivoCriteria;
		$this->configuploadarquivoService = $configuploadarquivoService;
	}

	public function getValidator($id = null)
	{
		return new ConfigUploadArquivoRequest();
	}


}

