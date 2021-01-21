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

class Grupo extends BaseEnum
{
	use ToArray, Hydrator;

	public const ADMINISTRATIVO = 1;
	public const OPERADORES = 2;
	public const FINANCEIRO = 3;
	public const ATENDENTE = 4;
	public const REPRESENTANTE = 5;
	public const PRESTADOR_SERVICO = 6;
	public const BENEFICIARIO = 7;
	public const SUPERVISOR_MEDBRASIL = 9;
	public const BENEFICIARIO_GERAL_MEDBRASIL = 10;
	public const ASSOCIACAO = 11;
	public const LOCACAO = 12;
	public const LOCADOR = 15;

	private $id;
	private $descricao;

	public function __construct($modulo = null)
	{
		if (!is_null($modulo)) {
			$this->hydrate($modulo);
		}
	}

	protected static $typeLabels = [
		self::ADMINISTRATIVO => [self::ADMINISTRATIVO, "Administrativo"],
		self::OPERADORES => [self::OPERADORES, "Operadores"],
		self::FINANCEIRO => [self::FINANCEIRO, "Financeiro"],
		self::ATENDENTE => [self::ATENDENTE, "Atendente"],
		self::REPRESENTANTE => [self::REPRESENTANTE, "Representante"],
		self::PRESTADOR_SERVICO => [self::PRESTADOR_SERVICO, "Prestador de serviços"],
		self::BENEFICIARIO => [self::BENEFICIARIO, "Beneficiário"],
		self::SUPERVISOR_MEDBRASIL => [self::SUPERVISOR_MEDBRASIL, "Supervisor Medbrasil"],
		self::BENEFICIARIO_GERAL_MEDBRASIL => [self::BENEFICIARIO_GERAL_MEDBRASIL, "MedBrasil Beneficiario Geral"],
		self::ASSOCIACAO => [self::ASSOCIACAO, "Associação"],
		self::LOCACAO => [self::LOCACAO, "Locacao"],
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
				'nome' => $item[1],
			];
		}, static::$typeLabels);
	}

}
