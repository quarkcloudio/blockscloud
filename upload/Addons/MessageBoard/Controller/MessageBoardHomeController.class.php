<?php
namespace Addons\MessageBoard\Controller;
use Home\Controller\AddonsController;
class MessageBoardHomeController extends AddonsController{
	/* 添加留言 */
	public function add(){
		$this->meta_title = '添加留言';

		//判断验证码
		$verify = I('post.verify');
	    if(!check_verify($verify)){
            $this->error('验证码输入错误！');
        }

        //提交数据库
		$res = D('Addons://MessageBoard/MessageBoard')->update();
		if(!$res){
			$this->error(D('Addons://MessageBoard/MessageBoard')->getError());
		}else{
			$this->success('提交成功');
		}
	}

	// 验证码
    public function verify(){
        $verify = new \Think\Verify();
        $verify->useNoise = false;
        $verify->useCurve = false;
        $verify->entry(1);
    }
	
}
