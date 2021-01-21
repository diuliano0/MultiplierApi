<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 02/03/2018
 * Time: 10:33
 */

namespace Modules\Core\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class EmailBeneficioEnum extends BaseEnum
{
    use ToArray, Hydrator;

    public const NUTRICIONISTA = 0;
    public const ODONTO_MOVEL = 1;
    public const SERVICO_SOCIAL = 2;
    public const PECULIO = 3;
    public const FISIOTERAPIA = 4;
    public const AMBULANCIA = 5;
    public const SERVICO_ODONTO = 6;

    private $descricao;

    public function __construct($modulo = null)
    {
        if (!is_null($modulo)) {
            $this->hydrate($modulo);
        }
    }

    protected static $typeLabels = [
        self::NUTRICIONISTA => [self::NUTRICIONISTA, "Nutricionista"],
        self::ODONTO_MOVEL => [self::ODONTO_MOVEL, "Odonto Móvel"],
        self::SERVICO_SOCIAL => [self::SERVICO_SOCIAL, "Serviço Social"],
        self::PECULIO => [self::PECULIO, "Pecúlio"],
        self::FISIOTERAPIA => [self::FISIOTERAPIA, "Fisioterapia"],
        self::AMBULANCIA => [self::AMBULANCIA, "Ambulâcia"],
        self::SERVICO_ODONTO => [self::SERVICO_ODONTO, "Serviço Odonto"],
    ];

    /**
     * @return array
     */
    /**
     * @return array
     */
    public static function labels()
    {
        return array_map(function ($item) {
            return [
                'id' => $item[0],
                'descricao' => $item[1],
            ];
        }, static::$typeLabels);
    }

}
