<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 30/01/2018
 * Time: 09:36
 */

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\InsertFilialTrait;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as IAuditable;

class BaseModel extends Model implements IAuditable
{
	use Auditable, InsertFilialTrait;

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}

	public $timestamps = true;

	protected static function boot()
	{
		parent::boot();
		self::injectFilial();
	}

	protected static function getInstance($class){
		return app($class);
	}
}
