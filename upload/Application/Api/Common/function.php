<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

/**
 * rand_code 随机密码
 * @param  integer $length 位数
 * @return string  $code 生成的字符串       
 * @author 飞马踏清秋
 */
function rand_code($length = 6) {
    $string="0123456789";
    $count = strlen($string) - 1;
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $str[$i] = $string[rand(0, $count)];
        $code .= $str[$i];
    }
    return $code;
}

/**
 * round2 保留两位小数
 * @param  float  $num  数值
 * @param  boolean $type 类型（四舍五入或者）
 * @return float  
 * @author 飞马踏清秋
 */
function round2($num ,$type = true){
    if ($type) {
        $num = sprintf("%.2f", $num );  
    }else{
        $num = sprintf("%.2f",substr(sprintf("%.3f", $num), 0, -2)); 
    }
    
    return $num ;
}

/**
 * IP地址转换为正整形
 * @param  string $ip  IP地址
 * @return integer 正整形数字 int(11)
 * @author 飞马踏清秋  <442000491@qq.com>
 */
function ip2int($ip){
    return sprintf("%u",ip2long($ip));
}

/**
 * IP地址转换为正整形
 * @param  integer $int  正整形数字 int(11)
 * @return string IP地址
 * @author 飞马踏清秋  <442000491@qq.com>
 */
function int2ip($int){
    return long2ip($int);
}

?>