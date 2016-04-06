<?php
namespace Api\Model;
use Think\Model;

/**
 * 短信验证码模型模型
 */

class VerifyCodeModel extends Model {
    
    /**
     * 自动完成
     * @var array
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
    );

    /**
     * info 获取验证码信息
     * @param  string $user_mobile 手机号
     * @param  string $code        验证码
     * @param  string $type        1注册2找回密码
     * @return array               验证码数组
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    public function info($mobile,$code,$type){

        $result =  $this->where(array('mobile'=>$mobile,'verify_code'=>$code,'type'=>$type))->order('id desc')->find();
        //增加验证码验证次数
        if ($result) {
            $this->where(array('mobile'=>$mobile,'verify_code'=>$code,'type'=>$type))->setInc('score',1);
        }
        return $result;
    }

    /**
     * createVerifyCode 生成短信验证码
     * @param  string  $mobile 手机号
     * @param  integer $type   类型 1：注册，2找回密码
     * @param  string  $client 客户类型 android,ios
     * @param  integer $length 验证码位数
     * @return boolen
     * @author 飞马踏清秋  <442000491@qq.com>          
     */
    public function createVerifyCode($mobile, $type = 1, $length = 6){

        $data['mobile'] = $mobile;
        $data['verify_code'] = rand_code($length);
        $data['type'] = $type;
        $data['create_time'] = time();
        $result = M('VerifyCode')->add($data);

        if ($result) {
            return $data['verify_code'];
        }
        return false;
    }
}
