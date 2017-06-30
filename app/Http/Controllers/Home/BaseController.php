<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\User;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    /**
     * 获取文件
     *
     * @param  Request  $request
     * @return Response
     */
    public function getFile(Request $request)
    {
        $path   = $request->input('path');
        $filePath    = Helper::appToSystemChar(storage_path('app/').$path);
        $fileContent = file_get_contents($filePath);
        $fileMime    = Helper::detectFileMimeType($filePath);
        return response($fileContent, '200')->header('Content-Type', $fileMime);
    }
}