<?php

namespace Modules\Core\Http\Controllers\Api\Front;

use Modules\Core\Criteria\DeviceCriteria;
use Modules\Core\Services\DeviceService;
use Modules\Core\Http\Requests\DeviceRequest;
use App\Http\Controllers\BaseController;
use App\Interfaces\ICustomController;

class DeviceController extends BaseController implements ICustomController
{

	/**
	 * @var  DeviceCriteria
	 */
	private $deviceCriteria;

	/**
	 * @var  DeviceService
	 */
	private $deviceService;

	public function __construct(DeviceService $deviceService, DeviceCriteria $deviceCriteria)
	{
		parent::__construct($deviceService->getDefaultRepository(), $deviceCriteria);
		$this->deviceCriteria = $deviceCriteria;
		$this->deviceService = $deviceService;
	}

	public function getValidator()
	{
		return new DeviceRequest();
	}

	public function registrar(DeviceRequest $deviceRequest){
	    $data = $deviceRequest->getOnlyDataFields();
        $data['tipo_device'] = $this->getRequest()->header('User-Agent');
	    return $this->deviceService->registrar($data, $this->getUserId());
    }

    public function desregistrar($uuid){
        return $this->deviceService->desregistrar($uuid);
    }
}

