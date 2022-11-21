<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminBaseController extends Controller
{
    function __construct()
    {
        app()->setLocale(config('app.admin_locale'));
    }
}
