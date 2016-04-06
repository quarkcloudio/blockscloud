<?php
/**
 * Created by PhpStorm.
 * User: caipeichao
 * Date: 1/22/14
 * Time: 11:05 PM
 */

namespace Addons\SyncLogin\Model;

use Think\Model;

require_once(dirname(dirname(__FILE__)) . "/ThinkSDK/ThinkOauth.class.php");

class SinaModel
{
    public function sendWeibo($token,$content='')
    {
        $data = false;
        $content=urlencode($content);
        $sina = \ThinkOauth::getInstance('sina', $token);
        !empty($content) &&  $data = $sina->call('statuses/update', "status={$content}",'post');
        return $data;
    }

    public function sendWeiboWithImageUrl($token,$content='',$img_url='')
    {
        $data = false;
        $content=urlencode($content);
        $sina = \ThinkOauth::getInstance('sina', $token);
        $data = $sina->call('statuses/upload_url_text', "status={$content}&url={$img_url}",'post');
        return $data;
    }

    public function getFriendIds($token,$uid=0,$count=50,$page){
        $sina = \ThinkOauth::getInstance('sina', $token);
        $data = $sina->call('friendships/friends/bilateral/ids', "uid={$uid}&count={$count}&page={$page}",'get');
        return $data;
    }

    public function getUserInfo($token){
        $sina = \ThinkOauth::getInstance('sina', $token);
        $userInfo = S('sina_user_info_'.$sina->openid());
        if(empty($userInfo)){
            $userInfo = $sina->call('users/show', "uid={$sina->openid()}");
            S('sina_user_info_'.$sina->openid(),$userInfo,60*60);
        }
        return $userInfo;
    }

}