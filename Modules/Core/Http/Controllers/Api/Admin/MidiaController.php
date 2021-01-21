<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Modules\Core\Criteria\MidiaCriteria;
use Modules\Core\Services\MidiaService;
use Modules\Core\Http\Requests\MidiaRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class MidiaController extends BaseController implements ICustomController
{

	/**
	 * @var  MidiaCriteria
	 */
	private $midiaCriteria;

	/**
	 * @var  MidiaService
	 */
	private $midiaService;

	public function __construct(MidiaService $midiaService, MidiaCriteria $midiaCriteria)
	{
		parent::__construct($midiaService->getDefaultRepository(), $midiaCriteria);
		$this->midiaCriteria = $midiaCriteria;
		$this->midiaService = $midiaService;
	}

	public function getValidator($id = null)
	{
		return new MidiaRequest();
	}
}

