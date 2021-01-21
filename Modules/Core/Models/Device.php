<?php

namespace Modules\Core\Models;

use App\Models\BaseModel;

class Device extends BaseModel
{

    protected $fillable = [
        "id", "uuid", "token_register", "tipo_device", "status", "user_id"
    ];
}
