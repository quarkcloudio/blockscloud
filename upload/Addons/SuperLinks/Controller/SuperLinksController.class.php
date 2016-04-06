<?php
namespace Addons\SuperLinks\Controller;
use Admin\Controller\AddonsController;
class SuperLinksController extends AddonsController{
	/* 添加友情连接 */
	public function add(){
		$this->meta_title = '添加友情链接';
		$current = U('/admin/addons/adminlist',array('name'=>'SuperLinks'));
		$this->assign('current',$current);
		$this->display(T('Addons://SuperLinks@SuperLinks/edit'));
	}
	
	/* 编辑友情连接 */
	public function edit(){
		$this->meta_title = '修改友情链接';
		$id     =   I('get.id','');
		$current = U('/admin/addons/adminlist',array('name'=>'SuperLinks'));
		$detail = D('Addons://SuperLinks/SuperLinks')->detail($id);
		$this->assign('info',$detail);
		$this->assign('current',$current);
		$this->display(T('Addons://SuperLinks@SuperLinks/edit'));
	}
	
	/* 禁用友情连接 */
	public function forbidden(){
		$this->meta_title = '禁用友情链接';
		$id     =   I('get.id','');
		if(D('Addons://SuperLinks/SuperLinks')->forbidden($id)){
			$this->success('成功禁用该友情连接', U('/admin/addons/adminlist',array('name'=>'SuperLinks')));
		}else{
			$this->error(D('Addons://SuperLinks/SuperLinks')->getError());
		}
	}
	
	/* 启用友情连接 */
	public function off(){
		$this->meta_title = '启用友情链接';
		$id     =   I('get.id','');
		if(D('Addons://SuperLinks/SuperLinks')->off($id)){
			$this->success('成功启用该友情连接', U('/admin/addons/adminlist',array('name'=>'SuperLinks')));
		}else{
			$this->error(D('Addons://SuperLinks/SuperLinks')->getError());
		}
	}
	
	/* 删除友情连接 */
	public function del(){
		$this->meta_title = '删除友情链接';
		$id     =   I('get.id','');
		if(D('Addons://SuperLinks/SuperLinks')->del($id)){
			$this->success('删除成功', U('/admin/addons/adminlist',array('name'=>'SuperLinks')));
		}else{
			$this->error(D('Addons://SuperLinks/SuperLinks')->getError());
		}
	}
	
	/* 更新友情连接 */
	public function update(){
		$this->meta_title = '更新友情链接';
		$res = D('Addons://SuperLinks/SuperLinks')->update();
		if(!$res){
			$this->error(D('Addons://SuperLinks/SuperLinks')->getError());
		}else{
			if($res['id']){
				$this->success('更新成功',  Cookie('__forward__'));
			}else{
				$this->success('新增成功',  Cookie('__forward__'));
			}
		}
	}
}
