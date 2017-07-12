<?php

namespace Envitor\Facades;

use Illuminate\Support\Facades\Facade;

class Envitor extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'envitor';
	}
}