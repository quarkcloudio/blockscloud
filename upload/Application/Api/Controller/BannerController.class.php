<?php
namespace Api\Controller;

/**
 * 广告横幅（非登录）
 */
class BannerController extends BaseController
{

    /**
     * 广告主页
     * @return json
     * @author tangtanglove
     */
    public function index_get(){

        /*广告位置*/
        $position = I('get.position');

        if (!empty($position)) {
            $id = M('Advertising')->where(array('pos'=>$position))->getField('id');
            if (!empty($id)) {
                $data = M('Advs')
                ->alias('a')
                ->join('cloud_picture b ON b.id = a.advspic')
                ->where(array('position'=>$id))
                ->field('b.path,a.*')
                ->select();
            }
            foreach ($data as $key => $value) {
                $data[$key]['path'] = 'http://'.$_SERVER['SERVER_NAME'].__ROOT__.$data[$key]['path'];
            }
        }else{
            $this->restError('广告位置不能为空！');
        }

        if ($data) {
            $return['status'] = 200;
            $return['info'] = "获取成功！";
            $return['data'] = $data;
            $this->response($return,'json');
        }else{
            $this->restError("获取失败，请重试！");
        }
    }

    
}
