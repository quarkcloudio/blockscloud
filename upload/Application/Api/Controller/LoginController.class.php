<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace Api\Controller;
use User\Api\UserApi;

/**
 * 登录功能API
 */
class LoginController extends BaseController
{

    /**
     * do_post 执行登录接口
     * @return json
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    public function do_post() {

        //接收参数
        $username  = I('post.username');
        $password  = I('post.password');
        $device_id = I('post.deviceId');

        if (empty($username)) {
            $this->restError("用户名或密码为空！");
        }

        /* 调用UC登录接口登录 */
        $getUser = new UserApi;
        $uid = $getUser->login($username, $password);

        if ($uid) {
            //获取用户登录的信息
            $user = M('UcenterMember')->where(array('id' => $uid))->find();
            //考虑异地登录
            if (!empty($device_id)) {
                $user['device_id'] = $device_id;
            }
            $user['last_ip'] = ip2int(get_client_ip());

            //创建TOKEN
            $token = $this->creatToken($user);

            //返回成功
            $return['status'] = 200;
            $return['info'] = "登录成功！";
            $return['data'] = $user;
            $return['token'] = $token;
            $this->response($return,'json');
        }else{
            $this->restError("密码错误");
        }
    }

    /**
     * out_post 退出登陆
     * @return json
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    public function out_post(){
        $user_id = I('post.uid',0,'int');
        $token = I('post.token');
        if ($user_id > 0 && $token) {
            S('api_token_'.$token, null);
            $this->restSuccess("退出成功");
        }
        $this->restError('无内容',204);
    }

    /**
     * creatToken 生成TOKEN
     * @param  array &$user  用户信息数组
     * @return string        TOKEN
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    protected function creatToken(&$user){
        if (is_array($user)) {
            $data['user_id'] = $user['id'];
            $data['token']   = think_ucenter_md5($user['id'].C('DATA_AUTH_KEY').time());
            $data['last_ip'] = $user['last_ip'];
            $data['device_id'] = $user['device_id'];

            //将TOKEN缓存
            S('api_token_'.$data['token'], $data, C('TOKEN_VALID'));

            return $data['token'];

        }
        $this->restError("生成TOKEN失败");
    }

}
