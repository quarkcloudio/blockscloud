<?php
namespace Addons\MessageBoard\Controller;
use Admin\Controller\AddonsController;
class MessageBoardController extends AddonsController{

	/* 删除留言 */
	public function del(){
		$this->meta_title = '删除留言';
		$id     =   I('get.id','');
		if(D('Addons://MessageBoard/MessageBoard')->del($id)){
			$this->success('删除成功', U('/admin/addons/adminlist',array('name'=>'MessageBoard')));
		}else{
			$this->error(D('Addons://MessageBoard/MessageBoard')->getError());
		}
	}
	
}
