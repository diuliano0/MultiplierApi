<?php

namespace Modules\Associacao\Criteria;

use App\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class TrabalhadorCriteria
 * @package  Modules\Associacao\Criteria;
 */
class TrabalhadorCriteria extends BaseCriteria
{
	protected $filterCriteria = [

		'core.pessoas.nome' => 'ilike',

		'core.pessoas.cpf_cnpj' => 'ilike',

		'associacao.trabalhadores.matricula' => 'ilike',

		'associacao.trabalhadores.id' => '=',

	];



	public function apply($model, RepositoryInterface $repository)

	{

		$model = parent::apply($model, $repository);

		return $model->join('core.pessoas', 'core.pessoas.id', '=', 'associacao.trabalhadores.pessoa_id')

			->select([\DB::raw('DISTINCT trabalhadores.*')]);

	}
}
