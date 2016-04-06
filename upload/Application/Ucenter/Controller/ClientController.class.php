<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Ucenter\Controller;
use Ucenter\Client\Client;
class ClientController extends Client{

    public function index()
    {
        $test = $this->appIsLogin();
        dump($test);
    }

    /**
     * UCenter客户端登录UCenter
     */
    public function login($username,$password)
    {
        //通过接口判断登录帐号的正确性，返回值为数组
        list($get_uid, $get_username, $get_password, $get_email) = $this->uc_user_login($username, $password);
        setcookie('discuz_ucenter_auth', '', -86400);
        if($get_uid > 0) {
            //用户登陆成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
            setcookie('discuz_ucenter_auth', $this->uc_authcode($get_uid."\t".$get_username, 'ENCODE'));
            //生成同步登录的代码
            $ucsynlogin = $this->uc_user_synlogin($get_uid);
            //返回js脚本
            return $ucsynlogin;
        } elseif($get_uid == -1) {
            //用户不存在,或者被删除
            return -1;
        } elseif($get_uid == -2) {
            //密码错
            return -2;
        } else {
            //未定义;
            return -3;
        }
    }

    /**
     * 判断本应用是否通过UCenter登录
     */
    public function appIsLogin()
    {
        if (!empty($_COOKIE["discuz_ucenter_auth"])) {
            //登录成功，则解析用户信息
            return explode("\t", $this->uc_authcode($_COOKIE['discuz_ucenter_auth'], 'DECODE'));
        }else{
            return 0;
        }
    }

    /**
     * 积木云退出时调用此方法使其他应用也同步退出
     */
    public function logout()
    {
    	$synlogout = $this->uc_user_synlogout();
        //返回js脚本
        return $synlogout;
    }

    /**
     * 判断Ucenter是否存在此用户
     */
    public function get_user_info($username)
    {
        return $this->uc_get_user($username);
    }

    /**
     * Ucenter用户注册
     * -1:用户名不合法
     * -2:包含要允许注册的词语
     * -3:用户名已经存在
     * -4:Email 格式有误
     * -5:Email 不允许注册
     * -6:该 Email 已经被注册
     */
    public function register($username,$password,$email)
    {
        $uid = $this->uc_user_register($username, $password, $email);
        if($uid >= 0) {
            setcookie('discuz_ucenter_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
        }
        return $uid;
    }

    /**
     * 修改用户资料
     */
    public function editprofile($username,$oldpw,$newpw,$email)
    {
        return $this->uc_user_edit($username, $oldpw, $newpw, $email, $ignoreoldpw = 0, $questionid = '', $answer = '');
    }

}