<?php
/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 02/03/2018
 * Time: 10:33
 */

namespace Modules\Locacao\Enuns;


use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class ReservaStatusEnum extends BaseEnum
{
	use ToArray, Hydrator;

	public const PARCIALMENTE_PAGO = 0;
	public const PAGO = 1;
	public const CANCELADO = 2;
	public const RESERVADO = 3;

	private $descricao;

	public function __construct($modulo = null)
	{
		if(!is_null($modulo)){
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::PARCIALMENTE_PAGO => [self::PARCIALMENTE_PAGO, "Parcialmente Pago"],
		self::PAGO => [self::PAGO, "Pago"],
		self::CANCELADO => [self::CANCELADO, "Cancelado"],
		self::RESERVADO => [self::RESERVADO, "Reservado"],
	];

	/**
	 * @return array
	 */
	/**
	 * @return array
	 */
	public static function labels()
	{
		return array_map(function ($item){
			return [
				'id'=>$item[0],
				'descricao'=>$item[1],
			];
		},static::$typeLabels);
	}

}
