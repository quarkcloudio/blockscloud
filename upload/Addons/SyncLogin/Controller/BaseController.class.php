<?php

namespace Addons\SyncLogin\Controller;

use Think\Hook;
use User\Api\UserApi;
use Home\Controller\AddonsController;

require_once(dirname(dirname(__FILE__)) . "/ThinkSDK/ThinkOauth.class.php");


class BaseController extends AddonsController
{

    private  $access_token = '';
    private $openid = '';
    private $type = '';
    private $token = array();


    public function _initialize()
    {
        $this->token = session('SYNCLOGIN_TOKEN');
        $this->type = session('SYNCLOGIN_TYPE');
        $this->openid = session('SYNCLOGIN_OPENID');
        $this->access_token = session('SYNCLOGIN_ACCESS_TOKEN');
    }

    //登录地址
    public function login()
    {
        $type = I('get.type');
        empty($type) && $this->error('参数错误');
        //加载ThinkOauth类并实例化一个对象
        $sns = \ThinkOauth::getInstance($type);
        //跳转到授权页面
        redirect($sns->getRequestCodeURL());
    }


    /**
     * 登陆后回调地址
     * autor:xjw129xjt
     */
    public function callback()
    {
        $code = I('get.code');
        $type = I('get.type');
        $is_login = is_login();
        $sns = \ThinkOauth::getInstance($type);

        //腾讯微博需传递的额外参数
        $extend = null;
        if ($type == 'tencent') {
            $extend = array('openid' => I('get.openid'), 'openkey' => I('get.openkey'));
        }

        $token = $sns->getAccessToken($code, $extend);
        session('SYNCLOGIN_TOKEN', $token);
        session('SYNCLOGIN_TYPE', $type);
        session('SYNCLOGIN_OPENID', $token['openid']);
        session('SYNCLOGIN_ACCESS_TOKEN', $token['access_token']);
        $check = D('sync_login')->where("`type_uid`='" . $token['openid'] . "' AND type='" . $type . "'")->select();
        $addon_config = get_addon_config('SyncLogin');

        if($is_login){
            $this->dealIsLogin($is_login);
        }else{
            if ($addon_config['bind'] && !$check) {
                redirect(addons_url('SyncLogin://Base/bind'));
            } else {

                $this->unbind();
            }
        }

    }

    /**
     * 利用uid登录
     * @param $uid
     * autor:xjw129xjt
     */
    protected function loginWithoutpwd($uid)
    {
        if (0 < $uid) { //UC登录成功
            /* 登录用户 */
            $Member = D('Member');
            if ($Member->login($uid, false)) { //登录用户
                //TODO:跳转到登录前页面
                //redirect(U('Home/Index/index'));
                $this->success('登录成功！', U('Home/Index/index'));
            } else {
                $this->error($Member->getError());
            }
        }
    }

    /**
     * 增加sync_login表中数据
     * @param $uid
     * @param $token
     * @param $openID
     * @param $type
     * @param $oauth_token_secret
     * @return mixed
     * autor:xjw129xjt
     */
    protected function addSyncLoginData($uid, $token, $openID, $type, $oauth_token_secret)
    {
        $data['uid'] = $uid;
        $data['type_uid'] = $openID;
        $data['oauth_token'] = $token;
        $data['oauth_token_secret'] = $oauth_token_secret;
        $data['type'] = $type;
        $res = D('sync_login')->add($data);
        return $res;
    }

    /**
     * 将头像保存到本地
     * @param $url
     * @param $oid
     * @param $uid
     * autor:xjw129xjt
     */
    protected function saveAvatar($url, $oid, $uid, $type)
    {

        if (is_sae()) {
            $s = new \SaeStorage();
            $img = file_get_contents($url); //括号中的为远程图片地址

            $url_sae = $s->write(C('UPLOAD_SAE_CONFIG.domain'), '/Avatar/' . $type . 'Avatar/' . $oid . '.jpg', $img);
            $data['path'] = $url_sae;
        } else {
            mkdir('./Uploads/Avatar/' . $type . 'Avatar', 0777, true);
            $img = file_get_contents($url);
            $filename = './Uploads/Avatar/' . $type . 'Avatar/' . $oid . '.jpg';
            file_put_contents($filename, $img);
            $data['path'] = $type . 'Avatar/' . $oid . '.jpg';
        }
        $data['uid'] = $uid;
        $data['create_time'] = time();
        $data['status'] = 1;
        $data['is_temp'] = 0;
        D('avatar')->add($data);

    }

    public function bind()
    {
        $this->checkIsBind();
        $tip = I('get.tip');
        $tip == '' && $tip = 'new';
        $this->assign('tip', $tip);
        $this->display(T('Addons://SyncLogin@Base/bind'));
    }

    public function newAccount()
    {



        $username = I('post.username');
        $nickname = I('post.nickname');
        $email = I('post.email');
        $password = I('post.password');

        $User = new UserApi;
        $uid = $User->register($username, $nickname, $password, $email);
        if (0 < $uid) { //注册成功
            $this->addSyncLoginData($uid, $this->access_token, $this->openid, $this->type, $this->openid);
            $uid = $User->login($username, $password); //通过账号密码取到uid
            D('Member')->login($uid, false); //登陆
            $this->success('绑定成功！',U('Home/Index/index'));
        } else { //注册失败，显示错误信息
            $this->error($this->showRegError($uid));
        }

    }

    public function existLogin()
    {

        $username = I('post.username');
        $password = I('post.password');
        $remember = I('post.remember');

        $user = new UserApi;
        $uid = $user->login($username, $password);

        if (0 < $uid) { //UC登录成功
            /* 登录用户 */
            $Member = D('Member');
            if ($Member->login($uid, $remember == 'on')) { //登录用户
                $this->addSyncLoginData($uid, $this->access_token, $this->openid, $this->type, $this->openid);
                //TODO:跳转到登录前页面
                $this->success('登录成功！', U('Home/Index/index'));
            } else {
                $this->error($Member->getError());
            }

        } else { //登录失败
            switch ($uid) {
                case -1:
                    $error = '用户不存在或被禁用！';
                    break; //系统级别禁用
                case -2:
                    $error = '密码错误！';
                    break;
                default:
                    $error = '未知错误27！';
                    break; // 0-接口参数错误（调试阶段使用）
            }
            $this->error($error);
        }

    }


    public function unbind()
    {
     $this->checkIsBind();
        $access_token =session('SYNCLOGIN_ACCESS_TOKEN');
        $openid = session('SYNCLOGIN_OPENID');
        $type =  session('SYNCLOGIN_TYPE');
        $token =session('SYNCLOGIN_TOKEN');
        $user_info = D('Addons://SyncLogin/Info')->$type($token);
        if ($info1 = D('sync_login')->where("`type_uid`='" . $openid . "' AND type='" . $type . "'")->find()) {
            $user = D('UcenterMember')->where("id=" . $info1 ['uid'])->find();
            if (empty ($user)) {
                D('sync_login')->where("type_uid=" . $openid . " AND type='" . $type . "'")->delete();
                //已经绑定过，执行登录操作，设置token
            } else {
                if ($info1 ['oauth_token'] == '') {
                    $syncdata ['id'] = $info1 ['id'];
                    $syncdata ['oauth_token'] = $access_token;
                    $syncdata ['oauth_token_secret'] = $openid;
                    D('sync_login')->save($syncdata);
                }
                $uid = $info1 ['uid'];
            }
        } else {
            $Api = new UserApi();
            //usercenter表新增数据
            $uid = $Api->addSyncData();
            //member表新增数据
            D('Home/Member')->addSyncData($uid, $user_info);

            // 记录数据到sync_login表中
            $this->addSyncLoginData($uid, $access_token, $openid, $type, $openid);
            //保存头像
            $this->saveAvatar($user_info['head'], $openid, $uid, $type);
            $config = D('Config')->where(array('name' => 'USER_REG_WEIBO_CONTENT'))->find();
            $reg_weibo = $config['value']; //用户注册的微博内容
            if ($reg_weibo != '' && $config) { //为空不发微博
                D('Weibo/Weibo')->addWeibo($uid, $reg_weibo);
            }
        }
        $this->loginWithoutpwd($uid);

    }

    public function checkIsBind(){
        $check = D('sync_login')->where("`type_uid`='" . $this->openid . "' AND type='" . $this->type . "'")->select();
        if($check){
            redirect(U('Home/Index/index'));
        }
    }

    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0)
    {
        switch ($code) {
            case -1:
                $error = '用户名长度必须在16个字符以内！';
                break;
            case -2:
                $error = '用户名被禁止注册！';
                break;
            case -3:
                $error = '用户名被占用！';
                break;
            case -4:
                $error = '密码长度必须在6-30个字符之间！';
                break;
            case -5:
                $error = '邮箱格式不正确！';
                break;
            case -6:
                $error = '邮箱长度必须在1-32个字符之间！';
                break;
            case -7:
                $error = '邮箱被禁止注册！';
                break;
            case -8:
                $error = '邮箱被占用！';
                break;
            case -9:
                $error = '手机格式不正确！';
                break;
            case -10:
                $error = '手机被禁止注册！';
                break;
            case -11:
                $error = '手机号被占用！';
                break;
            case -20:
                $error = '用户名只能由数字、字母和"_"组成！';
                break;
            case -21:
                $error = '昵称不能少于两个字！';
                break;
            case -30:
                $error = '昵称被占用！';
                break;
            case -31:
                $error = '昵称被禁止注册！';
                break;
            case -32:
                $error = '昵称只能由数字、字母、汉字和"_"组成！';
                break;
            default:
                $error = '未知错误24';
        }
        return $error;
    }
    protected function dealIsLogin($uid=0){
        $access_token =session('SYNCLOGIN_ACCESS_TOKEN');
        $openid = session('SYNCLOGIN_OPENID');
        $type =  session('SYNCLOGIN_TYPE');
        if( $check = D('sync_login')->where(array('type_uid' => $openid, 'type' => $type))->find()){
            $this->error('该帐号已经被绑定！');
        }
        $this->addSyncLoginData($uid, $access_token, $openid, $type, $openid);
        $this->success('绑定成功！', U('usercenter/config/index'));
    }

}