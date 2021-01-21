<?php

namespace Modules\Associacao\Models;

use App\Models\BaseModel;
use Modules\Core\Models\Anexo;

class BannerAssociado extends BaseModel
{

    protected $fillable = [
        "titulo", "data_limite", "prioridade", "status", "url"
    ];

    public function anexo(){
        return $this->morphOne(Anexo::class, 'anexotable');
    }

}
