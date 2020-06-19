<?php

namespace OnzaMe\JWT\Http\Middleware;

use Closure;
use OnzaMe\JWT\Services\AuthorizationHeaderService;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JWTAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!app(AuthorizationHeaderService::class)->isValid()) {
            throw new UnauthorizedHttpException('Basic', 'Unauthorized');
        }
        return $next($request);
    }
}
