<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallpaper;
use App\Models\KeyValue;

class WallpaperController extends Controller
{

    public function index(Request $request)
    {
        $wallpaperLists = Wallpaper::all();
        foreach ($wallpaperLists as $key => $value) {
            $result[$key]['id']         = $value->id;
            $result[$key]['title']      = $value->title;
            $result[$key]['cover_path'] = $value->cover_path;
        }
        if($result) {
            return Helper::jsonSuccess('获取成功！','',$result);
        } else {
            return Helper::jsonSuccess('获取失败！');
        }
    }

    public function info(Request $request)
    {
        // 获取当前用户登录的信息
        $userInfo  = Auth::user();
        $where['collection'] = 'users.wallpaper';
        $where['uuid']       = $userInfo->uuid;
        $KeyValueInfo = json_decode(KeyValue::where($where)->select('data')->first()->data);
        $wallpaperId = $KeyValueInfo->wallpaper;
        $coverPath = Wallpaper::where('id',$wallpaperId)->first()->cover_path;
        if($coverPath) {
            return Helper::jsonSuccess('获取成功！','',$coverPath);
        } else {
            return Helper::jsonSuccess('获取失败！');
        }
    }

    public function setting(Request $request)
    {
        // 壁纸id
        $id   = $request->input('id');
        // 获取当前用户登录的信息
        $userInfo            = Auth::user();
        $where['collection'] = 'users.wallpaper';
        $where['uuid']       = $userInfo->uuid;
        $result = KeyValue::where($where)->update(['data' => json_encode(['wallpaper'=>$id])]);
        if($result) {
            return Helper::jsonSuccess('设置成功！');
        } else {
            return Helper::jsonSuccess('设置失败！');
        }
    }
}