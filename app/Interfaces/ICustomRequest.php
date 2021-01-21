<?php

namespace App\Interfaces;

/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 15:31
 */
interface ICustomRequest
{
	public function rules($id = null);

	public function getOnlyFields();
}
