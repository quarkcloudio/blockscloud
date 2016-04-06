<?php
/**
 * 
 * @author quick
 *
 */
namespace Addons\Advertising\Controller;
use Admin\Controller\AddonsController;

class AdvertisingController extends AddonsController{
	/**
	 * 添加广告位
	 */
	public function add(){
		$current = U('/Admin/Addons/adminList/name/Advertising');
		$this->assign('current',$current);
		$this->display(T('Addons://Advertising@Advertising/edit'));
	}
	
	/* 编辑 */
	public function edit(){
		$id     =   I('get.id','');
		$current = U('/Admin/Addons/adminList/name/Advertising');
		$detail = D('Addons://Advertising/Advertising')->detail($id);
		$this->assign('info',$detail);
		$this->assign('current',$current);
		$this->display(T('Addons://Advertising@Advertising/edit'));
	}
	
	/* 禁用 */
	public function forbidden(){
		$id     =   I('get.id','');
		if(D('Addons://Advertising/Advertising')->forbidden($id)){
			$this->success('成功禁用该广告', Cookie('__forward__'));
		}else{
			$this->error(D('Addons://Advertising/Advertising')->getError());
		}
	}
	
	/* 启用 */
	public function off(){
		$id     =   I('get.id','');
		if(D('Addons://Advertising/Advertising')->off($id)){
			$this->success('成功启用该广告',Cookie('__forward__'));
		}else{
			$this->error(D('Addons://Advertising/Advertising')->getError());
		}
	}
	
	/* 删除 */
	public function del(){
		$id     =   I('get.id','');
		if(D('Addons://Advertising/Advertising')->del($id)){
			$this->success('删除成功', Cookie('__forward__'));
		}else{
			$this->error(D('Addons://Advertising/Advertising')->getError());
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
				D('Addons://Advertising/Advertising')->off($id);
			}
			$this->success('成功启用该广告位',Cookie('__forward__'));
		}else{
			foreach ($ids as $id)
			{
				D('Addons://Advertising/Advertising')->forbidden($id);
			}
			$this->success('成功禁用该广告位',Cookie('__forward__'));
		}
	
	}	
	
	/* 更新 */
	public function update(){
		$res = D('Addons://Advertising/Advertising')->update();
		if(!$res){
			$this->error(D('Addons://Advertising/Advertising')->getError());
		}else{
			if($res['id']){
				$this->success('更新成功', Cookie('__forward__'));
			}else{
				$this->success('新增成功', Cookie('__forward__'));
			}
		}
	}	
}