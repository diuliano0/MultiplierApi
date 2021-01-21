<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Models\BuscaAlerta
 *
 * @property int $id
 * @property int $user_id
 * @property string $url
 * @property string $titulo
 * @property string $nome
 * @property bool $ativar_alarme
 * @property string $email
 * @property string $tipo_frequencia
 * @property int $horario
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereNome($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereAtivarAlarme($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereTipoFrequencia($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereHorario($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BuscaAlerta whereDeletedAt($value)
 * @mixin \Eloquent
 */
class BuscaAlerta extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

}
