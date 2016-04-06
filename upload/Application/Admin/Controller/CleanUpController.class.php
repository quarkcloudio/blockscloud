<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi as UserApi;

/**
 * 后台清理缓存
 * @author tangtanglove <dai_hang_love@126.com>
 */
class CleanUpController extends AdminController {

    /**
     * 后台清理缓存
     * @author tangtanglove <dai_hang_love@126.com>
     */
    public function index(){

        $dirname = './Runtime/';
        //清文件缓存
        $dirs   =   array($dirname);
        if(function_exists('memcache_init')){
            $mem = memcache_init();
            $mem->flush();
        }
        $result = 1;
        //清理缓存
        foreach($dirs as $value) {
            $get_result = $this->rmdirr($value);
            if (!$get_result) {
                $result = 0;
            }
        }
        //新建Runtime
        @mkdir($dirname,0777,true);
        if ($result) {
            $this->success('加速成功！');
        }else{
            $this->error('操作失败，请重试！');
        }
    }

    /**
     * [rmdirr 删除文件功能]
     * @param  [type] $dirname [文件名称]
     * @return [type]          [description]
     */
    protected function rmdirr($dirname)
    {
        if (!file_exists($dirname)) {
            return false;
        }
        if (is_file($dirname) || is_link($dirname)) {
            return unlink($dirname);
        }
        $dir = dir($dirname);
        if($dir){
            while (false !== $entry = $dir->read()) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
                $this->rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
            }
        }
        $dir->close();
        return rmdir($dirname);
    }

}
