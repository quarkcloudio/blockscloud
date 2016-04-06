<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Org\Net;
/**
 * 根据地理坐标获取国家、省份、城市，及周边数据类(利用百度Geocoding API实现)
 * 百度密钥获取方法：http://lbsyun.baidu.com/apiconsole/key?application=key（需要先注册百度开发者账号）
 * Date:    2015-07-30
 * Author:  fdipzone
 * Ver: 1.0
 *
 * Func:
 * Public  getAddressComponent 根据地址获取国家、省份、城市及周边数据
 * Private toCurl              使用curl调用百度Geocoding API
 */
class Geocoding {

    // 百度Geocoding API
    const API = 'http://api.map.baidu.com/geocoder/v2/';

    // 不显示周边数据
    const NO_POIS = 0;

    // 显示周边数据
    const POIS = 1; 

    /**
     * 根据地址获取国家、省份、城市及周边数据
     * @param  String  $ak        百度ak(密钥)
     * @param  Decimal $longitude 经度
     * @param  Decimal $latitude  纬度
     * @param  Int     $pois      是否显示周边数据
     * @return Array
     */
    public static function getAddressComponent($ak, $longitude, $latitude, $pois=self::NO_POIS){

        $param = array(
                'ak' => $ak,
                'location' => implode(',', array($latitude, $longitude)),
                'pois' => $pois,
                'output' => 'json'
        );

        // 请求百度api
        $response = self::toCurl(self::API, $param);

        $result = array();

        if($response){
            $result = json_decode($response, true);
        }

        return $result;

    }

    /**
     * 使用curl调用百度Geocoding API
     * @param  String $url    请求的地址
     * @param  Array  $param  请求的参数
     * @return JSON
     */
    private static function toCurl($url, $param=array()){

        $ch = curl_init();

        if(substr($url,0,5)=='https'){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));

        $response = curl_exec($ch);

        if($error=curl_error($ch)){
            return false;
        }

        curl_close($ch);

        return $response;

    }

}
