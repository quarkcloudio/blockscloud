<?php
/**
 *
 * @author quick
 *
 */
namespace Addons\Water\Controller;

use Admin\Controller\AddonsController;

class FileController extends AddonsController
{

    public function uploadPicture(){
        $config = array(
            'maxSize'    =>    3145728,
            'rootPath'   =>    './Uploads/',
            'savePath'   =>    'water/',
            'saveName'   =>    'water',
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'    =>    true,
            'subName'    =>    '',
            'replace'=> true,
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload($_FILES);
        if($info){
            $return['status'] = 1;
            $return['url'] = './Uploads/water/'.$info['download']['savename'];
        }else{
            $return['status'] = 0;
            $return['info'] = '上传失败';
        }

        $this->ajaxReturn($return);
    }

}