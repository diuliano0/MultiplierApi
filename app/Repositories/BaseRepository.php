<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository as BasePrettus;

abstract class BaseRepository extends BasePrettus
{


	public function __construct(Application $app)
	{
		parent::__construct($app);
	}

	public function boot()
	{
		static::scopeQuery(function ($builder) {
			return checkFilial($builder, $this->makeModel());
		});
	}


	public function model()
	{
		return $this->model;
	}

	public function onlyTrashed()
	{
		return $this->parserResult($this->model->onlyTrashed()->get());
	}

	public function paginate($limit = null, $columns = ['*'], $method = "paginate")
	{
		$paginate = parent::paginate($limit, $columns, $method);
		/*if (!isset($paginate['meta']['pagination']['links']['preview'])) {
			$paginate['meta']['pagination']['links']['preview'] = null;
		}
		if (isset($paginate['meta']['pagination']['links'])) {
			$paginate['meta']['pagination']['links']['next'] = null;
		}*/
		return $paginate;
	}

}
