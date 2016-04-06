<?php
//UC通信接口基类,抽象类，必须继承使用
namespace Ucenter\Api;
use Think\Controller;
abstract class Uc extends Controller{

    public $code;//code参数原始字符串
    public $action;//解析code得到的动作名
    public $error = NULL;
    public $post;//post数据
    public $get;//code解密后的数组，get参数

    /**
     * 初始化方法
     */
    public function _initialize(){
        $this->initConfig();//初始化UC应用配置
        $this->initRequest();//初始化请求
    }
    
    function initConfig(){
        require_cache(MODULE_PATH."Conf/uc.php");
        if(!defined('UC_API')) {
            exit('未发现uc配置文件，请确定配置文件位于'.MODULE_PATH."Conf/uc.php");
        }
    }

    /**
     * 解析请求
     * @return boolean
     */
    public function initRequest(){
        $code = @$_GET['code'];
    	parse_str(_authcode($code, 'DECODE', UC_KEY), $get);
    	if(get_magic_quotes_gpc()) {
    		$get = _stripslashes($get);
    	}
            if(empty($get)) {
    		$this->error = '非法请求';
                    return false;
    	}
    	$timestamp = time();
    	if($timestamp - $get['time'] > 3600) {
    		$this->error = '请求有效期已过';
                    return false;
    	}
        $this->get = $get;
    	$this->code = $code;
    	$this->action = parse_name($get['action'],'1');
        $getfile = file_get_contents('php://input');
        $this->post = xml_unserialize($getfile);
    }

    /**
     * 响应ucserver的通信请求，调用相应方法，输出最终结果并结束整个流程
     */
    public function response(){
        if($this->_before_response()){
            if ($this->error !== NULL) {
                exit($this->error);
            }
            if(!method_exists($this, $this->action)){
                $this->error = $this->action.'方法未定义';
                exit($this->error);
            }
            $response = call_user_func(array($this,$this->action),$this->get,$this->post);
        }
        if($this->_after_response($response)){
            exit($response);
        }
        exit('-1');
    }

    protected function _before_response(){
        return true;
    }
    
    protected function _after_response($response=""){
        return true;
    }

    public function test(){
        return '1';
    }

    protected function synlogin($get, $post) {
        $uid = $get['uid'];
        $username = $get['username'];
        if(!API_SYNLOGIN) {
            return API_RETURN_FORBIDDEN;

        }

        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        _setcookie('discuz_ucenter_auth', _authcode($uid."\t".$username, 'ENCODE'), time()+60*60*24*365);
    }

    protected function synlogout($get, $post) {
        if(!API_SYNLOGOUT) {
            return API_RETURN_FORBIDDEN;
        }

        //note 同步登出 API 接口
        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        _setcookie('discuz_ucenter_auth', '', -86400 * 365);
    }

    protected function deleteuser($get, $post) {
        $uids = $get['ids'];
        !API_DELETEUSER && exit(API_RETURN_FORBIDDEN);

        return API_RETURN_SUCCEED;
    }

    protected function renameuser($get, $post) {
        $uid = $get['uid'];
        $usernameold = $get['oldusername'];
        $usernamenew = $get['newusername'];
        if(!API_RENAMEUSER) {
            return API_RETURN_FORBIDDEN;
        }

        return API_RETURN_SUCCEED;
    }

    protected function updatepw($get, $post) {
            if(!API_UPDATEPW) {
                return API_RETURN_FORBIDDEN;
            }
            $username = $get['username'];
            $password = $get['password'];
            return API_RETURN_SUCCEED;
        }

    protected function updatebadwords($get, $post) {
            if(!API_UPDATEBADWORDS) {
                return API_RETURN_FORBIDDEN;
            }
            $cachefile = './Application/Ucenter/Client/uc_client/data/cache/badwords.php';
            $fp = fopen($cachefile, 'w');
            $data = array();
            if(is_array($post)) {
                foreach($post as $k => $v) {
                    $data['findpattern'][$k] = $v['findpattern'];
                    $data['replace'][$k] = $v['replacement'];
                }
            }
            $s = "<?php\r\n";
            $s .= '$_CACHE[\'badwords\'] = '.var_export($data, TRUE).";\r\n";
            fwrite($fp, $s);
            fclose($fp);
            return API_RETURN_SUCCEED;
        }

    protected function updatehosts($get, $post) {
            if(!API_UPDATEHOSTS) {
                return API_RETURN_FORBIDDEN;
            }
            $cachefile = './Application/Ucenter/Client/uc_client/data/cache/hosts.php';
            $fp = fopen($cachefile, 'w');
            $s = "<?php\r\n";
            $s .= '$_CACHE[\'hosts\'] = '.var_export($post, TRUE).";\r\n";
            fwrite($fp, $s);
            fclose($fp);
            return API_RETURN_SUCCEED;
        }

    protected function updateapps($get, $post) {
            if(!API_UPDATEAPPS) {
                return API_RETURN_FORBIDDEN;
            }
            $UC_API = $post['UC_API'];

            //note 写 app 缓存文件
            $cachefile = './Application/Ucenter/Client/uc_client/data/cache/apps.php';
            $fp = fopen($cachefile, 'w');
            $s = "<?php\r\n";
            $s .= '$_CACHE[\'apps\'] = '.var_export($post, TRUE).";\r\n";
            fwrite($fp, $s);
            fclose($fp);

            //note 写配置文件
            if(is_writeable($this->appdir.'./config.inc.php')) {
                $configfile = trim(file_get_contents($this->appdir.'./config.inc.php'));
                $configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
                $configfile = preg_replace("/define\('UC_API',\s*'.*?'\);/i", "define('UC_API', '$UC_API');", $configfile);
                if($fp = @fopen($this->appdir.'./config.inc.php', 'w')) {
                    @fwrite($fp, trim($configfile));
                    @fclose($fp);
                }
            }
        
            return API_RETURN_SUCCEED;
        }

    protected function updateclient($get, $post) {
            if(!API_UPDATECLIENT) {
                return API_RETURN_FORBIDDEN;
            }
            $cachefile = $this->appdir.'./uc_client/data/cache/settings.php';
            $fp = fopen($cachefile, 'w');
            $s = "<?php\r\n";
            $s .= '$_CACHE[\'settings\'] = '.var_export($post, TRUE).";\r\n";
            fwrite($fp, $s);
            fclose($fp);
            return API_RETURN_SUCCEED;
        }

    protected function updatecredit($get, $post) {
            if(!API_UPDATECREDIT) {
                return API_RETURN_FORBIDDEN;
            }
            $credit = $get['credit'];
            $amount = $get['amount'];
            $uid = $get['uid'];
            return API_RETURN_SUCCEED;
        }

    protected function getcredit($get, $post) {
            if(!API_GETCREDIT) {
                return API_RETURN_FORBIDDEN;
            }
        }

    protected function getcreditsettings($get, $post) {
            if(!API_GETCREDITSETTINGS) {
                return API_RETURN_FORBIDDEN;
            }
            $credits = array();
            return $this->_serialize($credits);
        }

    protected function updatecreditsettings($get, $post) {
            if(!API_UPDATECREDITSETTINGS) {
                return API_RETURN_FORBIDDEN;
            }
            return API_RETURN_SUCCEED;
        }

}
