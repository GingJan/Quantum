<?php
namespace Zjien\Quantum;

use Illuminate\Auth\Access\UnauthorizedException;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Quantum
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Create a new Instance
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Determine if the given uri and method should be granted for the current user.
     *
     * @param string $uri
     * @param string $method
     * @return bool
     */

    /**
     * @param $uri
     * @param $method
     * @return bool
     * @throws bool|UnauthorizedException|NotFoundHttpException
     */
    public function check($uri, $method)
    {
        $user = $this->user();
        if (!$user) {
            throw new UnauthorizedException();
        }

        $roles = $user->roles;

        foreach ($roles as $role) {
            $permissions = $role->permissions;
            foreach ($permissions as $perm) {
                if ($perm->uri == $uri && $perm->verb == $method) {
                    if ($perm::STATUS_CLOSING == $perm->status) {
                        throw new NotFoundHttpException();
                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Get the current user.
     *
     * @return Illuminate\Auth\UserInterface|null
     */
    public function user()
    {
        return $this->app->auth->user();
    }
}