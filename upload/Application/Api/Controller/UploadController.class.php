<?php
namespace Api\Controller;

/**
 * 上传功能API
 */
class UploadController extends CommonController
{
    /**
     * picture_post 一般图片上传
     * @return json
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    public function picture_post(){
        $user_id = I('post.uid',0,'int');
        $image_code = I('post.imageCode');
        if ($user_id && $user_id == UID) {
            $pic = array();
            $pic['user_id'] = $user_id;
            $pic['image_code'] =  base64_decode($image_code);
            $pic_driver = C('PICTURE_UPLOAD_DRIVER');
            $info = D('Picture')->upload(
                $pic,
                C('PICTURE_UPLOAD'),
                C('PICTURE_UPLOAD_DRIVER'),
                C("UPLOAD_{$pic_driver}_CONFIG")
            );

            if($info){
                $return['status'] = 200;
                $return['info'] = "图片上传成功！";
                $return['data'] = $info;
                $this->response($return,'json');
            }
            $this->restError('上传失败',300);
        }
        $this->restError('身份不符',404);
    }

}
