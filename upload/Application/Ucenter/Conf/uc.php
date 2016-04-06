<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.thinkphp.cn>
// +----------------------------------------------------------------------

//UCenter的基本配置不能删除
define('IN_DISCUZ', TRUE);
define('API_DELETEUSER', 1);        //note 用户删除 API 接口开关
define('API_RENAMEUSER', 1);        //note 用户改名 API 接口开关
define('API_GETTAG', 1);        //note 获取标签 API 接口开关
define('API_SYNLOGIN', 1);      //note 同步登录 API 接口开关
define('API_SYNLOGOUT', 1);     //note 同步登出 API 接口开关
define('API_UPDATEPW', 1);      //note 更改用户密码 开关
define('API_UPDATEBADWORDS', 1);    //note 更新关键字列表 开关
define('API_UPDATEHOSTS', 1);       //note 更新域名解析缓存 开关
define('API_UPDATEAPPS', 1);        //note 更新应用列表 开关
define('API_UPDATECLIENT', 1);      //note 更新客户端缓存 开关
define('API_UPDATECREDIT', 1);      //note 更新用户积分 开关
define('API_GETCREDITSETTINGS', 1); //note 向 UCenter 提供积分设置 开关
define('API_GETCREDIT', 1);     //note 获取用户的某项积分 开关
define('API_UPDATECREDITSETTINGS', 1);  //note 更新应用积分设置 开关
define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');

//同步登录Cookie设置不能删除
define('COOKIEDOMAIN', '');// cookie 作用域
define('COOKIEPATH', '/');// cookie 作用路径
define('COOKIEPRE', '');
define('TIMESTAMP', 0);

//从UCenter服务端复制相应信息粘贴到此处
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', 'localhost');
define('UC_DBUSER', 'root');
define('UC_DBPW', 'root');
define('UC_DBNAME', 'ultrax');
define('UC_DBCHARSET', 'utf8');
define('UC_DBTABLEPRE', '`ultrax`.pre_ucenter_');
define('UC_DBCONNECT', '0');
define('UC_KEY', '123456');
define('UC_API', 'http://www.tools.com/bbs/uc_server');
define('UC_CHARSET', 'utf-8');
define('UC_IP', '');
define('UC_APPID', '2');
define('UC_PPP', '20');

