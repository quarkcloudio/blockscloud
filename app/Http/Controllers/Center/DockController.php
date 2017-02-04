<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemFileInfos;
use App\Models\Docks;
use App\Models\Apps;
class DockController extends Controller
{
    public function getLists(Request $request)
    {
        // 获取当前用户登录的信息
        $userInfo  = Auth::user();
        $DockList = Docks::where('uid',$userInfo->id)->get();
        foreach ($DockList as $key => $value) {
            $appsInfo = Apps::where('id',$value->app_id)->first();
            $data[$key]['title'] = $appsInfo->title;
            $data[$key]['imgURL'] = $appsInfo->icon;
            $data[$key]['appName'] = $appsInfo->name;
            $data[$key]['appPath'] = '';
            $data[$key]['appWidth'] = $appsInfo->width;
            $data[$key]['appHeight'] = $appsInfo->height;
            $data[$key]['context'] = $appsInfo->context;
        }
        if($data) {
            return Helper::jsonSuccess('获取成功！','',$data);
        } else {
            return Helper::jsonSuccess('获取失败！');
        }
    }
}