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
use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class UserController extends CommonController {

	/* 用户中心首页 */
	public function index(){
		
	}

    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function password(){
        if ( IS_POST ) {
            //获取参数
            $uid        =   UID;
            $password   =   I('post.old');
            $repassword = I('post.repassword');
            $data['password'] = I('post.password');
            empty($password) && $this->error('请输入原密码');
            empty($data['password']) && $this->error('请输入新密码');
            empty($repassword) && $this->error('请输入确认密码');

            if($data['password'] !== $repassword){
                $this->error('您输入的新密码与确认密码不一致');
            }

            $Api = new UserApi();
            $res = $Api->updateInfo($uid, $password, $data);
            if($res['status']){
                $this->success('修改密码成功！');
            }else{
                $this->error($res['info']);
            }
        }else{
            $this->display(use_theme());
        }
    }

    /**
     * 用户文章
     * @author huajie <banhuajie@163.com>
     */
    public function article(){
		$Document = M('Document'); // 实例化User对象
        $search   = I('search');
        if (!empty($search)) {
            $where['title'] = array('like',"%$search%");
        }
		$where['status'] = array('gt',0);
		$where['uid'] 	 = UID;
		$count      = $Document->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $Document->where($where)->order('create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display(use_theme());
    }

    /**
     * 添加文章
     * @author tangtanglove dai_hang_love@126.com
     */
    public function addArticle(){
        if ( IS_POST ) {

            $title   	 = I('post.title');
            $cate_id 	 = I('post.cate_id');
            $description = I('post.description');
            $content 	 = I('post.content');

            if (empty($cate_id) || empty($title) || empty($description) || empty($content)) {
            	$this->error('参数错误！');
            }

			/* 获取分类信息 */
			$category = D('Category')->info($cate_id);

            $data['title'] 		 = $title;
            $data['category_id'] = $cate_id;
            $data['model_id'] 	 = 2;
            $data['description'] = $description;
            $data['uid'] = UID;
            $data['create_time'] = time();
            $data['update_time'] = time();

            //是否需要审核
            $category['check'] ? $data['status'] = 2 : $data['status'] = 1;
            $art_id = M('Document')->add($data);
            $result = M('DocumentArticle')->add(array('id'=>$art_id,'content'=>$content));
            if($result){
                $this->success('操作成功！');
            }else{
                $this->error('操作失败！');
            }
        }else{
	        //超级管理员获取全部动态分类
            if (IS_ROOT) {
                $where['status'] = 1;
                $where['allow_publish'] = array('gt',0);;
            } else {
                $where['status'] = 1;
                $where['allow_publish'] = 2;
            }
            
	        $cate       =   M('Category')->where($where)->field('id,title,pid,allow_publish')->order('pid,sort')->select();
	        $this->assign('nodes',      $cate);
			$this->display(use_theme());
        }
    }

    /**
     * 编辑文章
     * @author tangtanglove dai_hang_love@126.com
     */
    public function editArticle(){

        if ( IS_POST ) {

            $id   	 	 = I('post.id');
            $title   	 = I('post.title');
            $cate_id 	 = I('post.cate_id');
            $description = I('post.description');
            $content 	 = I('post.content');

            if (empty($cate_id) || empty($title) || empty($description) || empty($content)) {
            	$this->error('参数错误！');
            }

			/* 获取分类信息 */
			$category = D('Category')->info($cate_id);

            $data['title'] 		 = $title;
            $data['category_id'] = $cate_id;
            $data['model_id'] 	 = 2;
            $data['description'] = $description;
            $data['update_time'] = time();

            //是否需要审核
            $category['check'] ? $data['status'] = 2 : $data['status'] = 1;
            $article_id = M('Document')->where(array('id'=>$id,'uid'=>UID))->save($data);
            if ($article_id!==false) {
            	$result 	= M('DocumentArticle')->where(array('id'=>$id))->save(array('content'=>$content));
            }else{
            	$this->success('操作越权！');
            }

            if($result!==false){
                $this->success('操作成功！');
            }else{
                $this->error('操作失败！');
            }
        }else{

            //超级管理员获取全部动态分类
            if (IS_ROOT) {
                $where['status'] = 1;
                $where['allow_publish'] = array('gt',0);;
            } else {
                $where['status'] = 1;
                $where['allow_publish'] = 2;
            }
	        $cate       =   M('Category')->where($where)->field('id,title,pid,allow_publish')->order('pid,sort')->select();
	        //获取文章id
	        $article_id     =   I('get.id');
            $article 		= 	M('Document')->where(array('id'=>$article_id,'uid'=>UID))->find();
            if (empty($article)) {
            	$this->error('操作越权！');
            }
            
            $content 	= M('DocumentArticle')->where(array('id'=>$article_id))->getField('content');

	        $this->cate_id  =   $cate_id;
	        $this->assign('nodes',$cate);
	        $this->assign('cate_id',$this->cate_id);
	        $this->assign('article',$article);
	        $this->assign('content',$content);
			$this->display(use_theme());
        }

    }

    /**
     * 删除文章
     * @author tangtanglove dai_hang_love@126.com
     */
    public function deleteArticle(){
        //文章id
        $ids          = I('post.ids');
        if (empty($ids)) {
            $this->error('参数错误！');
        }
        $map['id'] = array('in',$ids);
        $map['uid'] = UID;
        $result = M('Document')->where($map)->save(array('status'=>-1));
        if($result!==false){
            $this->success('操作成功！');
        }else{
            $this->error('操作失败！');
        }

    }

    /**
     * 编辑个人资料
     * @author tangtanglove dai_hang_love@126.com
     */
    public function info(){

        if ( IS_POST ) {

            $sign          = I('post.sign');
            $biography     = I('post.biography');
            $result = M('Member')->where(array('uid'=>UID))->save(array('sign'=>$sign,'biography'=>$biography));
            if($result!==false){
                $this->success('操作成功！');
            }else{
                $this->error('操作失败！');
            }
        }else{
            $user = M('Member')->where(array('uid'=>UID))->find();
	        $this->assign('user',$user);
            $this->display(use_theme());
        }
    }

    /**
     * 编辑头像
     * @author tangtanglove dai_hang_love@126.com
     */
    public function avatar(){

        if ( IS_POST ) {
            $crop = new \Think\Cropper(
              isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null,
              isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null,
              isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null
              );

            $msg    = $crop->getMsg();
            $result = $crop->getResult();

            //将头像写入到数据库
            if (empty($msg) && !empty($result)) {
                $has_avatar = M('Avatar')->where(array('uid'=>UID))->find();
                //存在头像则修改，不存在添加
                if ($has_avatar) {
                    $data['path']   = $result;
                    $data['status'] = 1;
                    M('Avatar')->where(array('uid'=>UID))->save($data);
                }else{
                    $data['uid']    = UID;
                    $data['path']   = $result;
                    $data['status'] = 1;
                    $data['create_time'] = time();
                    //写入头像表
                    M('Avatar')->add($data);
                }
            }

            $response = array(
              'state'   => 200,
              'message' => $msg,
              'result'  => $result
            );

            echo json_encode($response);
        }else{
            $user = M('Member')->where(array('uid'=>UID))->find();
            $this->assign('user',$user);
            $this->display(use_theme());
        }
    }

}
