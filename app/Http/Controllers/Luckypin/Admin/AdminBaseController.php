<?php

namespace App\Http\Controllers\Luckypin\Admin;

use App\Http\Controllers\Luckypin\BaseController as MainBaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;


abstract class AdminBaseController extends MainBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('status');

    }
}
