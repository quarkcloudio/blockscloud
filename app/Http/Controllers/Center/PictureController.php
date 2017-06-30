<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Services\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PictureController extends CommonController
{

    public function open(Request $request)
    {
        $path   = $request->input('path');
        $filePath    = Helper::appToSystemChar(storage_path('app/').$path);
        $fileContent = file_get_contents($filePath);
        $fileMime    = Helper::detectFileMimeType($filePath);
        return response($fileContent, '200')->header('Content-Type', $fileMime);
    }
}