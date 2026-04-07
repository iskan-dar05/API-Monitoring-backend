<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiLog;

class LogApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $start = microtime(true);
        $response = $next($request);
        $duration = microtime(true) - $start;


        $responseContent= $response->getContent();

        if(strlen($responseContent) > 5000){
            $responseContent = substr($responseContent, 0, 5000) . '...';
        }


        // Log data
        ApiLog::create([
            'method'=>$request->method(),
            'url'=>$request->fullUrl(),
            'headers'=>json_encode($request->headers->all()),
            'body'=>json_encode($request->all()),
            'response'=>$responseContent,
            'status'=>$response->getStatusCode(),
            'duration'=>$duration * 1000,
            'type' => 'incoming'
        ]);


        

        return $response;
    }
}
