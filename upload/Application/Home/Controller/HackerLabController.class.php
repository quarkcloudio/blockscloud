<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HackerLabController extends HomeController {

	/* xss */
	public function xss(){
		$uid 		= I('uid');
		$url 		= I('url');
		$parameter  = I('parameter');
		$time		= time();
		$data['uid'] 			= $uid;
		$data['url'] 			= $url;
		$data['parameter']		= $parameter;
		$data['create_time']	= $time;
		$result = M('HackerLab')->add($data);
		if ($result) {
			$this->ajaxReturn('ok','jsonp');
		} else {
			$this->ajaxReturn('error','jsonp');
		}
		
	}


}
