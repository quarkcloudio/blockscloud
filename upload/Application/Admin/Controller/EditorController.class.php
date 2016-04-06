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

class EditorController extends AdminController{

	// 多文件编辑器
	public function index(){
		$this->display();
	}
	// 单文件编辑
	public function edit(){
		$this->assign('editor_config',$this->getConfig());//获取编辑器配置信息
		$this->display();
	}

	// 获取文件数据
	public function fileGet(){
		$get_filename=I('get.filename');
		$filename=_DIR($get_filename);
		if (!is_readable($filename)) show_json('没有读取权限',false);
		if (filesize($filename) >= 1024*1024*20) show_json('文件过大',false);

		$filecontents=file_get_contents($filename);//文件内容

		$charset=$this->_get_charset($filecontents);
		if ($charset!='' || $charset!='utf-8') {
			$filecontents=mb_convert_encoding($filecontents,'utf-8',$charset);
		}
		$data = array(
			'ext'		=> get_path_ext($filename),
			'name'      => iconv_app(get_path_this($filename)),
			'filename'	=> rawurldecode($get_filename),
			'charset'	=> $charset,
			'content'	=> $filecontents			
		);
		show_json($data);
	}
	public function fileSave(){
		$get_filestr=I('post.filestr');
		$get_charset=I('post.charset');
		$get_path=I('post.path');
		$filestr = rawurldecode($get_filestr);
		$charset = $get_charset;
		$path =_DIR($get_path);
		if (!is_writable($path)) show_json($this->L['no_permission_write_file'],false);
		
		if ($charset !='' || $charset != 'utf-8') {
			$filestr=mb_convert_encoding($filestr,$get_charset,'utf-8');
		}
		$fp=fopen($path,'wb');
		fwrite($fp,$filestr);
		fclose($fp);
		show_json('保存成功！');
	}

	/*
	* 获取编辑器配置信息
	*/
	public function getConfig(){
		$default = array(
			'font_size'		=> '15px',
			'theme'			=> 'clouds',
			'auto_wrap'		=> 0,
			'display_char'	=> 0,
			'auto_complete'	=> 1,
			'function_list' => 1
		);
		$config_file = USER.'data/editor_config.php';		
		if (!file_exists($config_file)) {//不存在则创建
			$sql=new \Think\FileCache($config_file);
			$sql->reset($default);
		}else{
			$sql=new fileCache($config_file);
			$default = $sql->get();
		}
		if (!isset($default['function_list'])) {
			$default['function_list'] = 1;
		}
		return json_encode($default);
    }
	/*
	* 获取编辑器配置信息
	*/
	public function setConfig(){
		$file = USER.'data/editor_config.php';	
        if (!is_writeable($file)) {//配置不可写
            show_json($this->L['no_permission_write_file'],false);
        }
		$key= $this->in['k'];
		$value = $this->in['v'];
        if ($key !='' && $value != '') {
        	$sql=new fileCache($file);
        	if(!$sql->update($key,$value)){
        		$sql->add($key,$value);//没有则添加一条
        	}
            show_json($this->L["setting_success"]);
        }else{
            show_json($this->L['error'],false);
        }
    }

    //-----------------------------------------------
	/*
	* 获取字符串编码
	* @param:$ext 传入字符串
	*/
	private function _get_charset(&$str) {
		if ($str == '') return 'utf-8';
		//前面检测成功则，自动忽略后面
		$charset=strtolower(mb_detect_encoding($str,'ASCII,UTF-8,GBK'));
		if (substr($str,0,3)==chr(0xEF).chr(0xBB).chr(0xBF)){
			$charset='utf-8';
		}elseif($charset=='cp936'){
			$charset='gbk';
		}
		if ($charset == 'ascii') $charset = 'utf-8';
		return strtolower($charset);
	}
}