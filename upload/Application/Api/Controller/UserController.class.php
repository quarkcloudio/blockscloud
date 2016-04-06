<?php
namespace Api\Controller;
require_once APP_PATH . 'User/Conf/config.php';
use Think\Upload;
/**
 * 用户中心功能API
 */
class UserController extends CommonController
{

    /**
     * do_get 获取用户信息
     * @return json
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    public function do_get() {

        //获取uid
        $uid = I('get.uid');

        //验证身份
        if ($uid && $uid == UID) {
            $data = M('Member')->where(array('uid'=>$uid))->find();
            //返回数据
            if ($data) {
                $return['status'] = 200;
                $return['info'] = "获取成功！";
                $return['data'] = $data;
                $this->response($return,'json');
            } else {
                $this->restError("获取失败！");
            }
        }else{
            $this->restError("身份不符！");
        }
        
    }

    /**
     * 修改个人资料
     * @return json
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    public function do_put() {

        //获取uid
        $uid = I('uid');
        $data['nickname'] = I('nickname');
        $data['sex']      = I('sex');
        $data['birthday'] = I('birthday');
        $data['qq']       = I('qq');

        //验证身份
        if ($uid && $uid == UID) {

            //执行修改
            $result = M('Member')->where(array('uid'=>$uid))->save($data);

            //返回数据
            if ($result) {
                $this->restSuccess('修改成功！');
            } else {
                $this->restError("修改失败！");
            }
        }else{
            $this->restError("身份不符！");
        }
    }

    /**
     * 修改个人密码
     * @return json
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    public function pass_put() {

        //获取uid
        $uid = I('uid');
        $old_password  = I('put.oldPassword');
        $new_password  = I('put.newPassword');
        $conf_password = I('put.confPassword');
        
        //验证身份
        if ($uid && $uid == UID) {

            if ($new_password !== $conf_password) {
                $this->restError('两次密码不一致',300);
            }

            //获取原密码
            $get_password = M('UcenterMember')->where(array('id'=>$uid))->getField('password');
            if ($get_password !== think_ucenter_md5($old_password, UC_AUTH_KEY)) {
                $this->restError('原密码错误',300);
            }
            
            $data['password']   =   think_ucenter_md5($new_password, UC_AUTH_KEY);

            //执行修改
            $result = M('UcenterMember')->where(array('id'=>$uid))->save($data);

            //返回数据
            if ($result) {
                $this->restSuccess('修改成功！');
            } else {
                $this->restError("修改失败！");
            }
        }else{
            $this->restError("身份不符！");
        }
    }

    /**
     * 上传头像
     * @return json
     * @author tangtanglove  <869716224@qq.com>
     */
    public function avatar_post()
    {

        //获取uid
        $uid = I('post.uid');
        //验证身份
        if ($uid && $uid == UID) {
            $setting = array(
                'mimes'    => '', //允许上传的文件MiMe类型
                'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
                'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
                'autoSub'  => true, //自动子目录保存文件
                'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
                'rootPath' => './Uploads/Avatar/', //保存根路径
                'savePath' => '', //保存路径
                'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
                'saveExt'  => '', //文件保存后缀，空则使用原后缀
                'replace'  => false, //存在同名是否覆盖
                'hash'     => true, //是否生成hash编码
                'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
            );
            $upload = new \Think\Upload($setting, 'Local');// 实例化上传类
            // 上传文件 
            $info   =   $upload->upload($_FILES);
            $path = $url = $setting['rootPath'].$info['file']['savepath'].$info['file']['savename'];
            $url = str_replace('./', '/', $url);
            $info['fullpath'] = $url;
            if($info){

                $has_avatar = M('Avatar')->where(array('uid'=>$uid))->find();
                
                if ($has_avatar) {
                    M('Avatar')->where(array('uid'=>$uid))->save(array('path'=>$path));
                }else{
                    $data['uid'] = $uid;
                    $data['path'] =$path;
                    $data['create_time'] = time();
                    M('Avatar')->add($data);
                }

                $return['status'] = 200;
                $return['info'] = "图片上传成功！";
                $return['data'] = $info;
                $this->response($return,'json');
            }else{
                $this->restError('上传失败',300);
            }

       }else{
         $this->restError("身份不符！");
       }

    }

}
