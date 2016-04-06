<?php
namespace Api\Controller;

/**
 * 获取行政区
 */
class RegionController extends BaseController{
	
	/**
	 * 获取当前客户端城市
	 */
	public function city_get(){

		//客户端经度
		$longitude = I('get.lng');

		//客户端纬度
		$latitude = I('get.lat');

		//实例化类库
		$Geocoding = new \Org\Net\Geocoding;

		//百度地图访问应用（AK）
		$ak = 'glN4ZwI8RKNxl50S4wafxboz';

		$result = $Geocoding->getAddressComponent($ak, $longitude, $latitude, $Geocoding->NO_POIS);

		if ($result) {
			$data['city'] = $result['result']['addressComponent']['district'];
			$data['id'] = M('Region')->where(array('name'=>$data['city']))->getField('id');
		}
		
        //返回数据
        if ($data) {
            $return['status'] = 200;
            $return['info'] = "获取成功！";
            $return['data'] = $data;
            $this->response($return,'json');
        } else {
            $this->restError("获取失败！");
        }

	}
	
	/**
	 * 获取城市列表
	 */
	public function lists_get()
	{
		$pid   = I('pid',0);
		$level = I('level',0);
		
		if (!empty($pid)) {
			$where['pid'] = $pid;
		}

		if (!empty($level)) {
			$where['level_type'] = $level;
		}

		$data = M('Region')->where($where)->field('id,name,pid')->select();

        //返回数据
        if ($data) {
            $return['status'] = 200;
            $return['info'] = "获取成功！";
            $return['data'] = $data;
            $this->response($return,'json');
        } else {
            $this->restError("获取失败！");
        }
	}
	
}
