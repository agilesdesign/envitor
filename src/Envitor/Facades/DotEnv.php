<?php

namespace Envitor\Facades;

use Illuminate\Support\Facades\Facade;

class DotEnv extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'dotenv';
	}
}