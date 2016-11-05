<?php
namespace Zjien\Quantum\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Zjien\Quantum\Generator\Command\MigrationGenerateCommand;

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
        $this->registerCommand();
        $this->registerAccessPolicy();
    }

    /**
     * register all command
     *
     * @return void
     */
    protected function registerCommand()
    {
        $this->commands(MigrationGenerateCommand::class);//register command
    }

    protected function registerQuantum()
    {
        $this->app->singleton('quantum', function ($app) {
//            return
        });
    }

    protected function registerAccessPolicy()
    {
        Gate::before(function ($user, $uri, $method) {
            $roles = $user->roles;

            $resource = explode('/', trim($uri, '/'))[0];

            foreach ($roles as $role) {
                $permissions = $role->permissions;
                foreach ($permissions as $perm) {
                    if ($perm::TYPE_PUBLIC == $perm->type) return true;

                    if ($perm->status == $perm::STATUS_CLOSING) return false;

                    if ($perm->uri == $uri && $perm->verb == $method) {

                            if ($perm::TYPE_PRIVATE == $perm->type) {
                                return app($resource)->find(1, [config('config.database.fields.owner')])->owner_id == $user->id;
                            }
                        return true;
                    }
                }
            }

            return false;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}