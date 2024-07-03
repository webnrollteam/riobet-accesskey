<?php

namespace Riobet\AccessKey\App\Http\Middleware;

use Closure;
use Riobet\AccessKey\App\Exceptions\BadUserInputException;
use Riobet\AccessKey\App\Services\AccessKeyService;

class AccessKeyAuthenticationMiddleware
{
    public function handle($request, Closure $next)
    {
        if (env('MASTERKEY_DISABLE_CHECK') == 1) {
            return $next($request);
        }

        $token = $request->bearerToken();

        /** @var AccessKeyService $accessKeyService */
        $accessKeyService = app(AccessKeyService::class);
        if ($accessKeyService->check($token))
        {
            // auth()->login($user);
            return $next($request);
        }

        return response([
            'errorCode' => 403,
            'errorMessage' => 'Доступ запрещен'
        ], 403);
    }
}