<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ApiLog;

class ProxyController extends Controller
{
    public function handle(Request $request){
        $start = microtime(true);



        if(!filter_var($request->url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL'], 400);
        }

        // Send request to external API
        $response = Http::withHeaders($request->headers ?? [])
            ->send($request->method, $request->url, [
                'json'=>$request->body
            ]);

        $responseBody = $response->body();

        if(strlen($responseBody) > 5000){
            $responseBody = substr($responseBody, 0, 5000) . '...';
        }


        $duration = microtime(true) - $start;
        // Log outgoing request
        ApiLog::create([
            'method' => $request->method,
            'url' => $request->url,
            'headers' => json_encode($request->headers),
            'body' => json_encode($request->body),
            'response' => $response->body(),
            'status' => $response->status(),
            'duration' => $duration * 1000,
            'type' => 'outgoing'
        ]);

        return response()->json([
            'status' => $response->status(),
            'body' => json_decode($response->body(), true),
            'headers' => $response->headers(),
            'message' => 'SALAM ALAYKOUM'
        ]);


    }
}
