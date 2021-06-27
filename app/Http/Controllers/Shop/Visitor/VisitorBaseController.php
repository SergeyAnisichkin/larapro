<?php

namespace App\Http\Controllers\Shop\Visitor;

use App\Http\Controllers\Shop\BaseController as MainBaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
//use MetaTag;

abstract class VisitorBaseController extends MainBaseController
{
    public function __construct()
    {

//        MetaTag::setTags([
//            'title' => 'Админ панель',
//            'description' => 'Описание',
//            'keywords' => 'keywords',
//        ]);

    }
}
