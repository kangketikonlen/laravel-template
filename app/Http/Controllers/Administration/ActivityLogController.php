<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\System\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    protected $url = "/administration/activity-log";

    public function index(Request $request)
    {
        $data['query'] = $request->input('query');
        $data['activityLog'] = ActivityLog::orderBy('id', 'desc')->paginate(10)->appends(request()->query());
        return view('pages.administration.activity-log.index', $data);
    }

    public function clear()
    {
        ActivityLog::truncate();
        return redirect($this->url)->with('alert', ['message' => 'Data has been deleted!', 'status' => 'danger']);
    }
}
