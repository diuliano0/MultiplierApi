<?php

namespace Modules\Core\Services;

use Modules\Core\Repositories\NotificacaoRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;

class NotificacaoService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  NotificacaoRepository
	 */
	private $notificacaoRepository;

	public function __construct(NotificacaoRepository $notificacaoRepository)
	{
		$this->notificacaoRepository = $notificacaoRepository;
	}

	public function getDefaultRepository()
	{
		return $this->notificacaoRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}
}
