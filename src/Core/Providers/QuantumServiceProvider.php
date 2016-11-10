<?php
namespace Zjien\Quantum\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $this->registerCommands();
        $this->registerAccessPolicy();
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
     * Register policy.
     *
     * @return void
     */
    protected function registerAccessPolicy()
    {
        Gate::before(function ($user, $uri, $method) {
            $roles = $user->roles;

            foreach ($roles as $role) {
                $permissions = $role->permissions;
                foreach ($permissions as $perm) {
                    if ($perm::STATUS_CLOSING == $perm->status) throw new NotFoundHttpException();

                    if ($perm->uri == $uri && $perm->verb == $method) return true;
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