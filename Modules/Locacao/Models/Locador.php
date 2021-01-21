<?php

namespace Modules\Locacao\Models;

use App\Models\BaseModel;
use Modules\Core\Models\Anexo;
use Modules\Core\Models\Pessoa;
use Modules\Core\Models\User;

class Locador extends BaseModel
{

    protected $table = "locadores";


    protected $fillable = [
        "user_id", "pessoa_id"
    ];

    public function pessoa(){
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function anexo(){
        return $this->morphOne(Anexo::class, 'anexotable');
    }
}
