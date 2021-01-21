<?php

namespace Modules\Locacao\Services;

use Modules\Locacao\Repositories\ComodidadeRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class ComodidadeService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  ComodidadeRepository
	 */
	private $comodidadeRepository;

	public function __construct(ComodidadeRepository $comodidadeRepository)
	{
		$this->comodidadeRepository = $comodidadeRepository;
	}

	public function getDefaultRepository()
	{
		return $this->comodidadeRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}
}
