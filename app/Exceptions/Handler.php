<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Str;
use App\Models\System\CrashLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $error) {
            // Extract relevant information from the exception and request
            $auth = Auth::check();

            $file = explode("/", $error->getFile());
            $shortFile = array_slice($file, -1);

            $crashLogData = [
                'date' => date("Y-m-d"),
                'time' => date("H:i:s"),
                'message' => Str::limit($error->getMessage(), 250),
                'location' => $error->getFile(),
                'file' => implode("/", $shortFile),
                'line' => $error->getLine(),
                'createdBy' => 'Exception Handler'
            ];

            $crashLog = CrashLog::where('date', $crashLogData['date'])
                ->where('file', $crashLogData['file'])
                ->where('line', $crashLogData['line'])->first();

            if (empty($crashLog)) {
                CrashLog::create($crashLogData);
            } else {
                $newCrashLogData['time'] = date("H:i:s");
                $newCrashLogData['updatedBy'] = "Exception Handler";
                $newCrashLogData['updatedAt'] = date("Y-m-d H:i:s");
                $crashLog->increment('totalHit');
                $crashLog->update($newCrashLogData);
            }
        });
    }
}
