<?php

namespace OnzaMe\JWT\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use OnzaMe\JWT\Exceptions\UserWereBlockException;
use OnzaMe\JWT\Models\BlockedTokensUserId;
use OnzaMe\JWT\Services\AuthorizationHeaderService;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
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

        $user = $this->service->getUser();
        $this->notBlockedUser($user);
        $this->setUser($request, $user);

        return $next($request);
    }

    abstract public function isValid(): bool;

    public function setUser(Request &$request, Authenticatable $user)
    {
        $request->setUserResolver(fn () => $user);
        auth()->setUser($user);
    }

    private function notBlockedUser(Authenticatable $user)
    {
        try {
            if (!config('jwt.check_blocked_users')) {
                return;
            }
            if (BlockedTokensUserId::query()->where('user_id', $user->id)->exists()) {
                throw new UserWereBlockException();
            }
        } catch (UserWereBlockException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            report($exception);
        }
    }
}
