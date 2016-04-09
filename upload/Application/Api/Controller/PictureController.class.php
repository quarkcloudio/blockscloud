<?php
namespace Api\Controller;
use Think\Upload;
/**
 * 图片上传功能API
 */
class PictureController extends BaseController
{
    /**
     * base64图片上传
     * @return json
     * @author 飞马踏清秋  <442000491@qq.com>
     */
    public function uploadBase64_post(){

        $user_id = I('post.uid',0,'int');
        $image_code = I('post.imageCode');

        //if ($user_id && $user_id == UID) {
            $Picture = D('Picture');
            $pic_driver = C('PICTURE_UPLOAD_DRIVER');

            $pic = array();

            $pic['user_id'] = $user_id;
            $pic['image_code'] =  base64_decode($image_code);

            $info = $Picture->upload(
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
        //}
        $this->restError('身份不符',404);
    }


    /**
     * 普通图片上传
     * @return json
     * @author tangtanglove  <869716224@qq.com>
     */
    public function uploadFile_post()
    {

        $setting = array(
            'mimes'    => '', //允许上传的文件MiMe类型
            'maxSize'  => 2*1024*1024, //上传的文件大小限制 (0-不做限制)
            'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
            'autoSub'  => true, //自动子目录保存文件
            'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath' => './Uploads/Picture/', //保存根路径
            'savePath' => '', //保存路径
            'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
            'saveExt'  => '', //文件保存后缀，空则使用原后缀
            'replace'  => false, //存在同名是否覆盖
            'hash'     => true, //是否生成hash编码
            'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
        );
        $upload = new \Think\Upload($setting, 'Local');// 实例化上传类
        // 上传文件 
        $info   =   $upload->upload($_FILES);
        $path   = $url = $setting['rootPath'].$info['file']['savepath'].$info['file']['savename'];
        $url    = str_replace('./', '/', $url);
        $info['fullpath'] = $url;
        if($info){
            $Picture = M('Picture');
            $data['path'] =$path;
            $data['create_time'] = time();
            $data['md5'] = $info['file']['md5'];
            $data['sha1'] = $info['file']['sha1'];
            $data['status'] = 1;
            if($Picture->create($data) && ($id = $Picture->add())){
                $data['cover_id'] = $id;
                $return['status'] = 200;
                $return['info']   = "图片上传成功！";
                $return['data']   = $data;
                $this->response($return,'json');
            }else{
                $this->restError('上传失败',300);
            }

        }else{
            $this->restError('上传失败',300);
        }


    }


}
