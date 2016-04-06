<?php

namespace Addons\Water;

use Common\Controller\Addon;


class WaterAddon extends Addon
{
    public $info = array(
        'name' => 'Water',
        'title' => '图片水印',
        'description' => '用于为上传的图片添加水印',
        'status' => 1,
        'author' => 'xjw129xjt',
        'version' => '0.1',
    );
    public $custom_config = 'admin_config.html';
    public function install()
    {
        return true;
    }

    public function uninstall()
    {
        return true;
    }
    public function dealPicture($param)
    {
        $config = $this->getConfig();
        if($config['switch']){
            if($config['water']){
                $water = $config['water'];
            }
            else{
                $water = './Addons/Water/water.png';
            }
            $water_open=file_exists($water);
            require_once("./Addons/Water/WaterMark.class.php");
            if($water_open)
            {
                $watermark=new \WaterMark($param ,$config['position']);
                $watermark->setWaterImage($water);
                $watermark->imageWaterMark();
            }
        }
        return $param;
     }

    public function AdminIndex($param)
    {
        $config = $this->getConfig();
        $this->assign('addons_config', $config);
        if ($config['display'])
            $this->display('widget');
    }

}