<?php

namespace tecai\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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

        $uri = $this->getResourceUri($request);
        $method = $request->getMethod();
//        $account_id = $this->auth->user()->getAuthIdentifier();

        if (!Gate::check($uri, $method)) {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }

    /**
     * 获取资源的uri
     * @param \Illuminate\Http\Request $request
     * @return string $resourceUri
     */
    protected function getResourceUri($request) {
        $uri = $request->getPathInfo();
        $uri = trim($uri, '/');

        $segment = explode('/', $uri);

        if(count($segment) % 2 === 1) {//如果是奇数个，则是访问列表
            $resource = end($segment);
        } else {//否则就是访问指定某个资源
            end($segment);//id
            $resource = prev($segment) . '/{id}';
        }

        return '/' . $resource;
    }

}
