<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\System\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = Auth::check();
        $path = $request->path();

        if ($auth) {
            $logData['sessionID'] = $request->session()->getId();
            $logData['date'] = date("Y-m-d");
            $logData['time'] = date("H:i:s");
            $logData['ipAddress'] = $request->ip();
            $logData['method'] = $request->method();
            $logData['referer'] = $request->headers->get('referer');
            $logData['createdBy'] = 'ActivityLog Middleware';

            if ($path == "/") {
                $logData['path'] = "portal";
            } else {
                $logData['path'] = $path;
            }

            $logData['user'] = Auth::user()->name;
            $logData['role'] = Auth::user()->roles->name;
            $logData['description'] = $logData['user'] . " (" . $logData['ipAddress'] . ") telah mendarat di halaman " . $logData['path'];

            $activityLog = ActivityLog::where('date', $logData['date'])->where('sessionID', $logData['sessionID'])->where('path', $logData['path'])->first();

            if ($logData['path'] != "dashboard") {
                if (empty($activityLog)) {
                    ActivityLog::create($logData);
                } else {
                    $newLogData['time'] = date("H:i:s");
                    $newLogData['updatedBy'] = $logData['user'];
                    $newLogData['updatedAt'] = date("Y-m-d H:i:s");

                    $activityLog->increment('totalHit');
                    $activityLog->update($newLogData);
                }
            }
        }

        return $next($request);
    }
}
