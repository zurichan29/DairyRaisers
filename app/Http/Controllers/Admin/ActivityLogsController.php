<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
class ActivityLogsController extends Controller
{
    public function index(Request $request) {
        if(auth()->guard('admin')->check()) {
            $activity_logs = ActivityLog::all();
            return view('admin.activity_logs.index', compact('activity_logs'));
        } else {
            return redirect()->route('login.administrator');
        }
    }
}
