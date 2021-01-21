<?php

namespace Modules\Core\Models;

use Illuminate\Support\Arr;
use Modules\Core\Services\DashboardService;
use Modules\Saude\Enuns\DashBoardModeloSaudeEnum;
use App\Models\BaseModel;

class Dashboard extends BaseModel
{
    protected $fillable = [
        "grupo_id", "modelo_dashboard"
    ];

    public function modelo()
    {
        $tag = $this->getAttribute('modelo_dashboard');
        return Arr::first(
            array_remove_null(array_map(function ($item) use ($tag){
                if($item['tag'] == $tag)
                    return  $item;
            }, DashboardService::listDashborads()))
        );
    }
}
