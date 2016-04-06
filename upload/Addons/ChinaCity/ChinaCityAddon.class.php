<?php
// +----------------------------------------------------------------------
// | i友街 [ 新生代贵州网购社区 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.iyo9.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: i友街 <iyo9@iyo9.com> <http://www.iyo9.com>
// +----------------------------------------------------------------------
// 
namespace Addons\ChinaCity;
use Common\Controller\Addon;

/**
 * 中国省市区三级联动插件
 * @author i友街
 */

    class ChinaCityAddon extends Addon{

        public $info = array(
            'name'=>'ChinaCity',
            'title'=>'中国省市区三级联动',
            'description'=>'每个系统都需要的一个中国省市区三级联动插件。想天-駿濤修改，将镇级地区移除',
            'status'=>1,
            'author'=>'i友街',
            'version'=>'2.0'
        );

        public function install(){

            /* 先判断插件需要的钩子是否存在 */
            $this->getisHook('J_China_City', $this->info['name'], $this->info['description']);

            //读取插件sql文件
            $sqldata = file_get_contents('http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/Addons/'.$this->info['name'].'/install.sql');
            $sqlFormat = $this->sql_split($sqldata, C('DB_PREFIX'));
            $counts = count($sqlFormat);
            
            for ($i = 0; $i < $counts; $i++) {
                $sql = trim($sqlFormat[$i]);
                D()->execute($sql);
            }
            return true;
        }

        public function uninstall(){
            //读取插件sql文件
            $sqldata = file_get_contents('http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/Addons/'.$this->info['name'].'/uninstall.sql');

            $sqlFormat = $this->sql_split($sqldata, C('DB_PREFIX'));
            $counts = count($sqlFormat);
             
            for ($i = 0; $i < $counts; $i++) {
                $sql = trim($sqlFormat[$i]);
                D()->execute($sql);
            }
            return true;
        }

        //实现的J_China_City钩子方法
        public function J_China_City($param){
            $this->assign('param', $param);
            $this->display('chinacity');
        }

        //获取插件所需的钩子是否存在
        public function getisHook($str, $addons, $msg=''){
            $hook_mod = M('Hooks');
            $where['name'] = $str;
            $gethook = $hook_mod->where($where)->find();
            if(!$gethook || empty($gethook) || !is_array($gethook)){
                $data['name'] = $str;
                $data['description'] = $msg;
                $data['type'] = 1;
                $data['update_time'] = NOW_TIME;
                $data['addons'] = $addons;
                if( false !== $hook_mod->create($data) ){
                    $hook_mod->add();
                }
            }
        }

        /**
         * 解析数据库语句函数
         * @param string $sql  sql语句   带默认前缀的
         * @param string $tablepre  自己的前缀
         * @return multitype:string 返回最终需要的sql语句
         */
        public function sql_split($sql, $tablepre) {

            if ($tablepre != "opensns_")
                $sql = str_replace("opensns_", $tablepre, $sql);
                $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8", $sql);

            if ($r_tablepre != $s_tablepre)
                $sql = str_replace($s_tablepre, $r_tablepre, $sql);
                $sql = str_replace("\r", "\n", $sql);
                $ret = array();

                $num = 0;
                $queriesarray = explode(";\n", trim($sql));
                unset($sql);

            foreach ($queriesarray as $query) {
                $ret[$num] = '';
                $queries = explode("\n", trim($query));
                $queries = array_filter($queries);
                foreach ($queries as $query) {
                    $str1 = substr($query, 0, 1);
                    if ($str1 != '#' && $str1 != '-')
                        $ret[$num] .= $query;
                }
                $num++;
            }
            return $ret;
        }
    }