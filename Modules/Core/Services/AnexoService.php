<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\AnexoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class AnexoService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  AnexoRepository
	 */
	private $anexoRepository;

	public function __construct(AnexoRepository $anexoRepository)
	{
		$this->anexoRepository = $anexoRepository;
	}

	public function getDefaultRepository()
	{
		return $this->anexoRepository;
	}
}
