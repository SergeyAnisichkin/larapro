<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Controllers\Shop\BaseController as MainBaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
//use MetaTag;

abstract class AdminBaseController extends MainBaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('status');

//        MetaTag::setTags([
//            'title' => 'Админ панель',
//            'description' => 'Описание',
//            'keywords' => 'keywords',
//        ]);

    }
}
