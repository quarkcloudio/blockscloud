<?php
namespace Addons\SuperLinks;

use Common\Controller\Addon;
use Think\Db;

/**
 * 合作单位插件
 * @author 苏南
 */
class SuperLinksAddon extends Addon
{
    public $info = array(
        'name' => 'SuperLinks',
        'title' => '合作单位',
        'description' => '合作单位',
        'status' => 1,
        'author' => '苏南 newsn.net',
        'version' => '0.1'
    );
    public $addon_path = './Addons/SuperLinks/';
    public $admin_list = array(
        'listKey' => array(
            'title' => '站点名称',
            'typetext' => '类型',
            'statustext' => '显示状态',
            'level' => '优先级',
            'create_time' => '开始时间',
        ),
        'model' => 'SuperLinks',
        'order' => 'level desc,id asc'
    );
    public $custom_adminlist = 'adminlist.html';

    public function install()
    {
        $db_config = array();
        $db_config['DB_TYPE'] = C('DB_TYPE');
        $db_config['DB_HOST'] = C('DB_HOST');
        $db_config['DB_NAME'] = C('DB_NAME');
        $db_config['DB_USER'] = C('DB_USER');
        $db_config['DB_PWD'] = C('DB_PWD');
        $db_config['DB_PORT'] = C('DB_PORT');
        $db_config['DB_PREFIX'] = C('DB_PREFIX');
        $db = Db::getInstance($db_config);
        //读取插件sql文件
        $sqldata = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . '/Addons/' . $this->info['name'] . '/install.sql');
        $sqlFormat = $this->sql_split($sqldata, $db_config['DB_PREFIX']);

        $counts = count($sqlFormat);
        for ($i = 0; $i < $counts; $i++) {
            $sql = trim($sqlFormat[$i]);
            if (strstr($sql, 'CREATE TABLE')) {
                preg_match('/CREATE TABLE `([^ ]*)`/', $sql, $matches);
                mysql_query("DROP TABLE IF EXISTS `$matches[1]");
                $db->execute($sql);
            }
        }
        return true;
    }

    public function uninstall()
    {
        $db_config = array();
        $db_config['DB_TYPE'] = C('DB_TYPE');
        $db_config['DB_HOST'] = C('DB_HOST');
        $db_config['DB_NAME'] = C('DB_NAME');
        $db_config['DB_USER'] = C('DB_USER');
        $db_config['DB_PWD'] = C('DB_PWD');
        $db_config['DB_PORT'] = C('DB_PORT');
        $db_config['DB_PREFIX'] = C('DB_PREFIX');
        $db = Db::getInstance($db_config);
        //读取插件sql文件
        $sqldata = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . '/Addons/' . $this->info['name'] . '/uninstall.sql');
        $sqlFormat = $this->sql_split($sqldata, $db_config['DB_PREFIX']);
        $counts = count($sqlFormat);

        for ($i = 0; $i < $counts; $i++) {
            $sql = trim($sqlFormat[$i]);
            $db->execute($sql); //执行语句
        }
        return true;
    }

    public function pageFooter()
    {

    }

    //实现的pageFooter钩子方法
    public function friendLink($param)
    {

        $list = D('Addons://SuperLinks/SuperLinks')->linkList();
        $this->assign('list', $list);
        $this->assign('link', $param);
        $this->display('widget');

    }

    /**
     * 解析数据库语句函数
     * @param string $sql sql语句   带默认前缀的
     * @param string $tablepre 自己的前缀
     * @return multitype:string 返回最终需要的sql语句
     */
    public function sql_split($sql, $tablepre)
    {

        if ($tablepre != "onethink_")
            $sql = str_replace("onethink_", $tablepre, $sql);
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