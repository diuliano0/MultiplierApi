<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\DashboardRepository;
use Modules\Saude\Enuns\DashBoardModeloSaudeEnum;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class DashboardService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  DashboardRepository
	 */
	private $dashboardRepository;

	public function __construct(DashboardRepository $dashboardRepository)
	{
		$this->dashboardRepository = $dashboardRepository;
	}

	public function getDefaultRepository()
	{
		return $this->dashboardRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);
	}

	public static function listDashborads(){
	    return array_merge(
            class_exists(DashBoardModeloSaudeEnum::class)?DashBoardModeloSaudeEnum::labels():[]
        );
    }
}
