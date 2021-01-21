<?php

namespace Modules\Core\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Models\Device;
use Modules\Core\Presenters\DevicePresenter;
use Modules\Core\Repositories\DeviceRepository;
use App\Interfaces\IService;
use App\Services\BaseService;
use App\Traits\ResponseActions;
use Prettus\Repository\Exceptions\RepositoryException;

class DeviceService extends BaseService implements IService
{
	use ResponseActions;

	/**
	 * @var  DeviceRepository
	 */
	private $deviceRepository;

	public function __construct(DeviceRepository $deviceRepository)
	{
		$this->deviceRepository = $deviceRepository;
	}

	public function getDefaultRepository()
	{
		return $this->deviceRepository;
	}

	public function get(int $id = null, bool $presenter = false)
	{
		if (is_null($id))
			return $this->getDefaultRepository()->skipPresenter($presenter)->first();

		return $this->getDefaultRepository()->skipPresenter($presenter)->find($id);

	}

	public function registrar($data, $userId){
	    try{
            DBService::beginTransaction();
            $device = $this->getDefaultRepository()->skipPresenter(true)->findByField('uuid', $data['uuid']);
            if($device->count() > 0){
                $device = $device->first();
                /** @var Device $device */
                $data['user_id'] = $userId;
                $device->fill($data);
                $device->save();
                DBService::commit();
                return self::transformerData($device, DevicePresenter::class);
            }
	        $data['user_id'] = $userId;
	        $device = $this->getDefaultRepository()->create($data);
            DBService::commit();
            return $device;
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }

    public function desregistrar($uuid)
    {
        try{
            $device = $this->getDefaultRepository()->skipPresenter(true)->findByField('uuid', $uuid);
            if($device->count() > 0){
                $device->first()->delete();
            }
            return self::responseSuccess(self::$HTTP_CODE_OK, 'dispositivo removido');
        } catch (ModelNotFoundException | RepositoryException | \Exception $e) {
            DBService::rollBack();
            return self::responseError(self::$HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage(), 'arquivo' => $e->getFile(), 'linha' => $e->getLine()]));
        }
    }
}
