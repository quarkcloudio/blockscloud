<?php
namespace Ucenter\Client;
use Think\Controller;
abstract class Client extends Controller{
    public function __construct(){
        $this->initConfig();
        require_cache(dirname(__FILE__)."/uc_client/client.php");//加载uc客户端主脚本
    }
    //加载配置
    public function initConfig(){
        require_cache(MODULE_PATH."Conf/uc.php");
        if(!defined('UC_API')) {
            E('未发现uc配置文件，请确定配置文件位于'.MODULE_PATH."Conf/uc.php");
        }
    }
    
    function __call($method,$params){
        $method = parse_name($method,0);//函数命名风格转换，兼容驼峰法
        if(function_exists($method)){
            return call_user_func_array($method, $params);
        }else{
            return -1;//api函数不存在
        }
    }
}
