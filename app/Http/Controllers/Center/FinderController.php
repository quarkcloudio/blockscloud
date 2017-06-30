<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemFileInfos;
use App\Models\Apps;

class FinderController extends CommonController
{

	/**
     * explorer边栏列表
     * @author tangtanglove
	 */
    public function sidebar()
    {
        $userInfo  = Auth::user();
        $list['favoritesTitle'] = '个人收藏';
        $list['favorites'] = [
                '0'=>['name'=>'finder','icon'=>'home-icon','path'=>'public/user/'.$userInfo['name'].'/home/','title'=>'电脑','active' =>'on'],
                '1'=>['name'=>'finder','icon'=>'desktop-icon','path'=>'public/user/'.$userInfo['name'].'/home/desktop/','title'=>'桌面'],
                '2'=>['name'=>'finder','icon'=>'documents-icon','path'=>'public/user/'.$userInfo['name'].'/home/documents/','title'=>'文稿'],
                '3'=>['name'=>'finder','icon'=>'downloads-icon','path'=>'public/user/'.$userInfo['name'].'/home/downloads/','title'=>'下载'],
                '4'=>['name'=>'finder','icon'=>'movies-icon','path'=>'public/user/'.$userInfo['name'].'/home/movies/','title'=>'影片'],
                '5'=>['name'=>'finder','icon'=>'music-icon','path'=>'public/user/'.$userInfo['name'].'/home/music/','title'=>'音乐'],
                '6'=>['name'=>'finder','icon'=>'pictures-icon','path'=>'public/user/'.$userInfo['name'].'/home/pictures/','title'=>'图片']
            ];
        $list['devicesTitle'] = '设备';
        $list['devices'] = [
                '0'=>['name'=>'finder','icon'=>'cloud-icon','path'=>'public/cloud/','title'=>'云服务'],
                '1'=>['name'=>'finder','icon'=>'network-icon','path'=>'public/network/','title'=>'网络文件']
            ];
        return Helper::jsonSuccess('获取成功！','',$list);
    }

	/**
     * 当前路径文件列表
     * @author tangtanglove
	 */
    public function openPath(Request $request)
    {
        $list = [];$getOexes = [];$getFiles = [];$getDirs = [];
        // 获取当前用户登录的信息
        $userInfo  = Auth::user();
        // 获取当前路径
        $dirPath   = $request->input('path');
        // 路径为空则初始化到桌面
        if(empty($dirPath)) {
            $dirPath = 'public/user/'.$userInfo['name'].'/home/';
        }
        // 路径地址，例如：'public/user/administrator/home/desktop'，文件存储在storage目录里
        $getDirPath = Helper::appToSystemChar(storage_path('app/').$dirPath);
        $dirs   = Helper::getDir($getDirPath);
        $files  = Helper::getFile($getDirPath);
        // 返回错误
        if(($dirs == 'error') ||($files == 'error')) {
            return Helper::jsonError('文件或文件夹不存在！');
        }

        if(!empty($dirs)) {
            foreach ($dirs as $key => $value) {
                // 查找默认打开方式
                $systemFileInfos = SystemFileInfos::where('file_type', 'dir')->first();
                if(empty($systemFileInfos)) {
                    $systemFileInfos = SystemFileInfos::where('file_type', 'unknown')->first();
                }
                // 要使用的apps信息
                $appInfo = Apps::where('id', $systemFileInfos->app_id)->first();

                $getDirs[$key]['title']    = Helper::systemToAppChar($value);
                $getDirs[$key]['name']     = $appInfo->name;
                $getDirs[$key]['icon']     = $systemFileInfos->file_icon;
                $getDirs[$key]['width']    = $appInfo->width;
                $getDirs[$key]['height']   = $appInfo->height;
                $getDirs[$key]['path']     = $dirPath.Helper::systemToAppChar($value).'/';
                $getDirs[$key]['context']  = $appInfo->context;
            }
        }
        if(!empty($files)) {
            foreach ($files as $key => $value) {
                // 文件标题
                $title = Helper::systemToAppChar($value);
                $arr1    = explode('.',$title);
                // 文件扩展名
                $fileExt = array_last($arr1);
                // 根据扩展名查找需要那个用哪个程序打开
                if($fileExt == 'oexe') {
                    // 如果是可执行程序的快捷方式，解析里面的信息
                    $url = str_replace("/","/",$value);
                    $contents = file_get_contents($getDirPath.$url);
                    $oexeInfo = json_decode($contents, true);
                    $getOexes[$key]['title']    = $arr1[0];
                    $getOexes[$key]['name']     = $oexeInfo['name'];

                    // 回收站图标特定状态，是否满了
                    if($oexeInfo['name'] == 'trash') {
                        $recyclePath    = Helper::appToSystemChar(storage_path('app/public/user/'.$userInfo['name'].'/recycle'));
                        $isEmpty  = Helper::isEmptyDir($recyclePath);
                        if(!$isEmpty) {
                            $getOexes[$key]['icon']     = './images/apps/FullTrashIcon.png';
                        } else {
                            $getOexes[$key]['icon']     = $oexeInfo['icon'];
                        }
                    } else {
                        $getOexes[$key]['icon']     = $oexeInfo['icon'];
                    }

                    $getOexes[$key]['width']    = $oexeInfo['width'];
                    $getOexes[$key]['height']   = $oexeInfo['height'];
                    $getOexes[$key]['sort']     = $oexeInfo['sort'];
                    $getOexes[$key]['context']  = $oexeInfo['context'];
                } else {
                    // 查找数据库中默认打开程序及文件的默认图标
                    $systemFileInfos = SystemFileInfos::where('file_type', $fileExt)->first();
                    if(empty($systemFileInfos)) {
                        $systemFileInfos = SystemFileInfos::where('file_type', 'unknown')->first();
                    }
                    // 要使用的apps信息
                    $appInfo = Apps::where('id', $systemFileInfos->app_id)->first();
                    $getFiles[$key]['title']    = $arr1[0].'.'.$fileExt;
                    $getFiles[$key]['path']     = $dirPath.$title;
                    $getFiles[$key]['name']     = $appInfo->name;
                    $getFiles[$key]['icon']     = $systemFileInfos->file_icon;
                    $getFiles[$key]['width']    = $appInfo->width;
                    $getFiles[$key]['height']   = $appInfo->height;
                    $getFiles[$key]['context']  = $systemFileInfos->context;
                }

            }
        }
        if(!empty($getOexes)) {
            $getOexes = array_values(array_sort($getOexes, function ($value) {
                return $value['sort'];
            }));
        }

        $list = array_merge($getOexes,$getDirs,$getFiles);
        if($list) {
            return Helper::jsonSuccess('获取成功！','',$list);
        } else {
            return Helper::jsonSuccess('获取成功！');
        }
    }

	/**
     * 删除当前路径下文件或文件夹
     * @author tangtanglove
	 */
    public function deletePath(Request $request)
    {
        $userInfo  = Auth::user();
        // 获取当前路径
        $filePath   = $request->input('path');
        // 路径为空则初始化到桌面
        if(empty($filePath)) {
            return '参数错误！';
        } else {
            $arr = explode('/',$filePath);
            $count = count($arr);
            $url = str_replace("/","/",$filePath);

            $getFilePath = Helper::appToSystemChar(storage_path('app/').$url);

            if(is_file($getFilePath)) {
                $recycle = Helper::appToSystemChar(storage_path('app/public/user/'.$userInfo['name'].'/recycle/'.$arr[$count-1]));
                if(is_file($recycle)) {
                    // 如果回收站有文件则先删除
                    Helper::delDirAndFile($recycle);
                }
            } else {
                $recycle = Helper::appToSystemChar(storage_path('app/public/user/'.$userInfo['name'].'/recycle/'.$arr[$count-2]));
                if(is_dir($recycle)) {
                    // 如果回收站有文件夹则先删除
                   Helper::delDirAndFile($recycle);
                }
            }
            
            $result = rename($getFilePath,$recycle);

            if($result!=='error') {
                return Helper::jsonSuccess('操作成功！');
            } else {
                return Helper::jsonError('操作失败！');
            }
        }

    }

	/**
     * 清空回收站
     * @author tangtanglove
	 */
    public function emptyTrash(Request $request)
    {
        $userInfo       = Auth::user();
        $recyclePath    = Helper::appToSystemChar(storage_path('app/public/user/'.$userInfo['name'].'/recycle'));
        if(is_dir($recyclePath)) {
            $result     = Helper::delDirAndFile($recyclePath);
            // 重新在创建回收站
            Helper::makeDir($recyclePath);
        } else {
            $result     = 'success';
        }
        if($result!=='error') {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

	/**
     * 重命名路径
     * @author tangtanglove
	 */
    public function renamePath(Request $request)
    {
        // 获取当前路径
        $path       = $request->input('path');
        // 新名称
        $newTitle   = $request->input('newTitle');
        $oldTitle   = $request->input('oldTitle');

        $length = mb_strlen($oldTitle,'utf-8');
        if (!is_dir(Helper::appToSystemChar(storage_path('app/').$path))) {
            $newPath = mb_substr($path,0,(0-$length),'utf-8').$newTitle;
        } else {
            $newPath = mb_substr($path,0,(0-$length-1),'utf-8').$newTitle;
        }
        $result    = rename(Helper::appToSystemChar(storage_path('app/').$path),Helper::appToSystemChar(storage_path('app/').$newPath));
        if($result!=='error') {
            return Helper::jsonSuccess('操作成功！','',$newPath);
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

	/**
     * 移动路径
     * @author tangtanglove
	 */
    public function movePath(Request $request)
    {
        // 获取当前路径
        $newPath   = $request->input('newPath');
        // 缓存路径
        $oldPath   = $request->input('oldPath');

        $data    = $this->doMovePath($newPath,$oldPath);
        if($data['result'] !== 'error') {
            return Helper::jsonSuccess('操作成功！','',$data);
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

	/**
     * 复制路径
     * @author tangtanglove
	 */
    public function copyPath(Request $request)
    {
        // 获取当前路径
        $newPath   = $request->input('newPath');
        // 缓存路径
        $oldPath   = $request->input('oldPath');

        $arrOldPath  = explode('/',$oldPath);
        $count = count($arrOldPath);

        $result = Helper::copyFileToDir(Helper::appToSystemChar(storage_path('app/').$oldPath),Helper::appToSystemChar(storage_path('app/').$newPath));

        if(is_dir(Helper::appToSystemChar(storage_path('app/').$oldPath))) {
            // 查找默认打开方式
            $systemFileInfos = SystemFileInfos::where('file_type', 'dir')->first();
            if(empty($systemFileInfos)) {
                $systemFileInfos = SystemFileInfos::where('file_type', 'unknown')->first();
            }
            // 要使用的apps信息
            $appInfo = Apps::where('id', $systemFileInfos->app_id)->first();

            $fileName = $arrOldPath[$count-2];
            $data['title']    = $fileName;
            $data['name']     = $appInfo->name;
            $data['icon']     = $systemFileInfos->file_icon;
            $data['width']    = $appInfo->width;
            $data['height']   = $appInfo->height;
            $data['path']     = $newPath.$fileName;
            $data['context']  = $systemFileInfos->context;
        } elseif (is_file(Helper::appToSystemChar(storage_path('app/').$oldPath))) {
            $fileName = array_last($arrOldPath);
            $arr    = explode('.',$fileName);
            // 文件扩展名
            $fileExt = array_last($arr);
            // 查找数据库中默认打开程序及文件的默认图标
            $systemFileInfos = SystemFileInfos::where('file_type', $fileExt)->first();
            if(empty($systemFileInfos)) {
                $systemFileInfos = SystemFileInfos::where('file_type', 'unknown')->first();
            }
            // 要使用的apps信息
            $appInfo = Apps::where('id', $systemFileInfos->app_id)->first();

            $data['title']    = $fileName;
            $data['path']     = $newPath.$fileName;
            $data['name']     = $appInfo->name;
            $data['icon']     = $systemFileInfos->file_icon;
            $data['width']    = $appInfo->width;
            $data['height']   = $appInfo->height;
            $data['context']  = $systemFileInfos->context;
        }

        if($result!=='error') {
            return Helper::jsonSuccess('操作成功！','',$data);
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

	/**
     * 创建文件夹
     * @author tangtanglove
	 */
    public function makeDir(Request $request)
    {
        // 获取当前路径
        $dirPath   = $request->input('path');
        $result    = Helper::makeDir(Helper::appToSystemChar(storage_path('app/').$dirPath));
        if($result!=='error') {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

	/**
     * 创建文件
     * @author tangtanglove
	 */
    public function makeFile(Request $request)
    {
        // 获取当前路径
        $filePath   = $request->input('path');
        $fileName   = $request->input('fileName');
        $fileExt    = $request->input('fileExt');

        $result = file_put_contents(Helper::appToSystemChar(storage_path('app/').$filePath.$fileName.'.'.$fileExt),'text');
        if($result) {
            // 查找数据库中默认打开程序及文件的默认图标
            $systemFileInfos = SystemFileInfos::where('file_type', $fileExt)->first();
            if(empty($systemFileInfos)) {
                $systemFileInfos = SystemFileInfos::where('file_type', 'unknown')->first();
            }
            // 要使用的apps信息
            $appInfo = Apps::where('id', $systemFileInfos->app_id)->first();

            $data['title']    = $fileName.'.'.$fileExt;
            $data['path']     = Helper::systemToAppChar($filePath.$fileName.'.'.$fileExt);
            $data['name']     = $appInfo->name;
            $data['icon']     = $systemFileInfos->file_icon;
            $data['width']    = $appInfo->width;
            $data['height']   = $appInfo->height;
            $data['context']  = $systemFileInfos->context;

            return Helper::jsonSuccess('操作成功！','',$data);
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    /**
     * 文件上传
     *
     * @param  Request  $request
     * @return Response
     */
    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $path = $file->store('public/temp');
        if($path) {
            $data['fileName'] = $file->getClientOriginalName();
            $data['path'] = $path;
            return Helper::jsonSuccess('上传成功！','',$data);
        } else {
            return Helper::jsonError('上传失败！');
        }
    }

	/**
     * 当文件上传成功时，回调移动路径
     * @author tangtanglove
	 */
    public function callbackMovePath(Request $request)
    {
        // 获取当前路径
        $newPath   = $request->input('newPath');
        // 缓存路径
        $oldPath   = $request->input('oldPath');
        $fileName  = $request->input('fileName');
        $data = $this->doMovePath($newPath,$oldPath,$fileName);
        if($data['result'] !== 'error') {
            return Helper::jsonSuccess('操作成功！','',$data);
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    /**
     * 文件下载
     *
     * @param  Request  $request
     * @return Response
     */
    public function downloadFile(Request $request)
    {
        $path   = $request->input('path');
        $filePath    = Helper::appToSystemChar(storage_path('app/').$path);
        $fileinfo = pathinfo($filePath);
        header('Content-type: application/x-'.$fileinfo['extension']);
        header('Content-Disposition: attachment; filename='.$fileinfo['basename']);
        header('Content-Length: '.filesize($filePath));
        readfile($filePath);
        exit();
    }

    protected function doMovePath($newPath,$oldPath,$fileName='')
    {
        $arrOldPath  = explode('/',$oldPath);
        $count = count($arrOldPath);

        if(is_dir(Helper::appToSystemChar(storage_path('app/').$oldPath))) {
            $fileName  = $arrOldPath[$count-2];
            $result    = rename(Helper::appToSystemChar(storage_path('app/').$oldPath),Helper::appToSystemChar(storage_path('app/').$newPath.$fileName));
            // 查找默认打开方式
            $systemFileInfos = SystemFileInfos::where('file_type', 'dir')->first();
            if(empty($systemFileInfos)) {
                $systemFileInfos = SystemFileInfos::where('file_type', 'unknown')->first();
            }
            // 要使用的apps信息
            $appInfo = Apps::where('id', $systemFileInfos->app_id)->first();

            $data['title']    = $fileName;
            $data['name']     = $appInfo->name;
            $data['icon']     = $systemFileInfos->file_icon;
            $data['width']    = $appInfo->width;
            $data['height']   = $appInfo->height;
            $data['path']     = $newPath.$fileName;
            $data['context']  = $systemFileInfos->context;
            $data['result']   = $result;
        } elseif (is_file(Helper::appToSystemChar(storage_path('app/').$oldPath))) {
            if(empty($fileName)) {
                $fileName  = array_last($arrOldPath);
            }
            $result    = rename(Helper::appToSystemChar(storage_path('app/').$oldPath),Helper::appToSystemChar(storage_path('app/').$newPath.$fileName));
            $arr       = explode('.',$fileName);
            // 文件扩展名
            $fileExt = array_last($arr);
            // 查找数据库中默认打开程序及文件的默认图标
            $systemFileInfos = SystemFileInfos::where('file_type', $fileExt)->first();
            if(empty($systemFileInfos)) {
                $systemFileInfos = SystemFileInfos::where('file_type', 'unknown')->first();
            }
            // 要使用的apps信息
            $appInfo = Apps::where('id', $systemFileInfos->app_id)->first();

            $data['title']    = $fileName;
            $data['path']     = $newPath.$fileName;
            $data['name']     = $appInfo->name;
            $data['icon']     = $systemFileInfos->file_icon;
            $data['width']    = $appInfo->width;
            $data['height']   = $appInfo->height;
            $data['context']  = $systemFileInfos->context;
            $data['result']   = $result;
        }
        return $data;
    }

}