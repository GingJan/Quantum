<?php
namespace Zjien\Quantum\Providers;

use Illuminate\Support\ServiceProvider;
use Zjien\Quantum\Generator\Command\MigrationGenerateCommand;
use Zjien\Quantum\Quantum;

class QuantumServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('quantum.php'),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'quantum');

    }

    public function register()
    {
        $this->registerCommands();
        $this->app->singleton('quantum', function($app){
            return new Quantum($app);
        });
    }

    /**
     * Register all commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands(MigrationGenerateCommand::class);//register command
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['quantum'];
    }
}