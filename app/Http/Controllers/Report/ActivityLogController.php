<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Models\System\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    protected string $url = "/report/activity-log";

    public function index(Request $request): View
    {
        $activityLogs = ActivityLog::orderBy('id', 'desc');
        $dateStart = $request->input('dateStart');
        $dateEnd = $request->input('dateEnd');

        if (!empty($dateStart)) {
            $activityLogs->whereBetween('date', [$dateStart, $dateEnd]);
        }

        $data['query'] = $request->input('query');
        $data['activityLog'] = $activityLogs->paginate(10)->appends($request->query());
        return view('pages.report.activity-log.index', $data);
    }
}
