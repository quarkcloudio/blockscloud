<?php

namespace Addons\SyncLogin;

use Common\Controller\Addon;
use Weibo\Api\WeiboApi;

/**
 * 同步登陆插件
 * @author 嘉兴想天信息科技有限公司
 */
class SyncLoginAddon extends Addon
{

    public $info = array(
        'name' => 'SyncLogin',
        'title' => '同步登陆',
        'description' => '同步登陆',
        'status' => 1,
        'author' => 'xjw129xjt',
        'version' => '0.1'
    );

    public function install()
    {
        $prefix = C("DB_PREFIX");
        $model = D();
        $model->execute("DROP TABLE IF EXISTS {$prefix}sync_login;");
        $model->execute("
        CREATE TABLE IF NOT EXISTS `{$prefix}sync_login` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type_uid` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `oauth_token` varchar(255) NOT NULL,
  `oauth_token_secret` varchar(255) NOT NULL,
  `is_sync` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
");

        return true;
    }

    public function uninstall()
    {
        //$prefix = C("DB_PREFIX");
        //D('')->execute("DROP TABLE IF EXISTS {$prefix}sync_login;");
        return true;
    }

    //登录按钮钩子
    public function syncLogin($param)
    {
        $this->assign($param);
        $config = $this->getConfig();
        $this->assign('config', $config);
        $this->display('login');
    }

    /**
     * meta代码钩子
     * @param $param
     * autor:xjw129xjt
     */
    public function syncMeta($param)
    {
        $platform_options = $this->getConfig();

        echo $platform_options['meta'];
    }

    public function AdminIndex($param)
    {
        $config = $this->getConfig();
        $this->assign('addons_config', $config);
        if ($config['display'])
            $this->display('widget');
    }

    public function userConfig($param)
    {

        $this->assign($param);
        $config = $this->getConfig();
        $this->assign('config', $config);


        $arr = array();
        foreach ($config['type'] as &$v) {
            $arr[$v]['name'] = strtolower($v);
            $arr[$v]['is_bind'] = $this->check_is_bind_account(is_login(), strtolower($v));
            if ($arr[$v]['is_bind']) {
                $token = D('sync_login')->where(array('type' => strtolower($v), 'uid' => is_login()))->find();
                $user_info = D('Addons://SyncLogin/Info')->$arr[$v]['name'](array('access_token' => $token['oauth_token'], 'openid' => $token['oauth_token_secret']));
                $arr[$v]['info'] = $user_info;
            }
        }
        unset($v);

        $this->assign('list', $arr);

        $this->assign('addon_config', $config);
        $this->assign('tabHash', 'bind');


        $this->display('syncbind');


    }

    protected function check_is_bind_account($uid = 0, $type = '')
    {
        $check = D('sync_login')->where(array('uid' => $uid, 'type' => $type))->find();
        if ($check) {
            return true;
        }
        return false;
    }
}