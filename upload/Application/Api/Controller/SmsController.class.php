<?php
namespace Api\Controller;

/**
 * 短信功能API
 */
class SmsController extends BaseController{

    /**
     * sms_post 生成验证码
     * @return string 验证码（用于测试）
     */
    public function do_post() {

        //手机号
        $mobile    = I('post.mobile');

        //注册或找回密码
        $type      = I('post.type');

        //防刷短信
        $this->check($mobile, $type);

        $result = D('VerifyCode')->createVerifyCode($mobile, $type);

        //执行发短信
        if ($result) {
            send_sms($mobile,'【领航信息】您的验证码为：'.$result.'，该验证码在5分钟内有效');
        }

        if ($result) {
            $return['status'] = 200;
            $return['info'] = "发送成功！";
            $return['data'] = array('code' =>$result);
            $this->response($return,'json');
        }else{
            $this->restError("发送失败，请重试！");
        }

    }

    /**
     * check 防刷短信,检查时间间隔
     * @return bool
     */
    protected function check($mobile, $type){
        /*防刷短信*/
        $code=M('VerifyCode')->where(array('mobile'=>$mobile,'type'=>$type))->order('id desc')->find();
        if(!empty($code)){
            if((time()-$code['create_time'])<C('INTERVAL_VALID')){
                $this->restError('验证码发送频繁');
            }
        }
    }
}
