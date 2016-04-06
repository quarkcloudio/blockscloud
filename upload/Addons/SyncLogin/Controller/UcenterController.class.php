<?php

namespace Addons\SyncLogin\Controller;

use Think\Hook;
use User\Api\UserApi;
use Home\Controller\AddonsController;

require_once(dirname(dirname(__FILE__)) . "/ThinkSDK/ThinkOauth.class.php");


class UcenterController extends AddonsController
{

    public function bind()
    {
        $addon_config = get_addon_config('SyncLogin');
        $arr = array();
        foreach ($addon_config['type'] as &$v) {
            $arr[$v]['name'] = strtolower($v);
            $arr[$v]['is_bind'] = $this->check_is_bind_account(is_login(), strtolower($v));
            if ($arr[$v]['is_bind']) {
                $token = D('sync_login')->where(array('type'=>strtolower($v),'uid'=>is_login()))->find();
                $user_info = D('Addons://SyncLogin/Info')->$arr[$v]['name'](array('access_token'=>$token['oauth_token'],'openid'=>$token['oauth_token_secret']));
                $arr[$v]['info'] =$user_info;
            }
        }
        unset($v);

        $this->assign('list', $arr);

        $this->assign('addon_config', $addon_config);
        $this->assign('tabHash', 'bind');
        $this->display(T('Addons://SyncLogin@Ucenter/bind'));
    }

    protected function check_is_bind_account($uid = 0, $type = '')
    {
        $check = D('sync_login')->where(array('uid' => $uid, 'type' => $type))->find();
        if ($check) {
            return true;
        }
        return false;
    }
    public function unbind(){
        $aType = I('post.type','','op_t');
        if(empty($aType)){
            $this->error('参数错误');
        }
        if(!is_login()){
            $this->error('请登录！');
        }
        $uid = is_login();
        $res=  D('sync_login')->where(array('uid' => $uid, 'type' => $aType))->delete();
        if($res){
            $this->success('取消绑定成功','refresh');
        }
        $this->error('取消绑定失败');
    }

}