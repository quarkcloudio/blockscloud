<?php

namespace Addons\AliPlay\Controller;
use Home\Controller\AddonsController;

class AliPlayController extends AddonsController{

	/*
	 *读取配置参数写入文件
	 */
	Public function  file(){
		//读取配置信息
		$conf=M('addons')->where(array('name'=>'AliPlay','status'=>1))->getField('config');
		$file = __ADDONROOT__.'/Play/lib/aliplay.php';
		$conf= include $file;
		$data="<?php/r/n".$partner."=>\'".$conf['partner']."\'".";".$key."=>\'".$conf['key']."\'".";/r/n?>";
		//写入文件
		// w表示以写入的方式打开文件，如果文件不存在，系统会自动建立
		$file_pointer = fopen($file,"w");
		if(fwrite($file_pointer,$data))
		{
			return true;
			exit;
		}
		fclose($file_pointer);
	
	}


}
