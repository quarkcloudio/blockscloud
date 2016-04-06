<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use Think\Controller;

/**
 * 后台应用市场
 * @author tangtnglove <dai_hang_love@126.com>
 */
class AppstoreController extends AdminController {

    /**
     * 读取线上模块列表
     * @author tangtanglove
     */
    public function appOnline(){
        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 读取本地模块列表
     * @author tangtanglove
     */
    public function app(){

        //实例化模型
        $Apps = M('Apps');
        //读取名称
        $get_apps = scandir('./Application');
        //删除.和..;
        unset($get_apps[0]);
        unset($get_apps[1]); 
        foreach ($get_apps as $key => $value) {
            //循环读取主题配置
            $get_apps_file = './Application/'.$value.'/index.php';
            if (is_file($get_apps_file)) {
                $get_apps_info = require($get_apps_file);
                $hasapps = $Apps->where(array('name'=>$get_apps_info['name']))->find();
                //如果数据库中没有记录主题，则插入数据库
                if (empty($hasapps)) {
                    $Apps->add($get_apps_info);
                }
            }
        }
        $map = array();
        if(isset($_GET['title'])){
            $map['title']    =   array('like', '%'.(string)I('title').'%');
        }
        $list = $this->lists('Apps', $map,'id');
        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 安装应用模块
     * @author tangtanglove
     */
    public function setupApp(){
        $id = I('get.id');
        //安装
        $result = M('Apps')->where(array('id'=>$id))->save(array('is_setup'=>1));
        if ($result) {

            //运行sql文件
            $AppsInfo = M('Apps')->where(array('id'=>$id))->find();
            $get_apps_sqlfile = './Application/'.$AppsInfo['name'].'/Data/data.sql';
            if (is_file($get_apps_sqlfile)) {
                $this->exeSqlfile($get_apps_sqlfile);
            }

            //获取后台管理文件 TODO 先用这种本方法解决
            $get_admincontroller = './Application/'.$AppsInfo['name'].'/Controller/Admin'.$AppsInfo['name'].'Controller.class.php';
            if (is_file($get_admincontroller)) {
                $destination_url = './Application/Admin/Controller/Admin'.$AppsInfo['name'].'Controller.class.php';
                //把模块管理文件复制到后台模块中
                copy($get_admincontroller, $destination_url);
            }
            
            //动态返回ajax数据
            $data['info'] = '安装成功';
            $data['shortcut_name'] = $AppsInfo['shortcut_name'];
            $data['shortcut_img_url'] = $AppsInfo['shortcut_img_url'];
            //构建json数据
            $data_app['name'] = $AppsInfo['shortcut_name'].'.oexe';
            $data_app['ext'] = 'oexe';
            $data_app['type'] = 'url';
            //如果包含.php字符串，就不使用U函数生成url
            if (strstr($AppsInfo['shortcut_url'],".php")) {
                $data_app['content'] = $AppsInfo['shortcut_url'];
            }else{
                $data_app['content'] = U($AppsInfo['shortcut_url']);
            }
            $data_app['icon']    = $AppsInfo['shortcut_img_url'];
            $data_app['width']   = "1100";
            $data_app['height']  = "600";
            $data_app['simple']  = 0;
            $data_app['resize']  = 1;
            //生成json
            $data['data_app'] = urlencode(json_encode($data_app));
            $data['status'] = 1;

            $file_path = './Data/Cloud/user/'.get_username(is_login()).'/home/desktop/'.$data_app['name'];
            //检查系统
            if (strtoupper(substr(PHP_OS, 0,3)) !== 'WIN') {
                $file_name = iconv('gbk', 'utf-8',$file_path);
            }else{
                $file_name = iconv('utf-8','gbk',$file_path);
            }
            //生成真实的快捷方式文件
            $create_oexe_file = fopen($file_name, "w");
            if (!$create_oexe_file) {
                $this->error('无权限写入！');
            }
            fwrite($create_oexe_file, json_encode($data_app));
            fclose($create_oexe_file);
            $this->success($data);

        }else{
            $this->error('操作失败！');
        }
    }

    /**
     * 卸载应用模块
     * @author tangtanglove
     */
    public function uninstallApp()
    {
        $id = I('get.id');
        //卸载
        $result = M('Apps')->where(array('id'=>$id))->save(array('is_setup'=>0));
        if ($result) {

            //运行sql文件
            $AppsInfo = M('Apps')->where(array('id'=>$id))->find();
            $get_apps_sqlfile = './Application/'.$AppsInfo['name'].'/Data/clean.sql';
            if (is_file($get_apps_sqlfile)) {
                $this->exeSqlfile($get_apps_sqlfile);
            }

            //获取后台管理文件 TODO 先用这种本方法解决
            $get_admincontroller = './Application/Admin/Controller/Admin'.$AppsInfo['name'].'Controller.class.php';
            if (is_file($get_admincontroller)) {
                //清除文件
                unlink($get_admincontroller);
            }

            //删除快捷方式
            $file_path = './Data/Cloud/user/'.get_username(is_login()).'/home/desktop/'.$AppsInfo['shortcut_name'].'.oexe';
            
            //检查系统
            if (strtoupper(substr(PHP_OS, 0,3)) !== 'WIN') {
                $file_name = iconv('gbk', 'utf-8',$file_path);
            }else{
                $file_name = iconv('utf-8','gbk',$file_path);
            }

            //删除
            unlink($file_name);

            $this->success('操作成功！');
        }else{
            $this->error('操作失败！');
        }
    }

    /**
     * 读取线上主题列表
     * @author tangtanglove
     */
    public function themeOnline(){

        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 读取本地主题列表
     * @author tangtanglove
     */
    public function theme(){

        //实例化模型
        $Theme = M('Theme');
        //读取主题名称
        $get_themes = scandir('./Theme');
        //删除'.','..';
        unset($get_themes[0]);
        unset($get_themes[1]); 
        foreach ($get_themes as $key => $value) {
            //循环读取主题配置
            $get_themes_file = './Theme/'.$value.'/index.php';
            if (is_file($get_themes_file)) {
                $get_themes_info = require($get_themes_file);
                $hastheme = $Theme->where(array('name'=>$get_themes_info['name']))->find();
                //如果数据库中没有记录主题，则插入数据库
                if (empty($hastheme)) {
                    $Theme->add($get_themes_info);
                }
            }
        }
        $map = array();
        if(isset($_GET['title'])){
            $map['title']    =   array('like', '%'.(string)I('title').'%');
        }
        $list = $this->lists('Theme', $map,'id');
        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 安装主题
     * @author tangtanglove
     */
    public function setupTheme(){
        $id = I('get.id');
        //重置主题安装状态
        M('Theme')->where(array('is_setup'=>1))->save(array('is_setup'=>0));
        //安装主题
        $result = M('Theme')->where(array('id'=>$id))->save(array('is_setup'=>1));
        if ($result) {
            //运行sql文件
            $name = M('Theme')->where(array('id'=>$id))->getField('name');
            $get_themes_sqlfile = './Theme/'.$name.'/Data/data.sql';
            if (is_file($get_themes_sqlfile)) {
                $this->exeSqlfile($get_themes_sqlfile);
            }
            $this->success('操作成功！');
        }else{
            $this->error('操作失败！');
        }
    }

    /**
     * 默认主题（启用默认主题后将启用thinkphp默认路径的view）
     * @author tangtanglove
     */
    public function defaultTheme(){
        //安装主题
        $result = M('Theme')->where(array('is_setup'=>1))->save(array('is_setup'=>0));
        if ($result) {
            $this->success('操作成功！');
        }else{
            $this->error('操作失败！');
        }
    }

    /**
     * 读取线上插件列表
     * @author tangtanglove
     */
    public function addonsOnline(){

        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 读取本地插件列表
     * @author tangtanglove
     */
    public function addons(){
        $this->meta_title = '插件列表';
        $list       =   D('Addons')->getList();
        $request    =   (array)I('request.');
        $total      =   $list? count($list) : 1 ;
        $listRows   =   C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        $page       =   new \Think\Page($total, $listRows, $request);
        $voList     =   array_slice($list, $page->firstRow, $page->listRows);
        $p          =   $page->show();
        $this->assign('_page', $p? $p: '');
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->assign('list',$voList);
        $this->display();
    }

    /**
     * 执行sql文件
     * @author tangtanglove
     */
    protected function exeSqlfile($file)
    {
        $Model = new \Think\Model();
        //读取SQL文件
        $sql = file_get_contents($file);
        $sql = str_replace("\r", "\n", $sql);
        $sql = explode(";\n", $sql);

        //开始安装
        foreach ($sql as $value) {
            $value = trim($value);
            if(empty($value)) continue;
            if(substr($value, 0, 12) == 'CREATE TABLE') {
                $name = preg_replace("/^CREATE TABLE `(\w+)` .*/s", "\\1", $value);
                $Model->execute($value);
            } else {
                $Model->execute($value);
            }

        }
    }

    /**
     * 上传我的应用
     * @author tangtanglove
     */
    public function appUpload()
    {
        $this->error('尚未开放！');
    }

} 