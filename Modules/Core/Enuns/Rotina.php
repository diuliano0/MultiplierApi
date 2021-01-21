<?php

namespace Modules\Core\Enuns;

use App\Enuns\BaseEnum;
use App\Traits\Hydrator;
use App\Traits\ToArray;

class Rotina extends BaseEnum
{
	use ToArray, Hydrator;

	private $id;
	private $nome;
	private $url;
	private $isMenu;
	private $modulo;
	private $rotina;

	public function __construct($rotina = null)
	{
		if(!is_null($rotina)){
			$this->rotina = $rotina;
			$this->id = $rotina;
			$this->hydrate($rotina);
		}
	}

	/**
	 * USUÁRIOS
	 */
	public const GERENCIAR_USUARIOS = "USUARIO1";
	public const INSERIR_USUARIO = "USUARIO2";
	public const EDITAR_USUARIO = "USUARIO3";
	public const EXCLUIR_USUARIO = "USUARIO4";
	public const PERFIL_USUARIO = "USUARIO5";

	/**
	 * FILIAIS
	 */
	public const GERENCIAR_FILIAIS = "FILIAL1";
	public const INSERIR_FILIAL = "FILIAL2";
	public const EDITAR_FILIAL = "FILIAL3";

	/**
	 * GRUPOS
	 */
	public const GERENCIAR_GRUPOS = "GRUPO1";
	public const INSERIR_GRUPO = "GRUPO2";
	public const EDITAR_GRUPO = "GRUPO3";
	public const EXCLUIR_GRUPO = "GRUPO4";
	public const ALTERAR_PERMISSOES_GRUPO = "GRUPO5";

	/**
	 * MODELOS DE DOCUMENTOS
	 */
	public const INSERIR_MODELO_DOCUMENTO = "MODELDOC1";
	public const EDITAR_MODELO_DOCUMENTO = "MODELDOC2";
	public const EXCLUIR_MODELO_DOCUMENTO = "MODELDOC3";


	/**
	 * MODELOS DE NOTIFICAÇÃO
	 */
	public const INSERIR_MODELO_NOTIFICACAO = "MODELNOT1";
	public const EDITAR_MODELO_NOTIFICACAO = "MODELNOT2";
	public const EXCLUIR_MODELO_NOTIFICACAO = "MODELNOT3";

	/**
	 * ÍNDICES
	 */
	public const INSERIR_INDICE = "INDICE1";
	public const EDITAR_INDICE = "INDICE2";
	public const EXCLUIR_INDICE = "INDICE3";

	/**
	 * ÚNIDADE DE MEDIDA
	 */
	public const INSERIR_UNIDADE_MEDIDA = "UNIDADE1";
	public const EDITAR_UNIDADE_MEDIDA = "UNIDADE2";
	public const EXCLUIR_UNIDADE_MEDIDA = "UNIDADE3";

	/**
	 * PARÂMETROS GLOBAIS
	 */
	public const CONFIG_PARAMETROS_GLOBAIS = "PARAMGLOBAL1";

	/**
	 *PARÂMETROS PARA ENVIO DE E-MAIL
	 */
	public const CONFIG_PARAMETROS_EMAIL = "PARAMEMAIL1";

	/**
	 * PARÂMETROS PARA INTEGRAÇÃO COM SITE DO CLIENTE
	 */
	public const CONFIG_PARAMETROS_OLX = "PARAMOLX1";

	/**
	 *PARÂMETROS PARA INTEGRAÇÃO COM SITE DO CLIENTE
	 */
	public const CONFIG_PARAMETROS_SITE = "PARAMSITECLI1";

	/**
	 *PARÂMETROS PARA INTEGRAÇÃO COM SITE DO CLIENTE
	 */
	public const INSERIR_CONTAS_PAGAR = "CONTAPAGAR1";


	protected static $typeLabels = [
		self::GERENCIAR_USUARIOS => ["Gerenciar Usuários", "gerenciar_usuarios", false, Modulo::ADMINISTRATIVO],
		self::INSERIR_USUARIO => ["Inserir Usuários", "inserir_usuarios", false, Modulo::ADMINISTRATIVO],
		self::EDITAR_USUARIO => ["Editar Usuários", "inserir_usuario", false, Modulo::ADMINISTRATIVO],
		self::EXCLUIR_USUARIO => ["Excluir Usuários", "inserir_usuario", false, Modulo::ADMINISTRATIVO],
		self::PERFIL_USUARIO => ["Perfil de Usuário", "perfil_usuario", false, Modulo::ADMINISTRATIVO],

		self::GERENCIAR_FILIAIS => ["Gerenciar Filiais", "gerenciarfiliais", false, Modulo::ADMINISTRATIVO],
		self::INSERIR_FILIAL => ["Gerenciar Filiais", "gerenciarfiliais", false, Modulo::ADMINISTRATIVO],
		self::GERENCIAR_FILIAIS => ["Gerenciar Filiais", "gerenciarfiliais", false, Modulo::ADMINISTRATIVO],

		self::GERENCIAR_GRUPOS => ["Gerenciar Grupos", "listar_grupos", true, Modulo::ADMINISTRATIVO],
		self::INSERIR_GRUPO => ["Inserir Grupo", "inserir_grupo", false, Modulo::ADMINISTRATIVO],
		self::EDITAR_GRUPO => ["Edição do Grupo", "listar_grupos", false, Modulo::ADMINISTRATIVO],
		self::EXCLUIR_GRUPO => ["Excluir Grupo", "listar_grupos", false, Modulo::ADMINISTRATIVO],
		self::ALTERAR_PERMISSOES_GRUPO => ["Alteração de Permissões", "listar_grupos", false, Modulo::ADMINISTRATIVO],


		self::INSERIR_MODELO_DOCUMENTO => ["Inserir Modelo", "inserir_modelo_doc", false, Modulo::ADMINISTRATIVO],
		self::EDITAR_MODELO_DOCUMENTO => ["Editar Modelo", "lista_modelo_doc", false, Modulo::ADMINISTRATIVO],
		self::EXCLUIR_MODELO_DOCUMENTO => ["Inserir Modelo", "lista_modelo_doc", false, Modulo::ADMINISTRATIVO],

		self::INSERIR_MODELO_NOTIFICACAO => ["Inserir Modelo", "inserir_modelo_not", false, Modulo::ADMINISTRATIVO],
		self::EDITAR_MODELO_NOTIFICACAO => ["Editar Modelo", "lista_modelo_not", false, Modulo::ADMINISTRATIVO],
		self::EXCLUIR_MODELO_NOTIFICACAO => ["Excluir Unidade", "lista_unidade_medida", false, Modulo::ADMINISTRATIVO],

		self::CONFIG_PARAMETROS_GLOBAIS => ["Configurar Parâmetros Globais", "config_geral", false, Modulo::ADMINISTRATIVO],

		self::CONFIG_PARAMETROS_EMAIL => ["Configurar Parâmetros de E-mail", "config_envio_email", false, Modulo::ADMINISTRATIVO],

		self::CONFIG_PARAMETROS_OLX => ["Configurar Parâmetros da Integração OLX", "config_integracao_olx", false, Modulo::ADMINISTRATIVO],

		self::CONFIG_PARAMETROS_SITE => ["Configurar Parâmetros da Integração", "config_integracao_site", false, Modulo::ADMINISTRATIVO],

		self::INSERIR_CONTAS_PAGAR => ["Inserir Conta a Pagar", "inserir_conta_pagar", true, Modulo::FINANCEIRO],
	];


	/**
	 * @return array
	 */
	public static function labels()
	{
		return array_map(function ($item){
			return [
				'nome'=>$item[0],
				'url'=>$item[1],
				'isMenu'=>$item[2],
				'modulo'=>$item[3]
			];
		},static::$typeLabels);
	}

}
