<?php
namespace Api\Controller;

/**
 * 登录后基础继承类
 */
class CommonController extends BaseController
{
	/**
     * 登录状态初始化
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    protected function _initialize() {

        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置
        
    	//判断TOKEN
    	$token = I('token');

    	if (empty($token)) {
    		//返回登录页
    		$this->restError('未授权',401);
    	}

    	//验证TOKEN
    	$cache = $this->checkToken($token);
    	if ($cache == -1) {
    		$this->restError('拒绝请求',403);
    	}elseif ($cache == 0) {
    		$this->restError('TOKEN失效',301);
    	}

        //定义当前用户ID
        if (!defined('UID')) {
            define('UID', $cache);
        }
    }

    /**
     * checkToken 验证TOKEN
     * @param  string $token 客户端TOKEN
     * @return integer (0为失效，1为通过，-1为失败)
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    protected function checkToken($token){
    	$cache = S('api_token_'.$token);
    	if (!empty($cache)) {
    		return $cache['token'] == $cache['token'] ? $cache['user_id'] : -1;
    	}
    	return 0;
    }

    

}
