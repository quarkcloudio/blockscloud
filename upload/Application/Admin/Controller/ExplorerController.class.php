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

class ExplorerController extends AdminController{
    public $path;
    public function __construct(){
        parent::__construct();
        $get_path=I('get.path');

        if (isset($get_path)) {
            $this->path = _DIR($get_path);
        }

    }
    public function index(){
        $get_path=I('get.path');
        if(isset($get_path) && $get_path !=''){
            $dir = _DIR_CLEAR($_GET['path']);
        }else if(isset($_SESSION['this_path'])){
            $dir = _DIR_CLEAR($_SESSION['this_path']);
        }else{
            $dir = '/';//首次进入系统,不带参数
            if ($GLOBALS['is_root']) $dir = WEB_ROOT;
        }
        $dir = rtrim($dir,'/').'/';
        $this->assign('dir',$dir);
        $this->display();
    }

    public function pathInfo(){
        $get_list=I('post.list');
        $info_list = json_decode($get_list,true);
        foreach ($info_list as &$val) {
            $val['path'] = _DIR($val['path']);
        }
        $data = path_info_muti($info_list,'时间类型');
        _DIR_OUT($data['path']);
        show_json($data);
    }

    public function pathChmod(){
        $get_list=I('get.list');
        $get_mod=I('get.mod');
        $info_list = json_decode($get_list,true);
        $mod = octdec('0'.$get_mod);
        $success=0;$error=0;
        foreach ($info_list as $val) {
            $path = _DIR($val['path']);
            if(chmod_path($path,$mod)){
                $success++;
            }else{
                $error++;
            }
        }
        $state = $error==0?true:false;
        $info = $success.' success,'.$error.' error';
        if (count($info_list) == 1 && $error==0) {
            $info = $this->L['success'];
        }
        show_json($info,$state);
    }

    private function _pathAllow($path){
        $name = get_path_this($path);
        $path_not_allow  = array('*','?','"','<','>','|');
        foreach ($path_not_allow as $tip) {
            if (strstr($name,$tip)) {
                show_json("路径不允许"."*,?,<,>,|",false);
            }
        }
    }

    public function pathRname(){
        
        $get_rname_to=I('post.rname_to');
        $get_path=I('post.path');

        if (isset($get_path)) {
            $path = _DIR($get_path);
        }

        if (!is_writable($path)) {
            show_json("无写入权限",false);
        }

        $rname_to=_DIR($get_rname_to);
        $this->_pathAllow($rname_to);

        if (file_exists($rname_to)) {
            show_json("名称已经存在",false);
        }
        rename($path,$rname_to);
        show_json("重命名成功");
    }

    public function pathList(){
        $session=isset($_SESSION['history'])?$_SESSION['history']:false;
        $user_path = I('get.path');
        $type=I('get.type');
        if (is_array($session)){
            $hi = new \Think\History($session);
            if ($user_path==""){
                $user_path=$hi->getFirst();
            }else {
                $hi->add($user_path);
                $_SESSION['history']=$hi->getHistory();
            }
        }else {
            $hi = new \Think\History(array(),20);
            if ($user_path=="")  $user_path='/';
            $hi->add($user_path);
            $_SESSION['history']=$hi->getHistory();
        }

        //回收站不记录前进后退
        if($user_path != '*recycle*/' && $type !=='desktop'){
            $_SESSION['this_path']=$user_path;
        }
        
        $user_path= _DIR($user_path);

        $list=$this->path($user_path);
        $list['history_status']= array('back'=>$hi->isback(),'next'=>$hi->isnext());
        show_json($list);
    }

    public function search(){
        $get_search=I('get.search');
        $get_is_content=I('get.is_content');
        $get_is_case=I('get.is_case');
        $get_ext=I('get.ext');

        if (!isset($get_search)) show_json("请输入搜索信息",false);
        $is_content = false;
        $is_case    = false;
        $ext        = '';
        if (isset($get_is_content)) $is_content = true;
        if (isset($get_is_case)) $is_case = true;
        if (isset($get_ext)) $ext= str_replace(' ','',$get_ext);
        $list = path_search(
            $this->path,
            iconv_system($get_search),
            $is_content,$ext,$is_case);
        _DIR_OUT($list);
        show_json($list);
    }

    public function treeList(){//树结构
        $app = I('get.app');//是否获取文件 传folder|file
        $type= I('get.type');
        $this_path= I('get.this_path');
        $name= I('get.name');
        if (isset($type) && $type=='init'){
            $this->_tree_init($app);
        }
        if (isset($this_path)){
            $path=_DIR($this_path);
        }else{
            $path=_DIR($this_path.$name);
        }
        if (!is_readable($path)) show_json($path,false);
        $list_file = ($app == 'editor'?true:false);//编辑器内列出文件
        $list=$this->path($path,$list_file,true);
        function sort_by_key($a, $b){
            if ($a['name'] == $b['name']) return 0;
            return ($a['name'] > $b['name']) ? 1 : -1;
        }

        usort($list['folderlist'], "sort_by_key");
        usort($list['filelist'], "sort_by_key");
        if ($app == 'editor') {
            $res = array_merge($list['folderlist'],$list['filelist']);
            show_json($res,true);
        }else{
            show_json($list['folderlist'],true);
        }

    }

    private function _tree_init($app){
        $get_project= I('get.project');
        if ($app == 'editor' && isset($get_project)) {
            $list_project = $this->path(_DIR($get_project),true,true);
            $project = array_merge($list_project['folderlist'],$list_project['filelist']);
            $tree_data = array(
                array('name'=> get_path_this($get_project),
                    'children'=>$project,
                    'iconSkin'  => "my",
                    'menuType'  => "menuTreeRoot",
                    'open'      => true,
                    'this_path' => $this->in['project'],
                    'isParent'  => count($project)>0?true:false)
            );
            show_json($tree_data);
            return;
        }

        $check_file = ($app == 'editor'?true:false);
        $list_root  = $this->path(_DIR(USER_DESKTOP),$check_file,true);
        $list_public = $this->path(PUBLIC_PATH,$check_file,true);
        if ($check_file) {//编辑器
            $root = array_merge($list_root['folderlist'],$list_root['filelist']);
            $public = array_merge($list_public['folderlist'],$list_public['filelist']);
        }else{//文件管理器
            $root  = $list_root['folderlist'];
            $public = $list_public['folderlist'];
        }

        $root_isparent = count($root)>0?true:false;
        $public_isparent = count($public)>0?true:false;
        $tree_data = array(
            array('name'=>'我的文件','children'=>$root,'menuType'=>"menuTreeRoot",
                'iconSkin'=>"my",'open'=>true,'this_path'=> USER_DESKTOP,'isParent'=>$root_isparent),
            array('name'=>'公共目录','children'=>$public,'menuType'=>"menuTreeRoot",
                'iconSkin'=>"lib",'open'=>true,'this_path'=> PUBLIC_PATH,'isParent'=>$public_isparent)
        );
        show_json($tree_data);
    }

    public function historyBack(){
        session_start();//re start
        $session=$_SESSION['history'];
        if (is_array($session)){
            $hi = new \Think\History($session);
            $path=$hi->goback();
            $_SESSION['history']=$hi->getHistory();
            $folderlist=$this->path(_DIR($path));
            $_SESSION['this_path']=$path;
            show_json(array(
                'history_status'=>array('back'=>$hi->isback(),'next'=>$hi->isnext()),
                'thispath'=>$path,
                'list'=>$folderlist
            ));
        }
    }

    public function historyNext(){
        session_start();//re start
        $session=$_SESSION['history'];
        if (is_array($session)){
            $hi = new \Think\History($session);
            $path=$hi->gonext();
            $_SESSION['history']=$hi->getHistory();
            $folderlist=$this->path(_DIR($path));
            $_SESSION['this_path']=$path;
            show_json(array(
                'history_status'=>array('back'=>$hi->isback(),'next'=>$hi->isnext()),
                'thispath'=>$path,
                'list'=>$folderlist
            ));
        }
    }

    public function pathDelete(){
        $get_list=I('post.list');
        $list = json_decode($get_list,true);
        if (!is_writable(USER_RECYCLE)) show_json('无权限操作',false);
        $success=0;$error=0;
        foreach ($list as $val) {
            $path_this = _DIR($val['path']);
            $filename  = get_path_this($path_this);
            $filename = get_filename_auto(USER_RECYCLE.$filename,date(' h.i.s'));//已存在处理 创建副本
            if (@rename($path_this,$filename)) {
                $success++;
            }else{
                $error++;
            }
        }
        $state = $error==0?true:false;
        $info = $success.' success,'.$error.' error';
        if (count($info_list) == 1 && $error==0) {
            $info = '删除成功';
        }
        show_json($info,$state);
    }

    public function pathDeleteRecycle(){
        $get_list=I('post.list');
        if(empty($get_list)){
            $recycle=USER_RECYCLE;
            if (!del_dir($recycle)) {
                show_json('删除失败',false);
            }else{
                mkdir($recycle);
                show_json('清空回收站成功',true);
            }
            return;
        }
        $list = json_decode($get_list,true);
        $success = 0;
        $error   = 0;
        foreach ($list as $val) {
            $path_full = _DIR($val['path']);
            if ($val['type'] == 'folder') {
                if(del_dir($path_full)) $success ++;
                else $error++;
            }else{
                if(del_file($path_full)) $success++;
                else $error++;
            }
        }
        if (count($list) == 1) {
            if ($success) show_json('清除成功');
            else show_json($this->L['remove_fali'],false);
        }else{
            $code = $error==0?true:false;
            show_json('清除成功'.$success.'success,'.$error.'error',$code);
        }
    }

    public function mkfile(){
        $get_content=I('get.content');
        $new= rtrim($this->path,'/');
        $this->_pathAllow($new);
        if(touch($new)){
            if (isset($get_content)) {
                file_put_contents($new,$get_content);
            }
            show_json('创建成功',true,get_path_this($new));
        }else{
            show_json('创建失败',false);
        }
    }

    public function mkdir(){
        $new = rtrim($this->path,'/');
        $this->_pathAllow($new);
        if(mkdir($new,0777)){
            show_json('创建成功');
        }else{
            show_json('创建失败',false);
        }
    }
    public function pathCopy(){
        $get_list=I('post.list');
        session_start();//re start
        $copy_list = json_decode($get_list,true);
        $list_num = count($copy_list);
        for ($i=0; $i < $list_num; $i++) {
            $copy_list[$i]['path'] =$copy_list[$i]['path'];
        }
        $_SESSION['path_copy']= json_encode($copy_list);
        $_SESSION['path_copy_type']='copy';
        show_json('操作成功');
    }
    public function pathCute(){
        $get_list=I('post.list');
        session_start();//re start
        $cute_list = json_decode($get_list,true);
        $list_num = count($cute_list);
        for ($i=0; $i < $list_num; $i++) {
            $cute_list[$i]['path'] = $cute_list[$i]['path'];
        }
        $_SESSION['path_copy']= json_encode($cute_list);
        $_SESSION['path_copy_type']='cute';
        show_json('操作成功');
    }
    public function pathCuteDrag(){
        $get_list=I('get.list');
        $clipboard = json_decode($get_list,true);
        $path_past=$this->path;
        if (!is_writable($this->path)) show_json("无权限写入",false);
        $success=0;$error=0;
        foreach ($clipboard as $val) {
            $path_copy = _DIR($val['path']);
            $filename  = get_path_this($path_copy);
            $filename = get_filename_auto($path_past.$filename);//已存在处理 创建副本
            if (@rename($path_copy,$filename)) {
                $success++;
            }else{
                $error++;
            }
        }
        $state = $error==0?true:false;
        $info = $success.' success,'.$error.' error';
        if (count($info_list) == 1 && $error==0) {
            $info = $this->L['success'];
        }
        show_json($info,$state);
    }

    public function pathCopyDrag(){
        $get_list=I('get.list');
        $clipboard = json_decode($get_list,true);
        $path_past=$this->path;
        $data = array();
        if (!is_writable($this->path)) show_json('无权限操作',false);
        foreach ($clipboard as $val) {
            $path_copy = _DIR($val['path']);
            $filename = get_path_this($path_copy);
            $path = get_filename_auto($path_past.$filename);
            copy_dir($path_copy,$path);
            $data[] = iconv_app(get_path_this($path));
        }
        show_json($data,true);
    }

    public function clipboard(){
        $clipboard = json_decode($_SESSION['path_copy'],true);
        $msg = '';
        if (count($clipboard) == 0){
            $msg = '<div style="padding:20px;">null!</div>';
        }else{
            $msg='<div style="height:200px;overflow:auto;padding:10px;width:400px"><b>剪切板'.($_SESSION['path_copy_type']=='cute'?'剪切':'复制').'</b><br/>';
            $len = 40;
            foreach ($clipboard as $val) {
                $val['path'] = rawurldecode($val['path']);
                $path=(strlen($val['path'])<$len)?$val['path']:'...'.substr($val['path'],-$len);
                $msg.= '<br/>'.$val['type'].' :  '.$path;
            }
            $msg.="</div>";
        }
        show_json($msg);
    }
    public function pathPast(){
        if (!isset($_SESSION['path_copy'])){
            show_json('剪切板为空',false,$data);
        }

        session_start();//re start
        $error = '';$data = array();
        $clipboard = json_decode($_SESSION['path_copy'],true);
        $copy_type = $_SESSION['path_copy_type'];
        $path_past=$this->path;
        if (!is_writable($path_past)) show_json('无写入权限',false,$data);

        $list_num = count($clipboard);
        if ($list_num == 0) {
            show_json("剪切板为空",false,$data);
        }
        for ($i=0; $i < $list_num; $i++) {
            $path_copy = _DIR($clipboard[$i]['path']);
            $filename  = get_path_this($path_copy);
            $filename_out  = iconv_app($filename);

            if (!file_exists($path_copy) && !is_dir($path_copy)){
                $error .=$path_copy."<li>{$filename_out}文件不存在</li>";
                continue;
            }
            if ($clipboard[$i]['type'] == 'folder'){
                if ($path_copy == substr($path_past,0,strlen($path_copy))){
                    $error .="<li style='color:#f33;'>{$filename_out}'.$this->L['current_has_parent'].'</li>";
                    continue;
                }
            }

            $auto_path = get_filename_auto($path_past.$filename);
            $filename = get_path_this($auto_path);
            if ($copy_type == 'copy') {
                if ($clipboard[$i]['type'] == 'folder') {
                    copy_dir($path_copy,$auto_path);
                }else{
                    copy($path_copy,$auto_path);
                }
            }else{
                rename($path_copy,$auto_path);
            }
            $data[] = iconv_app($filename);
        }
        if ($copy_type == 'copy') {
            $msg="<b>粘贴操作完成</b>".$error;
        }else{
            $_SESSION['path_copy'] = json_encode(array());
            $_SESSION['path_copy_type'] = '';
            $msg="<b>剪切操作完成</b>(源文件被删除,剪贴板清空)".$error;
        }
        $state = ($error ==''?true:false);
        show_json($msg,$state,$data);
    }
    public function fileDownload(){
        file_put_out($this->path,true);
    }
    //文件下载后删除,用于文件夹下载
    public function fileDownloadRemove(){
        $get_path=I('get.path');
        $path = rawurldecode(_DIR_CLEAR($get_path));
        $path = USER_TEMP.iconv_system($path);
        file_put_out($path,true);
        del_file($path);
    }
    public function zipDownload(){
        if(!file_exists(USER_TEMP)){
            mkdir(USER_TEMP);
        }else{//清除未删除的临时文件，一天前
            $list = path_list(USER_TEMP,true,false);
            $max_time = 3600*24;
            if ($list['filelist']>=1) {
                for ($i=0; $i < count($list['filelist']); $i++) {
                    $create_time = $list['filelist'][$i]['mtime'];//最后修改时间
                    if(time() - $create_time >$max_time){
                        del_file($list['filelist'][$i]['path'].$list['filelist'][$i]['name']);
                    }
                }
            }
        }
        $zip_file = $this->zip(USER_TEMP);
        show_json("压缩完成",true,get_path_this($zip_file));
    }
    public function zip($zip_path=null){
        $get_list=I('post.list');
        import('OT/PclZip');
        ini_set('memory_limit', '2028M');//2G;
        $zip_list = json_decode($get_list,true);
        $list_num = count($zip_list);
        for ($i=0; $i < $list_num; $i++) {
            $zip_list[$i]['path'] = rtrim(_DIR($zip_list[$i]['path']),'/');
        }
        //指定目录
        $basic_path = $zip_path;
        if (!isset($zip_path)){
            $basic_path =get_path_father($zip_list[0]['path']);
        }
        if ($list_num == 1){
            $path_this_name=get_path_this($zip_list[0]['path']);
        }else{
            $path_this_name=get_path_this(get_path_father($basic_path));
        }
        $zipname = $basic_path.$path_this_name.'.zip';
        $zipname = get_filename_auto($zipname);
        if (!is_writeable($basic_path)) {
            show_json("无权限写入",false);
        }else{
            $files = array();
            for ($i=0; $i < $list_num; $i++) {
                $files[] = $zip_list[$i]['path'];
            }
            $remove_path_pre = _DIR_CLEAR(get_path_father($zip_list[0]['path']));
            $archive = new \PclZip($zipname);
            $v_list = $archive->create(implode(',',$files),PCLZIP_OPT_REMOVE_PATH,$remove_path_pre);
            if ($v_list == 0) {
                show_json("Error:".$archive->errorInfo(true),false);
            }
            $info = "压缩完成".$this->L['size'].":".size_format(filesize($zipname));
            if (!isset($zip_path)) {
                show_json($info,true,iconv_app(get_path_this($zipname)));
            }else{
                return iconv_app($zipname);
            }
        }
    }
    public function unzip(){
        $get_path_to=I('get.path_to');
        import('OT/PclZip');
        ini_set('memory_limit', '2028M');//2G;
        $path=$this->path;
        $name = get_path_this($path);
        $name = substr($name,0,strrpos($name,'.'));
        $unzip_to=get_path_father($path).$name;
        if (!empty($get_path_to)) {//解压到指定位置
            $unzip_to = _DIR($get_path_to);
        }
        //所在目录不可写
        if (!is_writeable(get_path_father($path))){
            show_json("无权限写入",false);
        }
        $zip = new \PclZip($path);
        
        $result = $zip->extract(PCLZIP_OPT_PATH,$unzip_to,PCLZIP_OPT_SET_CHMOD,0777,PCLZIP_OPT_REPLACE_NEWER);//解压到某个地方,覆盖方式
        
        if ($result == 0) {
            show_json("Error : ".$zip->errorInfo(true),fasle);
        }else{
            show_json('解压成功');
        }
    }
    public function image(){
        if (filesize($this->path) <= 1024*10) {//小于10k 不再生成缩略图
            file_put_out($this->path);
        }

        $image= $this->path;
        $image_md5  = md5_file($image);//文件md5
        if (strlen($image_md5)<5) {
            $image_md5 = md5($image);
        }

        $image_thum = DATA_THUMB.$image_md5.'.png';
        if (!is_dir(DATA_THUMB)){
            mkdir(DATA_THUMB,"0777");
        }
        if (!file_exists($image_thum)){//如果拼装成的url不存在则没有生成过
            if ($_SESSION['this_path']==DATA_THUMB){//当前目录则不生成缩略图
                $image_thum=$this->path;
            }else {
                $cm = new \Think\CreatMiniature();
                $cm->SetVar($image,'file');
                $cm->BackFill($image_thum,72,64,true);//等比例缩略图，空白处填填充透明色
            }
        }
        if (!file_exists($image_thum) || filesize($image_thum)<100){//缩略图生成失败则用默认图标
            $image_thum=STATIC_PATH.'images/image.png';
        }
        //输出
        file_put_out($image_thum);
    }

    // 远程下载
    public function serverDownload() {
        $get_uuid=I('get.uuid');
        $get_type=I('get.type');
        $get_save_path=I('get.save_path');
        $get_url=I('get.url');
        
        $uuid = 'download_'.$get_uuid;
        if ($get_type == 'percent') {//获取下载进度
            if (isset($_SESSION[$uuid])){
                $info = $_SESSION[$uuid];
                $result = array(
                    'uuid'      => $get_uuid,
                    'length'    => (int)$info['length'],
                    'size'      => (int)filesize($info['path'].'.download'),
                    'time'      => mtime()
                );
                show_json($result);
            }else{
                show_json('',false);
            }
        }else if($get_type == 'remove'){//取消下载;文件被删掉则自动停止
            del_file($_SESSION[$uuid]['path']);
            unset($_SESSION[$uuid]);
            show_json('',false);
        }
        //下载
        $save_path = _DIR($get_save_path);
        if (!is_writeable($save_path)) show_json("无权限写入",false);

        $url = rawurldecode($get_url);
        $header = url_header($url);
        if (!$header) show_json($this->L['download_error_exists'],false);

        $save_path = $save_path.urldecode($header['name']);
        if (!checkExt($save_path)) $save_path = _DIR($get_save_path).date().'.temp';

        $save_path = iconv_system($save_path);
        $save_path = get_filename_auto($save_path);

        session_start();
        $_SESSION[$uuid] = array('length'=>$header['length'],'path'=>$save_path);
        session_write_close();

        if (file_download_this($url,$save_path)){
            $name = get_path_this(iconv_app($save_path));
            show_json($this->L['download_success'],true,$name);
        }else{
            show_json($this->L['download_error_create'],false);
        }
    }

    //生成临时文件key
    public function makeFileProxy(){
        load_class('mcrypt');
        $pass = $this->config['setting_system']['system_password'];
        $fid = Mcrypt::encode($this->path,$pass,60*50*24);
        show_json($fid);
    }
    //代理输出
    public function fileProxy(){
        file_put_out($this->path);
    }

    /**
     * 上传,html5拖拽  flash 多文件
     */
    public function fileUpload(){
        $get_fullPath=I('get.fullPath');
        $save_path = $this->path;
        if (!is_writeable($save_path)) show_json("无权限写入",false);

        if ($save_path == '') show_json("文件大小超过服务器限制",false);
        if (strlen($get_fullPath) > 1) {//folder drag upload
            $full_path = _DIR_CLEAR(rawurldecode($get_fullPath));
            $full_path = get_path_father($full_path);
            $full_path = iconv_system($full_path);
            if (mk_dir($save_path.$full_path)) {
                $save_path = $save_path.$full_path;
            }
        }
        //upload('file',$save_path);
        //分片上传
        $temp_dir = USER_TEMP;
        mk_dir($temp_dir);
        if (!is_writeable($temp_dir)) show_json("无权限写入",false);
        upload_chunk('file',$save_path,$temp_dir);
    }

    //share list
    private function path_share(){
        $path_hidden = $this->config['setting_system']['path_hidden'];
        $ex_name = explode(',',$path_hidden);

        $userShare = init_controller('userShare');
        $share_list = $userShare->get();
        $list = array(
            'folderlist'    => array(),
            'filelist'      => array(),
            'share_list'    => $share_list,
            'path_type'     => "writeable"
        );
        foreach ($share_list as $key => $value) {
            $value['path'] = $key;
            $value['atime']='';$value['ctime']='';
            $value['mode']='';$value['is_readable'] = 1;$value['is_writable'] = 1;
            $value['exists'] = intval(file_exists(_DIR($share_list[$key]['path'])));
            if ($value['type']=='file') {
                if(in_array($val['name'],$ex_name)) continue;
                $value['ext'] = get_path_ext($share_list[$key]['path']);
                $list['filelist'][] = $value;
            }else{
                if(in_array($val['name'],$ex_name)) continue;
                $list['folderlist'][] = $value;
            }
        }
        return $list;
    }

    //获取文件列表&哦exe文件json解析
    private function path($dir,$list_file=true,$check_children=false){
        $path_hidden = $this->config['setting_system']['path_hidden'];
        $ex_name = explode(',',$path_hidden);
        if (strstr($dir,"*share*")) {
            return $this->path_share();
        }

        $list = path_list($dir,$list_file,$check_children);
        $filelist_new = array();
        $folderlist_new = array();
        foreach ($list['filelist'] as $key => $val) {
            if (in_array($val['name'],$ex_name)) continue;
            if ($val['ext'] == 'oexe'){
                $path = iconv_system($val['path']).'/'.iconv_system($val['name']);
                $json = json_decode(file_get_contents($path),true);
                if(is_array($json)) $val = array_merge($val,$json);
            }
            $filelist_new[] = $val;
        }
        foreach ($list['folderlist'] as $key => $val) {
            if (in_array($val['name'],$ex_name)) continue;
            $folderlist_new[] = $val;
        }
        $list['filelist'] = $filelist_new;
        $list['folderlist'] = $folderlist_new;
        //读写权限判断
        $list['path_type'] = 'readable';
        if (is_writable($dir)) {
            $list['path_type'] = 'writeable';
        }else if (!is_readable($dir)) {
            $list['path_type'] = 'not_readable';
        }
        _DIR_OUT($list);
        return $list;
    }
}