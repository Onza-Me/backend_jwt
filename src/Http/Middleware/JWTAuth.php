<?php

namespace OnzaMe\JWT\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OnzaMe\JWT\Services\AuthorizationHeaderService;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Http\Request;

class JWTAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $service = app(AuthorizationHeaderService::class);
        if (!$service->isValid()) {
            throw new UnauthorizedHttpException('Basic', 'Unauthorized');
        }
        $this->setUser($request, $service->getUser());
        return $next($request);
    }

    public function setUser(Request &$request, Authenticatable $user)
    {
        $request->setUserResolver(fn () => $user);
        auth()->setUser($user);
    }
}
