<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Models\System\ActivityLog;
use App\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    protected $url = "/report/activity-log";

    public function index(Request $request)
    {
        $activityLogs = ActivityLog::orderBy('id', 'desc');
        $dateStart = $request->input('dateStart');
        $dateEnd = $request->input('dateEnd');

        if (!empty($dateStart)) {
            $activityLogs->whereBetween('date', [$dateStart, $dateEnd]);
        }

        $data['query'] = $request->input('query');
        $data['activityLog'] = $activityLogs->paginate(10)->appends(request()->query());
        return view('pages.report.activity-log.index', $data);
    }

    public function clear()
    {
        ActivityLog::truncate();
        return redirect($this->url)->with('alert', ['message' => 'Data has been deleted!', 'status' => 'danger']);
    }
}
