<?php
namespace Api\Controller;
require_once APP_PATH . 'User/Conf/config.php';
/**
 * 公用功能API（非登录）
 */
class PublicController extends BaseController
{

    /**
     * 找回密码
     * @return json
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    public function findPwd_post(){

        /*用户名*/
        $username = I('post.username');

        $new_password  = I('post.newPassword');

        $data['password'] = think_ucenter_md5($new_password, UC_AUTH_KEY);

        /*验证码*/
        $code         = I('post.verifyCode');

        //判断手机号是不是正确
        if (!$this->isMobile($username)) {
            $this->restError('手机号格式错误！');
        }

        /*检验验证码*/
        if (!empty($code)) {

            //验证码信息
            $VerifyCodeInfo   =   D('VerifyCode')->info($username,$code,1);

            //判断验证码正确性
            if (empty($VerifyCodeInfo)) {
                $this->restError('验证码错误！');
            }

            //检验验证码有效期
            $result_time=time()-$VerifyCodeInfo['create_time'];
            if ($result_time>C('VERIFY_VALID')) {
                $this->restError('验证码已过期！');
            }
            //检验验证码使用次数，防止爆破
            if ($VerifyCodeInfo['times']>6) {
                $this->restError('验证码超过验证次数！');
            }

        }else{
            $this->restError('验证码不能为空！');
        }

        /*验证账号,密码*/
        if (empty($username) || empty($data['password'])) {
            $this->restError('用户名或密码不能为空！');
        }

        /*写入数据库*/
        $uid=M('UcenterMember')->where(array('username'=>$username))->save($data);

        if ($uid) {
            $return['status'] = 200;
            $return['info'] = "重置成功！";
            $this->response($return,'json');
        }else{
            $this->restError("重置失败，请重试！");
        }
    }

    /**
     * 获取当前服务器app版本,低版本提示升级
     * @return json
     * @author tangtanglove  <869716224@qq.com>
     */
    public function version_get(){
        $get_version = I('get.version');
        //TODO
    }

    /**
     * 验证手机号是否正确
     * @author tangtanglove
     * @param int $mobile
     */
    protected function isMobile($mobile) {
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    
}
