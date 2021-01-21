<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\MidiaRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class MidiaService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  MidiaRepository
	 */
	private $midiaRepository;

	public function __construct(MidiaRepository $midiaRepository)
	{
		$this->midiaRepository = $midiaRepository;
	}

	public function getDefaultRepository()
	{
		return $this->midiaRepository;
	}
}
