<?php

namespace App\Services;
use App\Models\KeyValue;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class Helper
{
    /**
    * 创建盐
    * @author tangtanglove <dai_hang_love@126.com>
    */
	static function createSalt($length=-6)
    {
        return $salt = substr(uniqid(rand()), $length);
    }

    /**
    * 创建uuid,系统内唯一标识符
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function createUuid()
    {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
        return $uuid;
    }

    /**
    * 加密方法
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function blockscloudMd5($string,$salt)
    {
        return md5(md5($string).$salt);
    }

    /**
    * 获取目录列表
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function getDir(& $dir)
    {  
        $dirArray = [];
        if(is_dir($dir)) {
            if(false != ($handle = opendir($dir))) {
                while(false != ($file = readdir($handle))) {
                    if($file!='.' && $file!='..' && !strpos($file,'.')) {
                        $dirArray[] = $file;  
                    }
                }
                closedir($handle);  
            }
        }else{
            return 'error';
        }
        return $dirArray;
    }
  
    /**
    * 获取文件列表
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function getFile(& $dir)
    {
        $fileArray = [];
        if(is_dir($dir)) {  
            if(false != ($handle = opendir($dir))) {  
                while(false != ($file = readdir($handle))){  
                    if($file!='.' && $file!='..' && strpos($file,'.')) {  
                        $fileArray[] = $file;  
                    }  
                }  
                closedir( $handle );  
            }  
        } else {  
            return 'error';
        }  
        return $fileArray;  
    }  

    /**
    * 获取文件Mime
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function detectFileMimeType($fileName='')
    {
        if(!function_exists('mime_content_type')) {
            $mimeTypes = array(
                'txt' => 'text/plain',
                'htm' => 'text/html',
                'html' => 'text/html',
                'php' => 'text/html',
                'css' => 'text/css',
                'js' => 'application/javascript',
                'json' => 'application/json',
                'xml' => 'application/xml',
                'swf' => 'application/x-shockwave-flash',
                'flv' => 'video/x-flv',

                // images
                'png' => 'image/png',
                'jpe' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'jpg' => 'image/jpeg',
                'gif' => 'image/gif',
                'bmp' => 'image/bmp',
                'ico' => 'image/vnd.microsoft.icon',
                'tiff' => 'image/tiff',
                'tif' => 'image/tiff',
                'svg' => 'image/svg+xml',
                'svgz' => 'image/svg+xml',

                // archives
                'zip' => 'application/zip',
                'rar' => 'application/x-rar-compressed',
                'exe' => 'application/x-msdownload',
                'msi' => 'application/x-msdownload',
                'cab' => 'application/vnd.ms-cab-compressed',

                // audio/video
                'mp3' => 'audio/mpeg',
                'qt' => 'video/quicktime',
                'mov' => 'video/quicktime',

                // adobe
                'pdf' => 'application/pdf',
                'psd' => 'image/vnd.adobe.photoshop',
                'ai' => 'application/postscript',
                'eps' => 'application/postscript',
                'ps' => 'application/postscript',

                // ms office
                'doc' => 'application/msword',
                'rtf' => 'application/rtf',
                'xls' => 'application/vnd.ms-excel',
                'ppt' => 'application/vnd.ms-powerpoint',

                // open office
                'odt' => 'application/vnd.oasis.opendocument.text',
                'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            );
            $fileExt = explode('.',$fileName);
            $ext = strtolower(array_pop($fileExt));
            if (array_key_exists($ext, $mimeTypes)) {
                return $mimeTypes[$ext];
            } elseif (function_exists('finfo_open')) {
                $fileInfo = finfo_open(FILEINFO_MIME);
                $mimeType = finfo_file($fileInfo, $fileName);
                finfo_close($fileInfo);
                return $mimeType;
            } else {
                return 'application/octet-stream';
            }
        } else {
            return mime_content_type($fileName);
        }
    }
  
    /**
    * 获取目录/文件列表 
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function getDirFile(& $dir)
    {  
        if(is_dir($dir)){  
            $dirFileArray['dirList'] = self::getDir($dir);  
            if($dirFileArray) {  
                foreach($dirFileArray['dirList'] as $handle){  
                    $file = $dir.DIRECTORY_SEPARATOR.$handle;  
                    $dirFileArray['fileList'][$handle] = self::getFile($file);  
                }  
            }  
        } else {  
            return 'error';
        }  
        return $dirFileArray;  
    }

    /**
    * 将数组中的gbk字符串转换为utf8 
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function arrGbkToUtf8($data)
    {
        foreach ($data as $key => $value) {
            $strType = mb_detect_encoding($value, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
            if($strType == 'EUC-CN') {
                $data[$key] = mb_convert_encoding($value, "UTF-8", "GBK");
            }
        }
        return $data;
    }

    /**
    * 将app字符串转换为系统中的GBK类型，目前只支持win中文版，linux版
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function appToSystemChar($value)
    {
        if(strtolower(substr(PHP_OS, 0, 3)) == 'win') {
            $value = mb_convert_encoding($value, "GBK", "UTF-8");
        }

        return $value;
    }

    /**
    * 将系统字符串转换为app中的utf8类型，目前只支持win中文版，linux版
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function systemToAppChar($value)
    {
        if(strtolower(substr(PHP_OS, 0, 3)) == 'win') {
            $strType = mb_detect_encoding($value, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
            if($strType == 'EUC-CN') {
                $value = mb_convert_encoding($value, "UTF-8", "GBK");
            }
        }

        return $value;
    }

    /**
    * 循环删除目录和文件函数
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function delDirAndFile($dirPath)
    {
        if(is_file($dirPath)) {
            $result = unlink($dirPath);
        } else {
            if ($handle = opendir($dirPath)) {
                while (false !== ($item = readdir($handle))) {
                    if ($item != "." && $item != "..") {
                        if (is_dir("$dirPath/$item")) {
                            self::delDirAndFile("$dirPath/$item");
                        } else {
                            if(!unlink("$dirPath/$item")) {
                                return 'error';
                            }
                        }
                    }
                }
                closedir($handle);
                if (!rmdir($dirPath)) {
                    return 'error';
                }
            }
        }
    }

    /**
    * 创建文件夹
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function makeDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            $result = mkdir($dirPath,0777,true);
            if ($result) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'error';
        }
    }

    /**
    * 错误时返回json数据
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function jsonError($msg,$url = '')
    {
        $result['msg'] = $msg;
        $result['url'] = $url;
        $result['status'] = 'error';
        return $result;
    }

    /**
    * 成功是返回json数据
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function jsonSuccess($msg,$url ='',$data = '')
    {
        $result['msg'] = $msg;
        $result['url'] = $url;
        $result['data'] = $data;
        $result['status'] = 'success';
        return $result;
    }

    /**
    * 判断文件夹是否为空
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function isEmptyDir($path)
    {    
        $handler = @opendir($path);
        $i=0;
        while($_file=readdir($handler)){
            $i++;
        }
        closedir($handler);
        if($i>2) {
            return false;
        } else {
            return true;  //文件夹为空
        }
    }

    /**
    * 复制文件到文件夹
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function copyFileToDir($sourceFile, $dir)
    {
        if(is_dir($sourceFile)){ // 如果你希望同样移动目录里的文件夹
            return self::copyDirToDir($sourceFile, $dir);
        }
        if(!file_exists($sourceFile)){
            return 'error';
        }
        $filename = basename($sourceFile);
        return copy($sourceFile, $dir .'/'. $filename);
    }

    /**
    * 复制文件夹到文件夹
    * @author tangtanglove <dai_hang_love@126.com>
    */
    static function copyDirToDir($sourceDir, $dir)
    {
        if((!is_dir($sourceDir)) || (!is_dir($dir))){
            return 'error';
        }
        // 要复制到新目录
        $newPath = $dir.'/'.basename($sourceDir);
        if(!realpath($newPath)){ // 
            mkdir($newPath);
        }
        foreach(glob($sourceDir.'/*') as $filename)
        {
            self::copyFileToDir($filename, $newPath);
        }
    }

    /**
    * 把返回的数据集转换成Tree
    * @param array $list 要转换的数据集
    * @param string $pid parent标记字段
    * @param string $level level标记字段
    * @return array
    */
    static function listToTree($list, $pk='id',$pid = 'pid',$child = '_child',$root=0) {
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
    * 把Tree转换为有序列表
    * @return array
    */
    static function treeToOrderList($arr,$level=0,$filed='name') {
        static $tree=array();
        foreach ($arr as $key=>$val) {
                $val[$filed] = str_repeat('—', $level).$val[$filed];
                $tree[]=$val;
                if (isset($val['_child'])) {
                    self::treeToOrderList($val['_child'],$level+1,$filed);
                }        
            }
        return $tree;
    }

    /**
    * 添加keyvalue
    * @return array
    */
    static function addKeyValue($collection,$uuid,$data) {
        $result = KeyValue::create([
            'collection' => $collection,
            'uuid' => $uuid,
            'data' => json_encode($data)
        ]);
        return $result;
    }

    /**
    * 更新keyvalue
    * @return array
    */
    static function updateKeyValue($collection,$uuid,$data) {
        $result = KeyValue::where('collection',$collection)->where('uuid',$uuid)->update(['data'=>json_encode($data)]);
        return $result;
    }

    /**
    * 获取keyvalue
    * @return array
    */
    static function getKeyValue($uuid,$collection='') {
        $query = KeyValue::query();
        if(!empty($collection)) {
            $query = $query->where('collection',$collection);
        }

        $result = $query->where('uuid',$uuid)->first()->toArray();
        if(!empty($result['data'])) {
            return json_decode($result['data'],true);
        }

    }

    /**
    * 删除keyvalue
    * @return array
    */
    static function delKeyValue($uuid,$collection='') {
        $query = KeyValue::query();
        if(!empty($collection)) {
            $query = $query->where('collection',$collection);
        }

        $result = $query->where('uuid',$uuid)->delete();
        return $result;
    }

    /**
    * 判断当前url是否被选中
    * @author tangtanglove <dai_hang_love@126.com>
    */
	static function active($url,$active = 'active')
    {
        $fullUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if(strpos($fullUrl, $url) !== false) {
            return $active;
        } else {
            return '';
        }
    }

    /**
     * sms_post Sioo希奥发送手机短信接口
     * @return string 验证码（用于测试）$uid  = '500',$auth = '680d1acc90b4f062'
     */
    static function siooSendSms($uid,$auth,$phone,$content) {
        if(preg_match("/^1[34578]\d{9}$/", $phone)) {
            //执行发短信
            $msg  = $content;
            $msg  = mb_convert_encoding($msg,'GBK','utf-8');
            $va_url = "http://sms.10690221.com:9011/hy/?uid=".$uid."&auth=".$auth."&mobile=".$phone."&msg=".$msg."&expid=0"; //验证的 url 链接地址  
            $ch = curl_init($va_url);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
            $pageContents = curl_exec($ch);
            curl_close($ch);
        } else {
            $this->error('手机号错误！');
        }

        if ($pageContents>=0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * sms_post Alidayu发送手机短信接口
     * string $config = ['app_key' => '*****','app_secret' => '************',// 'sandbox' => true,  // 是否为沙箱环境，默认false;
     * string $signName = '积木云'
     * string $templateCode = 'SMS_70450333'
     * string $phone = '15076569633'
     * string $smsParam = [ 'number' => rand(100000, 999999)]
     */
    static function alidayuSendSms($config,$signName,$templateCode,$phone,$smsParam) {
        if(preg_match("/^1[34578]\d{9}$/", $phone)) {
            //执行发短信
            $client = new Client(new App($config));
            $req    = new AlibabaAliqinFcSmsNumSend;

            $req->setRecNum($phone)
                ->setSmsParam($smsParam)
                ->setSmsFreeSignName($signName)
                ->setSmsTemplateCode($templateCode);

            $resp = $client->execute($req);
        } else {
            $this->error('手机号错误！');
        }
    }
}
