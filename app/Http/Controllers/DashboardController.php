<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    

    public function metrics(Request $request){


        $incomingLogs = ApiLog::where('type', 'incoming');



        $totalRequests = $incomingLogs->count();
        $avgLatency = $incomingLogs->avg('duration');
        $errors = $incomingLogs->where('status', '>=', 400)->count();

        $errorRate = $totalRequests > 0 ? ($errors * 100) / $totalRequests : 0;



        $trafficOverview = ApiLog::select(
            DB::raw("strftime('%Y-%m-%d %H:00:00', created_at) as hour"),
            DB::raw('count(*) as total'),
            DB::raw('sum(case when status >= 400 then 1 else 0 end) as erros')
        )->where('type', 'incoming')
         ->groupBy('hour')
         ->orderBy('hour')
         ->get();

        $latencyTrends = ApiLog::select(
            DB::raw("strftime('%Y-%m-%d %H:00:00', created_at) as hour"),
            DB::raw('max(duration) as max_latency'),
        )->where('type', 'incoming')
         ->groupBy('hour')
         ->orderBy('hour')
         ->get();

        return response()->json([
            "totalRequests"=>$totalRequests,
            "avgLatency"=>$avgLatency,
            "errorRate"=>$errorRate,
            "trafficOverview"=>$trafficOverview,
            "latencyTrends"=>$latencyTrends
        ]);

    }


}
