<?php

namespace Modules\Locacao\Services;

use Modules\Locacao\Repositories\FaturaRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class FaturaService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  FaturaRepository
	 */
	private $faturaRepository;

	public function __construct(FaturaRepository $faturaRepository)
	{
		$this->faturaRepository = $faturaRepository;
	}

	public function getDefaultRepository()
	{
		return $this->faturaRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}
}
