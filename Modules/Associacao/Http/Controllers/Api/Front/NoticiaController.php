<?php

namespace Modules\Associacao\Http\Controllers\Api\Front;

use Modules\Associacao\Criteria\NoticiaCriteria;
use Modules\Associacao\Services\NoticiaService;
use Modules\Associacao\Http\Requests\NoticiaRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class NoticiaController extends BaseController implements ICustomController
{

	/**
	 * @var  NoticiaCriteria
	 */
	private $noticiaCriteria;

	/**
	 * @var  NoticiaService
	 */
	private $noticiaService;

	public function __construct(NoticiaService $noticiaService, NoticiaCriteria $noticiaCriteria)
	{
		parent::__construct($noticiaService->getDefaultRepository(), $noticiaCriteria);
		$this->noticiaCriteria = $noticiaCriteria;
		$this->noticiaService = $noticiaService;
	}

	public function getValidator()
	{
		return new NoticiaRequest();
	}


}

