<?php

namespace Zjien\Quantum\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Zjien\Quantum\Facades\Quantum;

class QuantumAccess
{
    /**
     * @var Guard
     */
    protected $auth;

    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            throw new UnauthorizedHttpException('');
        }

        $resource = $this->getResourceUri($request);
        $method = $request->getMethod();

        if (!Quantum::check($resource['uri'], $method)) {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }

    /**
     * Get the resource uri for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array $resource
     */
    protected function getResourceUri($request) {
        $uri = $request->getPathInfo();
        $uri = trim($uri, '/');

        $segment = explode('/', $uri);

        $resource = [];
        if(count($segment) % 2 === 1) {
            $resource['uri'] = array_pop($segment);
            $resource['id'] = array_slice($segment, -2);
        } else {
            $resource['id'] = [array_pop($segment)];//id
            $resource['uri'] = array_pop($segment) . '/{id}';
        }
        $resource['uri'] = '/' . $resource['uri'];

        return $resource;
    }

}
