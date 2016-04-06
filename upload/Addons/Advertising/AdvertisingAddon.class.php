<?php

namespace Addons\Advertising;
use Common\Controller\Addon;
use Think\Db;
/**
 * 广告插件
 * @author quick
 */

    class AdvertisingAddon extends Addon{

        public $info = array(
            'name'=>'Advertising',
            'title'=>'广告位置',
            'description'=>'广告位插件',
            'status'=>1,
            'author'=>'onep2p',
            'version'=>'0.1'
        );
        
        public $addon_path = './Addons/Advertising/';
        
        /**
         * 配置列表页面
         * @var unknown_type
         */
        public $admin_list = array(
        		'listKey' => array(
        				'title'=>'广告位名称',
        				'typetext'=>'广告位类型',
        				'width'=>'广告位宽度',
        				'height'=>'广告位高度',
        				'statustext'=>'位置状态',
        		),
        		'model'=>'Advertising',
        		'order'=>'id asc'
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
CREATE TABLE IF NOT EXISTS `{$this->table_name()}advertising` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '广告位置名称',
  `type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '广告位置展示方式  0为默认展示一张',
  `width` char(20) NOT NULL DEFAULT '' COMMENT '广告位置宽度',
  `height` char(20) NOT NULL DEFAULT '' COMMENT '广告位置高度',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态（0：禁用，1：正常）',
  `pos` varchar(50) NOT NULL,
  `style` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告位置表' ;
SQL;
            D()->execute($sql);

            $sql_insert=<<<SQL
            INSERT INTO `{$this->table_name()}advertising` (`id`, `title`, `type`, `width`, `height`, `status`, `pos`) VALUES
(1, '微博发布框下方', 2, '620', '87', 1, 'weibo_below_sendbox'),
(2, '微博首页签到排行下方', 4, '', '', 1, 'weibo_below_checkrank'),
(3, '首页1号广告位', 1, '756', '100', 1, 'home_ad1');
SQL;
            D()->execute($sql_insert);

           /* if(count(M()->query("SHOW TABLES LIKE '".$this->table_name()."Advertising'")) != 1){
                session('addons_install_error', ',AdvsType表未创建成功，请手动检查插件中的sql，修复后重新安装');
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
            $sql = "DROP TABLE IF EXISTS `".$this->table_name()."Advertising`;";
            D()->execute($sql);
            return true;
        }   

        //实现的广告钩子
        public function AdminIndex($param){
        	
        }        
}