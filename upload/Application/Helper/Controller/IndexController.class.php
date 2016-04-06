<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace Helper\Controller;
require_once APP_PATH . 'User/Conf/config.php';
use Think\Controller;
use Think\Db;
use OT\Database;
/**
 * 助手控制器
 */
class IndexController extends Controller {

    //首页
    public function index(){

        $is_login = session('helper');
        if(empty($is_login)){
            $this->redirect('Index/login');
        }else{
            $this->display();
        }

    }


    //登录
    public function login(){
        if (IS_POST) {
            $password = I('post.password');
            $get_config = './Application/Helper/Conf/config.php';
            if (is_file($get_config)) {
                $get_config_info = require($get_config);
                if (!empty($password) && $get_config_info['HELPER_PASSWORD']==$password) {
                    session('helper','is_login');
                    $this->redirect('Index/index');
                }else{
                    $this->error('密码错误');
                }
                
            }else{
                $this->error('无法登录！');
            }
        }else{
            $this->display();
        }
    }

    //退出
    public function logout(){
        session('helper',null);
        $this->success('退出成功！');
    }


    public function exe()
    {
        //判断是否登录
        $is_login = session('helper');
        if(empty($is_login)){
            $this->redirect('Index/login');
        }

        //获取命令
        $cmd = I('post.cmd');
        if (empty($cmd)) {
            $this->error('命令不可为空！');
        }
        //按行分割命令
        $cmdlist = explode("\n",trim($cmd));
        foreach ($cmdlist as $key => $value) {
            //遍历行命令
            $cmd_exe_list = $this->parseCmdLine($value);
            switch ($cmd_exe_list[0]) {
                //修改网站基本配置
                case 'setWS':
                    $this->setWS($cmd_exe_list);
                    break;
                //备份数据库
                case 'backupDB':
                    $this->backupDB($cmd_exe_list);
                    break;
                //还原数据库
                case 'restoreDB':
                    $this->restoreDB($cmd_exe_list);
                    break;
                //创建导航
                case 'createnav':
                    //传按行数组
                    $this->createnav($cmdlist);
                    break;
                //创建分类
                case 'createcate':
                    //传按行数组
                    $this->createcate($cmdlist);
                    break;
                //修改密码
                case 'resetpwd':
                    $this->resetpwd($cmd_exe_list);
                    break;
                //执行sql
                case 'exesql':
                    $this->exesql($cmd_exe_list[1]);
                    break;
                default:
                    $this->error('命令错误！');
                    break;
            }
        }

    }

    //修改网站基本配置
    protected function setWS($cmd_exe_list=''){
        foreach ($cmd_exe_list as $exekey => $exevalue) {
            if ($exekey!=0) {
                //解析 name:username
                $cmd_exevalue_list = explode(":",$exevalue);
                if ($cmd_exevalue_list[0] && $cmd_exevalue_list[1]) {
                    switch ($cmd_exevalue_list[0]) {
                        case 'title':
                            $where['name'] = 'WEB_SITE_TITLE';
                            $data['value'] = $cmd_exevalue_list[1];
                            break;
                        case 'keyword':
                            $where['name'] = 'WEB_SITE_KEYWORD';
                            $data['value'] = $cmd_exevalue_list[1];
                            break;
                        case 'description':
                            $where['name'] = 'WEB_SITE_DESCRIPTION';
                            $data['value'] = $cmd_exevalue_list[1];
                            break;
                        case 'beian':
                            $where['name'] = 'WEB_SITE_ICP';
                            $data['value'] = $cmd_exevalue_list[1];
                            break;
                        default:
                            $this->error('此命令无'.$cmd_exevalue_list[0].'参数！');
                            break;
                    }
                    $result = M('Config')->where($where)->save($data);
                    //清空数组
                    $where = '';
                    $data = '';
                    $cmd_exevalue_list = '';
                }else{
                    $this->error('参数错误！');
                }
            }
        }

        if ($result) {
            $this->success('执行成功！');
        }else{
            $this->error('执行失败！');
        }
    }

    //创建导航
    protected function createnav($cmdlist=''){
        foreach ($cmdlist as $cmd_exe_key => $cmd_exe_value) {

            //舍去第一行数组
            if ($cmd_exe_key!=0) {
                $get_table_count = substr_count($cmd_exe_value,"\t");
                //echo $get_table_count;
                //制表位为0则为根导航
                if ($get_table_count===0) {
                    //分割成title:导航标题和url:导航url两个数组
                    $cmd_exevalue_list = explode(" ",$cmd_exe_value);
                    foreach ($cmd_exevalue_list as $exekey => $exevalue) {
                        $exevalue_list = explode(":",$exevalue);

                        switch ($exevalue_list[0]) {
                            case 'title':
                                $data['title'] = $exevalue_list[1];
                                break;
                            case 'url':
                                $data['url'] = $exevalue_list[1];
                                break;
                            default:
                                $this->error('参数错误！');
                                break;
                        }
                    }
                    $data['pid'] = 0;
                    $data['status'] = 1;
                    $data['update_time'] = $data['create_time'] = time();
                    //写入数据库
                    $result = $last_channel_id = M('Channel')->add($data);
                }
                //制表位为1则为子导航
                if ($get_table_count===1) {
                    //去掉制表位
                    $cmd_exe_value = str_replace("\t","",$cmd_exe_value);
                    //dump($cmd_exe_value);
                    //分割成title:导航标题和url:导航url两个数组
                    $cmd_exevalue_list = explode(" ",$cmd_exe_value);
                    foreach ($cmd_exevalue_list as $exekey => $exevalue) {
                        $exevalue_list = explode(":",$exevalue);
                        switch ($exevalue_list[0]) {
                            case 'title':
                                $data['title'] = $exevalue_list[1];
                                break;
                            case 'url':
                                $data['url'] = $exevalue_list[1];
                                break;
                            default:
                                $this->error('参数错误！');
                                break;
                        }
                    }
                    $data['status'] = 1;
                    $data['pid'] = $last_channel_id;
                    $data['update_time'] = $data['create_time'] = time();
                    //写入数据库
                    $result = $last_channel_id_level1 = M('Channel')->add($data);
                }
                //制表位为2则为子导航
                if ($get_table_count===2) {
                    //去掉制表位
                    $cmd_exe_value = str_replace("\t","",$cmd_exe_value);
                    //dump($cmd_exe_value);
                    //分割成title:导航标题和url:导航url两个数组
                    $cmd_exevalue_list = explode(" ",$cmd_exe_value);
                    foreach ($cmd_exevalue_list as $exekey => $exevalue) {
                        $exevalue_list = explode(":",$exevalue);
                        switch ($exevalue_list[0]) {
                            case 'title':
                                $data['title'] = $exevalue_list[1];
                                break;
                            case 'url':
                                $data['url'] = $exevalue_list[1];
                                break;
                            default:
                                $this->error('参数错误！');
                                break;
                        }
                    }
                    $data['status'] = 1;
                    $data['pid'] = $last_channel_id_level1;
                    $data['update_time'] = $data['create_time'] = time();
                    //写入数据库
                    $result = $last_channel_id_level2 = M('Channel')->add($data);
                }
                //制表位为3则为子导航
                if ($get_table_count===3) {
                    //去掉制表位
                    $cmd_exe_value = str_replace("\t\t\t","",$cmd_exe_value);
                    //分割成title:导航标题和url:导航url两个数组
                    $cmd_exevalue_list = explode(" ",$cmd_exe_value);
                    foreach ($cmd_exevalue_list as $exekey => $exevalue) {
                        $exevalue_list = explode(":",$exevalue);
                        switch ($exevalue_list[0]) {
                            case 'title':
                                $data['title'] = $exevalue_list[1];
                                break;
                            case 'url':
                                $data['url'] = $exevalue_list[1];
                                break;
                            default:
                                $this->error('参数错误！');
                                break;
                        }
                    }
                    $data['status'] = 1;
                    $data['pid'] = $last_channel_id_level2;
                    $data['update_time'] = $data['create_time'] = time();
                    //写入数据库
                    $result = $last_channel_id_level3 = M('Channel')->add($data);
                }


            }
        }

        if ($result) {
            $this->success('执行成功！');
        }else{
            $this->error('执行失败！');
        }
    }

    //创建分类
    protected function createcate($cmdlist=''){
        foreach ($cmdlist as $cmd_exe_key => $cmd_exe_value) {

            //舍去第一行数组
            if ($cmd_exe_key!=0) {
                $get_table_count = substr_count($cmd_exe_value,"\t");
                //echo $get_table_count;
                //制表位为0则为根导航
                if ($get_table_count===0) {
                    //分割成title:导航标题和url:导航url两个数组
                    $cmd_exevalue_list = explode(" ",$cmd_exe_value);
                    foreach ($cmd_exevalue_list as $exekey => $exevalue) {
                        $exevalue_list = explode(":",$exevalue);

                        switch ($exevalue_list[0]) {
                            case 'title':
                                $data['title'] = $exevalue_list[1];
                                break;
                            case 'name':
                                $data['name'] = $exevalue_list[1];
                                break;
                            case 'ti':
                                $data['template_index'] = $exevalue_list[1];
                                break;
                            case 'tl':
                                $data['template_lists'] = $exevalue_list[1];
                                break;
                            case 'td':
                                $data['template_detail'] = $exevalue_list[1];
                                break;
                            default:
                                $this->error('参数错误！');
                                break;
                        }
                    }
                    $data['pid'] = 0;
                    $data['model'] = '2,3';
                    $data['model_sub'] = '2,3';
                    $data['type'] = '2,1,3';
                    $data['allow_publish'] = 1;
                    $data['display'] = 1;
                    $data['check'] = 0;
                    $data['status'] = 1;

                    $data['update_time'] = $data['create_time'] = time();
                    //写入数据库
                    $result = $last_channel_id = M('Category')->add($data);
                }
                //制表位为1则为子导航
                if ($get_table_count===1) {
                    //去掉制表位
                    $cmd_exe_value = str_replace("\t","",$cmd_exe_value);
                    //dump($cmd_exe_value);
                    //分割成title:导航标题和url:导航url两个数组
                    $cmd_exevalue_list = explode(" ",$cmd_exe_value);
                    foreach ($cmd_exevalue_list as $exekey => $exevalue) {
                        $exevalue_list = explode(":",$exevalue);
                        switch ($exevalue_list[0]) {
                            case 'title':
                                $data['title'] = $exevalue_list[1];
                                break;
                            case 'name':
                                $data['name'] = $exevalue_list[1];
                                break;
                            case 'ti':
                                $data['template_index'] = $exevalue_list[1];
                                break;
                            case 'tl':
                                $data['template_lists'] = $exevalue_list[1];
                                break;
                            case 'td':
                                $data['template_detail'] = $exevalue_list[1];
                                break;
                            default:
                                $this->error('参数错误！');
                                break;
                        }
                    }
                    $data['pid'] = $last_channel_id;
                    $data['model'] = '2,3';
                    $data['model_sub'] = '2,3';
                    $data['type'] = '2,1,3';
                    $data['allow_publish'] = 1;
                    $data['display'] = 1;
                    $data['check'] = 0;
                    $data['status'] = 1;

                    $data['update_time'] = $data['create_time'] = time();
                    //写入数据库
                    $result = $last_channel_id_level1 = M('Category')->add($data);
                }
                //制表位为2则为子导航
                if ($get_table_count===2) {
                    //去掉制表位
                    $cmd_exe_value = str_replace("\t","",$cmd_exe_value);
                    //dump($cmd_exe_value);
                    //分割成title:导航标题和url:导航url两个数组
                    $cmd_exevalue_list = explode(" ",$cmd_exe_value);
                    foreach ($cmd_exevalue_list as $exekey => $exevalue) {
                        $exevalue_list = explode(":",$exevalue);
                        switch ($exevalue_list[0]) {
                            case 'title':
                                $data['title'] = $exevalue_list[1];
                                break;
                            case 'name':
                                $data['name'] = $exevalue_list[1];
                                break;
                            case 'ti':
                                $data['template_index'] = $exevalue_list[1];
                                break;
                            case 'tl':
                                $data['template_lists'] = $exevalue_list[1];
                                break;
                            case 'td':
                                $data['template_detail'] = $exevalue_list[1];
                                break;
                            default:
                                $this->error('参数错误！');
                                break;
                        }
                    }
                    $data['pid'] = $last_channel_id_level1;
                    $data['model'] = '2,3';
                    $data['model_sub'] = '2,3';
                    $data['type'] = '2,1,3';
                    $data['allow_publish'] = 1;
                    $data['display'] = 1;
                    $data['check'] = 0;
                    $data['status'] = 1;

                    $data['update_time'] = $data['create_time'] = time();
                    //写入数据库
                    $result = $last_channel_id_level2 = M('Category')->add($data);
                }
                //制表位为3则为子导航
                if ($get_table_count===3) {
                    //去掉制表位
                    $cmd_exe_value = str_replace("\t\t\t","",$cmd_exe_value);
                    //分割成title:导航标题和url:导航url两个数组
                    $cmd_exevalue_list = explode(" ",$cmd_exe_value);
                    foreach ($cmd_exevalue_list as $exekey => $exevalue) {
                        $exevalue_list = explode(":",$exevalue);
                        switch ($exevalue_list[0]) {
                            case 'title':
                                $data['title'] = $exevalue_list[1];
                                break;
                            case 'name':
                                $data['name'] = $exevalue_list[1];
                                break;
                            case 'ti':
                                $data['template_index'] = $exevalue_list[1];
                                break;
                            case 'tl':
                                $data['template_lists'] = $exevalue_list[1];
                                break;
                            case 'td':
                                $data['template_detail'] = $exevalue_list[1];
                                break;
                            default:
                                $this->error('参数错误！');
                                break;
                        }
                    }
                    $data['pid'] = $last_channel_id_level2;
                    $data['model'] = '2,3';
                    $data['model_sub'] = '2,3';
                    $data['type'] = '2,1,3';
                    $data['allow_publish'] = 1;
                    $data['display'] = 1;
                    $data['check'] = 0;
                    $data['status'] = 1;

                    $data['update_time'] = $data['create_time'] = time();
                    //写入数据库
                    $result = $last_channel_id_level3 = M('Category')->add($data);
                }


            }
        }

        if ($result) {
            $this->success('执行成功！');
        }else{
            $this->error('执行失败！');
        }
    }

    //备份数据库
    protected function backupDB($cmd_exe_list=''){
        foreach ($cmd_exe_list as $exekey => $exevalue) {
            if ($exekey!=0) {
                //解析 name:username
                $cmd_exevalue_list = explode(":",$exevalue);

                if ($cmd_exevalue_list[0] && $cmd_exevalue_list[1]) {
                    switch ($cmd_exevalue_list[0]) {
                        //备份文件名
                        case 'filename':
                            $filename = $cmd_exevalue_list[1];
                            break;
                        //备份路径
                        case 'filepath':
                            $filepath = $cmd_exevalue_list[1];
                            break;
                        //备份完成并下载
                        case 'download':
                            break;
                        //已压缩文件的形式备份
                        case 'zip':
                            break;
                        default:
                            $this->error('此命令无'.$cmd_exevalue_list[0].'参数！');
                            break;
                    }
                    //清空数组
                    $cmd_exevalue_list = '';
                }else{
                    $this->error('参数错误！');
                }
            }
        }

        $this->doBackupDB($filename,$filepath);

        if ($result) {
            $this->success('执行成功！');
        }else{
            $this->error('执行失败！');
        }
    }

    /**
     * 备份数据库
     * @param  String  $tables 表名
     * @param  Integer $id     表ID
     * @param  Integer $start  起始行数
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    protected function doBackupDB($filename='DB',$filepath='./Data/Database',$start = 0){
        if(IS_POST){ //初始化
            $path = $filepath;
            if(!is_dir($path)){
                mkdir($path, 0755, true);
            }
            //读取备份配置
            $config = array(
                'path'     => realpath($path) . DIRECTORY_SEPARATOR,
                'part'     => 20971520,
                'compress' => 1,
                'level'    => 9,
            );

            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";
            if(is_file($lock)){
                $this->error('检测到有一个备份任务正在执行，请稍后再试！');
            } else {
                //创建锁文件
                file_put_contents($lock, NOW_TIME);
            }

            //检查备份目录是否可写
            is_writeable($config['path']) || $this->error('备份目录不存在或不可写，请检查后重试！');

            //生成备份文件信息
            $file = array(
                'name' => $filename,
                'part' => 1,
            );

            //如果存在相同的备份文件，则先删除
            if (is_file($filepath.'/'.$file['name'].'-'.$file['part'].'.sql.gz')) {
                unlink($filepath.'/'.$file['name'].'-'.$file['part'].'.sql.gz');
            }

            //创建备份文件
            $Database = new Database($file, $config);
            if(false == $Database->create()){
                $this->error('初始化失败，备份文件创建失败！');
            }
            //获取所有表
            $tables = M()->query($sql = 'show tables');
            //备份所有表
            foreach ($tables as $key => $value) {
                foreach ($value as $keytablename => $tablename) {
                    $start  = $Database->backup($tablename, $start);
                }
            }
            if(false === $start){ //出错
                $this->error('备份出错！');
            } elseif (0 === $start) {
                unlink($lock);
                $this->success('备份完成！');
            }

        } else { //出错
            $this->error('参数错误！');
        }
    }

    //还原数据库
    protected function restoreDB($cmd_exe_list=''){
        foreach ($cmd_exe_list as $exekey => $exevalue) {
            if ($exekey!=0) {
                //解析 name:username
                $cmd_exevalue_list = explode(":",$exevalue);

                if ($cmd_exevalue_list[0] && $cmd_exevalue_list[1]) {
                    switch ($cmd_exevalue_list[0]) {
                        //文件名
                        case 'filename':
                            $filename = $cmd_exevalue_list[1];
                            break;
                        //路径
                        case 'filepath':
                            $filepath = $cmd_exevalue_list[1];
                            break;
                        //数据库类型
                        case 'dbtype':
                            $dbtype = $cmd_exevalue_list[1];
                            break;
                        //数据库地址
                        case 'dbhost':
                            $dbhost = $cmd_exevalue_list[1];
                            break;
                        //数据库名
                        case 'dbname':
                            $dbname = $cmd_exevalue_list[1];
                            break;
                        //数据库名
                        case 'dbuser':
                            $dbuser = $cmd_exevalue_list[1];
                            break;
                        //数据库密码
                        case 'dbpassword':
                            $dbpassword = $cmd_exevalue_list[1];
                            break;
                        //数据库端口
                        case 'dbport':
                            $dbport = $cmd_exevalue_list[1];
                            break;
                        //数据库端口
                        case 'dbfrefix':
                            $dbfrefix = $cmd_exevalue_list[1];
                            break;
                        default:
                            $this->error('此命令无'.$cmd_exevalue_list[0].'参数！');
                            break;
                    }
                    //清空数组
                    $cmd_exevalue_list = '';
                }else{
                    $this->error('参数错误！');
                }
            }
        }

        $DB = array();
        $DB['DB_TYPE'] = $dbtype;
        $DB['DB_HOST'] = $dbhost;
        $DB['DB_NAME'] = $dbname;
        $DB['DB_USER'] = $dbuser;
        $DB['DB_PWD']  = $dbpassword;
        $DB['DB_PORT'] = $dbport;
        $DB['DB_PREFIX'] = $dbfrefix;
        $result = $this->doRestoreDB($filename,$filepath,$DB);
        $get_config = './Application/Common/Conf/config.php';
        if (is_file($get_config)) {
            $get_config_info = require($get_config);
        }
        $result1 = $this->writeConfig($DB,$get_config_info['DATA_AUTH_KEY']);
        if (0 === $result && $result1) {
            $this->success('执行成功！');
        }else{
            $this->error('执行失败！');
        }
    }

    //执行数据库还原
    protected function doRestoreDB($filename,$filepath,$con,$start = 0)
    {

        $connect = mysqli_connect($con['DB_HOST'].':'.$con['DB_PORT'],$con['DB_USER'],$con['DB_PWD']);
        if ($connect===false) {
            $this->error('数据库连接失败！');
        }

        //释放链接
        mysqli_close($connect);

        //还原数据
        $db = Db::getInstance($con);

        $gz   = gzopen($filepath.'/'.$filename.'-1.sql.gz', 'r');
        $size = 0;

        $sql  = '';
        if($start){
            gzseek($gz, $start);
        }
        
        for($i = 0; $i < 5000; $i++){
            $sql .= gzgets($gz); 
            if(preg_match('/.*;$/', trim($sql))){
                if(false !== $db->execute($sql)){
                    $start += strlen($sql);
                } else {
                    return false;
                }
                $sql = '';
            } elseif (gzeof($gz)) {
                return 0;
            }
        }
        return array($start, $size);
    }

    /**
     * 写入配置文件
     * @param  array $config 配置信息
     */
    protected function writeConfig($config, $auth){
        if(is_array($config)){
            //读取配置内容
            $conf = file_get_contents('./Application/Install/Data/conf.tpl');
            $user = file_get_contents('./Application/Install/Data/user.tpl');
            //替换配置项
            foreach ($config as $name => $value) {
                $conf = str_replace("[{$name}]", $value, $conf);
                $user = str_replace("[{$name}]", $value, $user);
            }

            $conf = str_replace('[AUTH_KEY]', $auth, $conf);
            $user = str_replace('[AUTH_KEY]', $auth, $user);

            //写入应用配置文件
            if(!IS_WRITE){
                $this->error('环境不可写！');
            }else{
                if(file_put_contents(APP_PATH . 'Common/Conf/config.php', $conf) && file_put_contents(APP_PATH . 'User/Conf/config.php', $user)){
                    return 1;
                } else {
                    $this->error('配置文件写入失败');
                }
                return '';
            }

        }
    }


    //修改密码
    protected function resetpwd($cmd_exe_list=''){
        foreach ($cmd_exe_list as $exekey => $exevalue) {
            if ($exekey!=0) {
                //解析 name:username
                $cmd_exevalue_list = explode(":",$exevalue);
                if ($cmd_exevalue_list[0] && $cmd_exevalue_list[1]) {
                    switch ($cmd_exevalue_list[0]) {
                        case 'name':
                            $where['username'] = $cmd_exevalue_list[1];
                            break;
                        case 'password':
                            $data['password'] = think_ucenter_md5($cmd_exevalue_list[1], UC_AUTH_KEY);
                            break;
                        default:
                            $this->error('此命令无'.$cmd_exevalue_list[0].'参数！');
                            break;
                    }
                    //清空数组
                    $cmd_exevalue_list = '';
                }else{
                    $this->error('修改密码参数错误！');
                }
            }
        }
        $result = M('UcenterMember')->where($where)->save($data);
        if ($result) {
            $this->success('执行成功！');
        }else{
            $this->error('执行失败！');
        }
    }

    //解析单行命令类型
    protected function parseCmdLine($cmdLine=''){
        return $cmd_exe_list = explode(" --",$cmdLine);
    }

    //分类转换导航
    public function getCateToNav(){
        $data = M('Category')->where(array('status'=>1))->field('id,title,name,pid')->select();
        $tree = D('Category')->tree($data);
        foreach ($tree as $key => $value) {
            $result .= $value['title'].' url:Article/lists?category='.$value['name']."\n";
        }
        $result = "createnav --data:\n".$result;
        if ($result) {
            $this->success($result);
        }else{
            $this->error('获取数据失败！');
        }
    }

    //执行sql语句
    protected function exesql($sql='')
    {
        if (!empty($sql)) {
            $db = Db::getInstance();
            $result = $db->execute($sql);
            if(false !== $result){
                $this->error('执行成功：'.$result);
            } else {
                $this->error('sql语句错误！');
            }
        }else{
            $this->error('sql语句错误！');
        }
    }

}