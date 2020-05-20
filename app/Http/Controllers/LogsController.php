<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $viewData = array();

        $viewData['data'] = Log::where("userId", Auth::id())->get();

        return view('logs.view',$viewData);
    }

    public function adminLogs()
    {
        $viewData = array();

        $viewData['data'] = Log::where("userId", Auth::id())->get();

        return view('admin.logs.view',$viewData);
    }

}
