<?php

namespace App\Http\Controllers\Admin;

use App\Models\admin\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminDashboardController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Auth::id());
        $data['page_title'] = "Dashboard";
        return view('admin.dashboard', $data);
    }
}
