<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.thinkphp.cn>
// +----------------------------------------------------------------------

/**
 * 助手配置文件
 */
return array(

    /* 助手管理密码 */
    'HELPER_PASSWORD' =>  'default',  // 默认助手管理密码，请一定根据自己的需求修改

    /* 主题设置 */
    'DEFAULT_THEME' =>  'default',  // 默认模板主题名称

    /* 数据缓存设置 */
    'DATA_CACHE_PREFIX' => 'onethink_', // 缓存前缀
    'DATA_CACHE_TYPE'   => 'File', // 数据缓存类型
    
    /* 全局过滤配置 */
    'DEFAULT_FILTER' => 'strip_tags,stripslashes', //全局过滤函数

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__Helper_STATIC__' => __ROOT__ . '/Application/Helper/Static',
    ),

    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'onethink_home', //session前缀
    'COOKIE_PREFIX'  => 'onethink_home_', // Cookie前缀 避免冲突
);
