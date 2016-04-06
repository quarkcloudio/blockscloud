<?php

namespace Addons\Advs;
use Common\Controller\Addon;
use Think\Db;
/**
 * 广告插件
 * @author quick
 */

    class AdvsAddon extends Addon{

        public $info = array(
            'name'=>'Advs',
            'title'=>'广告管理',
            'description'=>'广告插件',
            'status'=>1,
            'author'=>'onep2p',
            'version'=>'0.1'
        );
        
        public $addon_path = './Addons/Advs/';
        
        /**
         * 配置列表页面
         * @var unknown_type
         */
        public $admin_list = array(
        		'listKey' => array(
        				'title'=>'广告名称',
        				'positiontext'=>'广告位置',
        				'link'=>'连接地址',
        				'statustext'=>'显示状态',
        				'level'=>'优先级',
        				'create_time'=>'开始时间',
        				'end_time'=>'结束时间',
        		),
        		'model'=>'Advs',
        		'order'=>'position desc,level desc,id desc'
        );
        public $custom_adminlist = 'adminlist.html';
 
        /**
         * (non-PHPdoc)
         * 安装函数
         * @see \Common\Controller\Addons::install()
         */
		public function table_name(){
			$db_prefix = C('DB_PREFIX');
			return $db_prefix;
		}
		
		
        public function install(){
            $sql=<<<SQL
CREATE TABLE IF NOT EXISTS `{$this->table_name()}advs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '广告名称',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '广告位置描述',
  `position` int(11) NOT NULL COMMENT '广告位置',
  `advspic` int(11) NOT NULL COMMENT '图片地址',
  `advstext` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '文字广告内容',
  `advshtml` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '代码广告内容',
  `link` char(140) NOT NULL DEFAULT '' COMMENT '链接地址',
  `level` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '优先级',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态（0：禁用，1：正常）',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告表';
SQL;
            D()->execute($sql);
           /* if(count(M()->query("SHOW TABLES LIKE '".$this->table_name()."Advs'")) != 1){
            	session('addons_install_error', ',Advs表未创建成功，请手动检查插件中的sql，修复后重新安装');
            	return false;
            }*/
            return true;
        }

        /**
         * (non-PHPdoc)
         * 卸载函数
         * @see \Common\Controller\Addons::uninstall()
         */
        public function uninstall(){
			$db_prefix = C('DB_PREFIX');
            $sql = "DROP TABLE IF EXISTS `".$this->table_name()."Advs`;";
            D()->execute($sql);
            return true;
        }      
        
        //实现的广告钩子
        public function Advs($param){
        	$list = D('Addons://Advs/Advs')->AdvsList($param);
        	if(!$list)
        		return ;
			$this->assign('list',$list);
			$this->display('widget');
        }              
}