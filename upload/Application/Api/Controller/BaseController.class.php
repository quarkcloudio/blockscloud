<?php
namespace Api\Controller;
use Think\Controller\RestController;

/**
 * 基础继承类
 */
class BaseController extends RestController
{

    protected function _initialize(){
        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置

        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }
    }

    /* REST允许的请求类型列表 */
    protected $allowMethod = array('get', 'post', 'put', 'delete');

    /* REST允许请求的资源类型列表 */
    protected $allowType      = array('html'); 

    /* REST允许输出的资源类型列表 */
    protected $allowOutputType = array('json' => 'application/json','html' => 'text/html');

    /**
     * 操作错误返回的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param integer $status 错误状态值
     * @return void
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    protected function restError($message = '', $status = 300) {
        $return['info']   =   $message;
        $return['status'] =   $status;
        $this->response($return,'json');
        die();
    }

    /**
     * 操作成功跳返回的快捷方法
     * @access protected
     * @param string $message 成功信息
     * @return void
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    protected function restSuccess($message = '') {
        $return['info']   =   $message;
        $return['status'] =   200;
        $this->response($return,'json');
    }

    /**
     * checkLogin 非继承Common的类运用此方法判断登录
     * @param string $token TOKEN
     * @return integer 登录用户ID
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    protected function checkLogin($token){

        //判断TOKEN
        if (empty($token)) {
            //返回登录页
            $this->restError('未授权',401);
        }

        $cache = S('api_token_'.$token);
        if (!empty($cache)) {

            if ($cache['token'] == $cache['token']) {
                return $cache['user_id'];
            }

            $this->restError('拒绝请求',403);

        }
        $this->restError('TOKEN失效',301);
    }

}
