<?php

namespace Riobet\AccessKey\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExceptionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!env('APP_DEBUG')) {
            if ($request->expectsJson() && $response->exception) {
                $response->setStatusCode($response->exception->getCode());

                $data = [
                    'errorCode' => $response->exception->getCode(),
                    'errorMessage' => $response->exception->getMessage(),
                ];

                $response->setContent(json_encode($data));
            }
        }

        return $response;
    }
}
