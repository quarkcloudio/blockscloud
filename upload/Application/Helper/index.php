<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

return array(
    //模块标识名
    'name' => 'Helper',
    //模块名称
    'title' => '助手模块',
    //版本号
    'version' => '1.0.0',
    //是否商业模块,1是，0，否
    'is_com' => 0,
    //模块描述
    'description' => '助手模块，可用命令配置网站',
    //开发者
    'author' => 'tangtanglove',
    //开发者网站
    'website' => 'http://www.ixiaoquan.com/',
    //前台入口，可用U函数
    'entry' => 'Helper/index/index',
    //后台快捷方式
    'shortcut_name' => '网站助手',
    //后台快捷方式管理地址
    'shortcut_url' => './helper.php?s=/Index/index',
    //后台快捷方式图标地址
    'shortcut_img_url' => './Application/Helper/icon.png',

);