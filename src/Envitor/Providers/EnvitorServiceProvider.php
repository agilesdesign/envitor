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

    /**
     * Register bindings into the container
     */
    protected function registerAppBindings()
    {
        App::singleton('envitor', new Editor(base_path('.env')));
    }
}
