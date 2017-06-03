<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCate;
use App\Models\Post;
use App\Models\PostRelationships;
use App\Services\Helper;
use DB;

class WeixinController extends BaseController
{

    public function index()
    {
        require (app_path().'/Tools/Weixin/jssdk.php');
        $jssdk = new \JSSDK("yourAppID", "yourAppSecret");
        $signPackage = $jssdk->GetSignPackage();
        return view('home/weixin',compact('signPackage'));
    }
}