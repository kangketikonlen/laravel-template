<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Models\System\CrashLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CrashLogController extends Controller
{
    protected string $url = "/report/crash-log";

    public function index(Request $request): View
    {
        $crashLogs = CrashLog::orderBy('id', 'desc');
        $dateStart = $request->input('dateStart');
        $dateEnd = $request->input('dateEnd');

        if (!empty($dateStart)) {
            $crashLogs->whereBetween('date', [$dateStart, $dateEnd]);
        }

        $data['query'] = $request->input('query');
        $data['crashLogs'] = $crashLogs->paginate(10)->appends(request()->query());
        return view('pages.report.crash-log.index', $data);
    }

    public function clear(): RedirectResponse
    {
        CrashLog::truncate();
        return redirect($this->url)->with('alert', ['message' => 'Data has been deleted!', 'status' => 'danger']);
    }
}
