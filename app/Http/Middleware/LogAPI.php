<?php

namespace App\Http\Middleware;

use App\Models\LogModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        LogModel::create([
            'endpoint' => $request->path(),
            'method' => $request->method(),
            'request_body' => json_encode($request->all()),
            'response_body' => $response->getContent(),
            'status_code' => $response->getStatusCode(),
            'user_id' => auth()->id()
        ]);

        return $response;
    }
}
