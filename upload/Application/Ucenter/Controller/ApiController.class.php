<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Ucenter\Controller;
use Ucenter\Api\Uc;
class ApiController extends Uc{
	/**
	 * UCenter接收服务端命令控制器
	 * 配置UCenter应用的主 URL:http://www.blockscloud.com/index.php/Ucenter/Api/index
	 * 配置Application/Ucenter/Conf/uc.php
	 */
    public function index(){
        $result =$this->response();
    }

    public function mytest()
    {
    	dump($_COOKIE["discuz_ucenter_auth"]) ;
    }

}