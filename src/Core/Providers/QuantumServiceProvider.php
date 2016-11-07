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
        $this->registerCommands();
        $this->registerResources();
        $this->registerAccessPolicy();
    }

    /**
     * Register resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $resources = config('config.resource');

        foreach ($resources as $resource => $src) {
            $this->app->alias($src, $resources);
        }
    }

    protected function registerRepositories()
    {
        if (!config('config.service.repository.enabled')) return;

        $repositories = config('config.service.repository.mapping');

        foreach ($repositories as $repository => $src) {
            $this->app->alias($src, );
        }

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

    protected function registerQuantum()
    {
        $this->app->singleton('quantum', function ($app) {
//            return
        });
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

            $resource = explode('/', trim($uri, '/'))[0];

            foreach ($roles as $role) {
                $permissions = $role->permissions;
                foreach ($permissions as $perm) {
                    if ($perm::TYPE_PUBLIC == $perm->type) return true;

                    if ($perm->status == $perm::STATUS_CLOSING) return false;

                    if ($perm->uri == $uri && $perm->verb == $method) {

                        if ($perm::ACCESS_PRIVATE == $perm->access_level) {
                            $ownerField = config('config.database.fields.owner');
                            app($resource)
                            return app($resource)->find(, [$ownerField])->$ownerField == $user->getAuthIdentifier();
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