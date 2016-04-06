<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Addons\Advs\Controller;
use Admin\Controller\AddonsController; 

class AdvsController extends AddonsController{
	/* 添加 */
	public function add(){
		$current = U('/Admin/Addons/adminList/name/Advs');
		$sing = M('advertising')->where('status = 1')->select();
		$this->assign('current',$current);
		$this->assign('sing',$sing);
		$this->display(T('Addons://Advs@Advs/edit'));
	}
	
	/* 编辑 */
	public function edit(){
		$id     =   I('get.id','');
		$current = U('/Admin/Addons/adminList/name/Advs');
		$sing = M('advertising')->where('status = 1')->select();
		$detail = D('Addons://Advs/Advs')->detail($id);
		$this->assign('info',$detail);
		$this->assign('current',$current);
		$this->assign('sing',$sing);
		$this->display(T('Addons://Advs@Advs/edit'));
	}
	
	/* 禁用 */
	public function forbidden(){
		$id     =   I('get.id','');
		if(D('Addons://Advs/Advs')->forbidden($id)){
			$this->success('成功禁用该广告', Cookie('__forward__'));
		}else{
			$this->error(D('Addons://Advs/Advs')->getError());
		}
	}
	
	/* 启用 */
	public function off(){
		$id     =   I('get.id','');
		if(D('Addons://Advs/Advs')->off($id)){
			$this->success('成功启用该广告',Cookie('__forward__'));
		}else{
			$this->error(D('Addons://Advs/Advs')->getError());
		}
	}
	
	/* 删除 */
	public function del(){
		$id     =   I('get.id','');
		if(D('Addons://Advs/Advs')->del($id)){
			$this->success('删除成功', Cookie('__forward__'));
		}else{
			$this->error(D('Addons://Advs/Advs')->getError());
		}
	}
	
	/* 更新 */
	public function update(){
		$res = D('Addons://Advs/Advs')->update();
		if(!$res){
			$this->error(D('Addons://Advs/Advs')->getError());
		}else{
			if($res['id']){
				$this->success('更新成功', Cookie('__forward__'));
			}else{
				$this->success('新增成功', Cookie('__forward__'));
			}
		}
	}
	/**
	 * 批量处理
	 */
	public function savestatus(){
		$status = I('get.status');
		$ids = I('post.id');
		
		if($status == 1){
			foreach ($ids as $id)
			{
				D('Addons://Advs/Advs')->off($id);
			}
			$this->success('成功启用该广告',Cookie('__forward__'));
		}else{
			foreach ($ids as $id)
			{
				D('Addons://Advs/Advs')->forbidden($id);
			}
			$this->success('成功禁用该广告',Cookie('__forward__'));
		}			

	}
}
