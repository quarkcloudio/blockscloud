<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditorController extends CommonController
{

	/**
     * 打开文件
     * @author tangtanglove
	 */
    public function openFile(Request $request)
    {
        // 获取当前路径
        $path        = $request->input('path');
        $filePath    = Helper::appToSystemChar(storage_path('app/').$path);
        $fileContent = file_get_contents($filePath);
        if($fileContent!==false) {
            return Helper::jsonSuccess('操作成功！','',$fileContent);
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

	/**
     * 保存文件
     * @author tangtanglove
	 */
    public function saveFile(Request $request)
    {
        // 获取当前路径
        $path       = $request->input('path');
        $content    = $request->input('content');
        $filePath   = Helper::appToSystemChar(storage_path('app/').$path);
        $result = file_put_contents($filePath, $content);
        if($result) {
            return Helper::jsonSuccess('保存成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

}