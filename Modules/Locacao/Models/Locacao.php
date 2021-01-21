<?php

namespace Modules\Locacao\Models;

use App\Models\BaseModel;
use Modules\Core\Models\Anexo;

class Locacao extends BaseModel
{

    protected $table = "locacoes";


    protected $fillable = [
        "nome",
        "categoria_locacao_id",
        "capacidade",
        "status",
        "descricao",
        "valor_locacao",
        "custo_operacional",
        "url_360",
        "filial_id"
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaLocacao::class, 'categoria_locacao_id');
    }

    public function comodidade()
    {
        return $this->belongsToMany(Comodidade::class, 'locacao_comodidades', 'locacao_id', 'comodidade_id');
    }

    public function anexo()
    {
        return $this->morphOne(Anexo::class, 'anexotable');
    }

    public function anexos()
    {
        return $this->morphMany(Anexo::class, 'anexotable');
    }
}
