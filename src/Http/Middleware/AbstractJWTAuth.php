<?php

namespace OnzaMe\JWT\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use OnzaMe\JWT\Services\AuthorizationHeaderService;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

abstract class AbstractJWTAuth
{
    protected AuthorizationHeaderService $service;
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->service = app(AuthorizationHeaderService::class);
        if (!$this->isValid()) {
            throw new UnauthorizedHttpException('Basic', 'Unauthorized');
        }
        $this->setUser($request, $this->service->getUser());
        return $next($request);
    }

    abstract public function isValid(): bool;

    public function setUser(Request &$request, Authenticatable $user)
    {
        $request->setUserResolver(fn () => $user);
        auth()->setUser($user);
    }
}
