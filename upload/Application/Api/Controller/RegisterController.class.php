<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace Api\Controller;
require_once APP_PATH . 'User/Conf/config.php';

/**
 * 注册功能API
 */
class RegisterController extends BaseController{

    /**
     * do_post 用户注册
     * @author by tangtanglove 飞马踏清秋
     * @return json json数据
     */
    public function do_post() {

        /*用户名*/
        $data['username'] = I('post.username');

        /*用户密码*/
        $password         = I('post.password');
        $data['password'] = think_ucenter_md5($password, UC_AUTH_KEY);

        /*用户邮箱*/
        $email         = I('post.email');
        if (empty($email)) {
            $data['email'] = $data['username'].'@admin.com';
        }else{
            $data['email'] = $email;
        }

        /*当前时间*/
        $data['reg_time'] = time();

        /*用户状态*/
        $data['status'] = 1;

        /*验证码*/
        $code         = I('post.verifyCode');

        //判断手机号是不是正确
        if (!$this->isMobile($data['username'])) {
            $this->restError('手机号格式错误！');
        }

        /*检验验证码*/
        if (!empty($code)) {

            //验证码信息
            $VerifyCodeInfo   =   D('VerifyCode')->info($data['username'],$code,1);

            //判断验证码正确性
            if (empty($VerifyCodeInfo)) {
                $this->restError('验证码错误！');
            }

            //检验验证码有效期
            $result_time=$data['reg_time']-$VerifyCodeInfo['create_time'];
            if ($result_time>C('VERIFY_VALID')) {
                $this->restError('验证码已过期！');
            }

        }else{
            $this->restError('验证码不能为空！');
        }

        /*验证账号,密码*/
        if (empty($data['username']) || empty($data['password'])) {
            $this->restError('用户名或密码不能为空！');
        }else{
            /*是否已经注册过*/
            $hasuser=M('UcenterMember')->where(array('username'=>$data['username']))->find();
            if ($hasuser) {
                $this->restError('用户名已经注册过！');
            }
        }

        /*写入数据库*/
        $uid=M('UcenterMember')->add($data);

        //写入Member表
        M('Member')->add(array('uid'=>$uid,'nickname'=>$data['username'],'status'=>1));

        if ($uid) {
            $return['status'] = 200;
            $return['info'] = "注册成功！";
            $return['data'] = array('username' => $data['username'], 'uid' => $uid);
            $this->response($return,'json');
        }else{
            $this->restError("注册失败，请重试！");
        }
    }

    /**
     * 验证手机号是否正确
     * @author tangtanglove
     * @param int $mobile
     */
    protected function isMobile($mobile) {
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }


}
