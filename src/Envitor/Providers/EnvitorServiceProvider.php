<?php

namespace Envitor\Providers;

use Envitor\Support\Editor;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class EnvitorServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAppBindings();
    }

	protected function registerAppBindings()
	{
		App::singleton('dotenv', Editor::class);
	}
}
