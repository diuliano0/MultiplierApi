<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\ModulosAtivoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class ModulosAtivoService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  ModulosAtivoRepository
	 */
	private $modulosativoRepository;

	public function __construct(ModulosAtivoRepository $modulosativoRepository)
	{
		$this->modulosativoRepository = $modulosativoRepository;
	}

	public function getDefaultRepository()
	{
		return $this->modulosativoRepository;
	}
}
