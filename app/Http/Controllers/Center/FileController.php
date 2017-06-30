<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileController extends CommonController
{
    /**
     * 文件上传
     *
     * @param  Request  $request
     * @return Response
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $path = $file->store('public/uploads');
        if($path) {
            $data['fileName'] = $file->getClientOriginalName();
            $data['path'] = $path;
            $data['full_path'] = 'http://'.$_SERVER['HTTP_HOST'].'/center/base/openFileWithBrowser?path='.$path;
            return Helper::jsonSuccess('上传成功！','',$data);
        } else {
            return Helper::jsonError('上传失败！');
        }
    }

    /**
     * 文件下载
     *
     * @param  Request  $request
     * @return Response
     */
    public function download(Request $request)
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
}