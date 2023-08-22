<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\System\CrashLog;
use Illuminate\Http\Request;

class CrashLogController extends Controller
{
    protected $url = "/administration/crash-log";

    public function index(Request $request)
    {
        $data['query'] = $request->input('query');
        $data['crashLogs'] = CrashLog::orderBy('id', 'desc')->paginate(10)->appends(request()->query());
        return view('pages.administration.crash-log.index', $data);
    }

    public function clear()
    {
        CrashLog::truncate();
        return redirect($this->url)->with('alert', ['message' => 'Data has been deleted!', 'status' => 'danger']);
    }
}
