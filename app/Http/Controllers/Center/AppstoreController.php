<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Models\Apps;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Docks;

class AppstoreController extends Controller
{

    public function index(Request $request)
    {
        // 获取当前页码
        $page      = $request->input('page');
        $appsLists = Apps::skip(($page-1)*10)->take(10)->get();
        $total     = Apps::count();
        foreach ($appsLists as $key => $value) {
            $result[$key]['id']         = $value->id;
            $result[$key]['title']      = $value->title;
            $result[$key]['name']       = $value->name;
            $result[$key]['icon']       = $value->icon;
            $result[$key]['width']      = $value->width;
            $result[$key]['height']     = $value->height;
            $result[$key]['version']    = $value->version;
        }

        if($result) {
            $data['lists'] = $result;
            $data['total'] = $total;
            return Helper::jsonSuccess('获取成功！','',$data);
        } else {
            return Helper::jsonSuccess('获取失败！');
        }
    }

    public function info(Request $request)
    {
        // 获取当前页码
        $id      = $request->input('id');
        $appInfo = Apps::where('id',$id)->first();
        $userInfo = Auth::user();
        if($appInfo) {
            // 判断是否已经添加到dock
            $where['app_id'] = $id;
            $where['uid']    = $userInfo->id;
            $hasAddDock = Docks::where($where)->first();
            if($hasAddDock) {
                $data['dock'] = true;
            } else {
                $data['dock'] = false;
            }

            // 判断是否已经添加到desktop
            $appFilePath = 'public/user/'.$userInfo['name'].'/home/desktop/'.$appInfo['title'].'.oexe';
            $getFullPath = Helper::appToSystemChar(storage_path('app\\').$appFilePath);
            if(file_exists($getFullPath)) {
                $data['desktop'] = true;
            } else {
                $data['desktop'] = false;
            }
            $data['appInfo'] = $appInfo;
            return Helper::jsonSuccess('获取成功！','',$data);
        } else {
            return Helper::jsonSuccess('获取失败！');
        }
    }

    public function addToDesktop(Request $request)
    {
        // 获取当前页码
        $status   = $request->input('status');
        $id       = $request->input('id');
        $appInfo = Apps::where('id',$id)->first();
        $userInfo = Auth::user();

        // 判断是否已经添加到desktop
        $appFilePath = 'public/user/'.$userInfo['name'].'/home/desktop/'.$appInfo['title'].'.oexe';
        $getFullPath = Helper::appToSystemChar(storage_path('app\\').$appFilePath);

        if($status == 'true') { //添加到桌面
            // 组合app信息
            $data['name'] = $appInfo->name;
            $data['icon'] = $appInfo->icon;
            $data['width'] = $appInfo->width;
            $data['height'] = $appInfo->height;
            $data['sort'] = $appInfo->sort;
            $data['context'] = $appInfo->context;

            // 创建桌面快捷方式
            if(file_put_contents($getFullPath,json_encode($data))) {
                $result = 'success';
            } else {
                $result = 'error';
            }
        } else {
            // 删除桌面快捷方式
            $result = Helper::delDirAndFile($getFullPath);
        }

        if($result != 'error') {
            return Helper::jsonSuccess('操作成功！','',$status);
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    public function addToDock(Request $request)
    {
        // 获取当前页码
        $status   = $request->input('status');
        $id       = $request->input('id');
        $userInfo = Auth::user();

        if($status == 'true') {
            $data['uid'] = $userInfo->id;
            $data['app_id'] = $id;
            $data['sort'] = 0;
            $result = Docks::insert($data);
        } else {
            $where['uid'] = $userInfo->id;
            $where['app_id'] = $id;
            $result = Docks::where($where)->delete();
        }


        if($result) {
            return Helper::jsonSuccess('操作成功！','',$status);
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

}