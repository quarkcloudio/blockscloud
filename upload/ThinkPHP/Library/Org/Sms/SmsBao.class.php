<?php
// +----------------------------------------------------------------------
// | smsbao for thinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2005 http://smsbao.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://smsbao.com )
// +----------------------------------------------------------------------
// | Author: llq <llqqxf@163.com>
// +----------------------------------------------------------------------
namespace Org\Sms;
/**
 * SmsBao实现类
 * @category   Think
 * @package  Think
 * @subpackage  Sms
 * @author    llqqxf <llqqxf@163.com>
 */
class SmsBao {

    private $account;//短信包账户
    private $password;//密码
    private $balance;//短信剩余条数
    const sendSmsUrl = "http://api.smsbao.com/sms";
    const queryBalanceUrl = "http://api.smsbao.com/query";
    /**
     * 架构函数
     * @access public
     * @param string $account  在短信宝注册的账户名
     * @param string $password  在短信宝注册的账户名的密码
     */
    public function __construct($account,$password) {
        if (empty($account) || empty($password)) {
           E("用户名和密码不可为空!");
        }
        $this->account = $account;
        $this->password = $password;
    }
    
    /**
     * 发送短信函数
     * @access public
     * @param string $mobile  手机号，多个手机号用英文逗号分隔
     * @param string $content  发送内容
     * @return array 返回值为数组，其中status为0表明发送成功，其他情况下发送失败，失败原因为msg
     */
    public function sendSms($mobile,$content){
        $param['u'] = $this->account;
        $param['p'] = md5($this->password);
        $param['m'] = $mobile;
        $param['c'] = $content;
        $ret = self::http(self::sendSmsUrl, $param);
        $data['status'] = $ret;
        $data['msg'] = $ret == 0 ?'发送成功' : self::getResult($ret);
        return $data;
    }
    
    /**
     * 获取短信剩余条数函数
     * @access public
     */
    public function getBalance(){
        $param['u'] = $this->account;
        $param['p'] = md5($this->password);
        $ret = self::http(self::queryBalanceUrl, $param);
        $retArr = split("\n", $ret);
        $balanceArr = split(",", $retArr[1]);
        $this->balance = $retArr[0] == 0 ? $balanceArr[1] : self::getResult($ret);
        return $this->balance;
    }
   /**
     * 发送http请求
     * @access protected
     * @param string $url  请求地址
     * @param string $param  get方式请求内容，数组形式，post方式时无效
     * * @param string $data  post请求方式时的内容，get方式时无效
     * @param string $method  请求方式，默认get
     */
    protected static function http($url, $param, $data = '', $method = 'GET'){
        $opts = array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        );
    
        /* 根据请求类型设置特定参数 */
        $opts[CURLOPT_URL] = $url . '?' . http_build_query($param);
    
        if(strtoupper($method) == 'POST'){
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $data;
    
            if(is_string($data)){ //发送JSON数据
                $opts[CURLOPT_HTTPHEADER] = array(
                    'Content-Type: application/json; charset=utf-8',
                    'Content-Length: ' . strlen($data),
                );
            }
        }
    
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
    
        //发生错误，抛出异常
        if($error) throw new \Exception('请求发生错误：' . $error);
    
        return  $data;
    }
    private function getResult($key){
        $rst['30'] = '密码错误';
        $rst['40'] = '账号不存在';
        $rst['41'] = '余额不足';
        $rst['42'] = '帐号过期';
        $rst['43'] = 'IP地址限制';
        $rst['50'] = '内容含有敏感词';
        $rst['51'] = '手机号码不正确';
        return $rst[$key];
    }

}
