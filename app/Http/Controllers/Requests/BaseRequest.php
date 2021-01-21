<?php

namespace App\Http\Controllers\Request;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{

	public abstract function getOnlyFields();

	public static function removeFiels($data, array $remove)
	{
		return array_diff_key($data, array_flip($remove));
	}

	protected function getIdentificador($parametro)
	{
		$id = null;
		if ($this->route())
			$id = $this->route()->parameter($parametro);
		return $id;
	}

	public function getOnlyDataFields()
	{
		$data = $this->only(static::getOnlyFields());
		if (count($data) > 0) {
			return array_remove_null($data);
		}
		$json_array = [];
		foreach (static::getOnlyFields() as $item){
			$json_array[$item] = $this->json($item);
		}
		return array_remove_null($json_array);
	}

	protected function getField($key){
		return isset($this->getOnlyDataFields()[$key])? $this->getOnlyDataFields()[$key]: null;
	}

	protected static function injectKeyDepencence($fieldInject, $data)
	{
		return array_map(function ($item) use ($fieldInject) {
			return $fieldInject . $item;
		}, $data);
	}
}
