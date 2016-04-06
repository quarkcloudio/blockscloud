<?php
// +----------------------------------------------------------------------
// | 积木云
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.ixiaoquan.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <869716224@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

/**
 * 主题公共库文件
 * 命名规则 主题名_方法名称 例如xiu_get_tags()
 */

/**
 * 获取tags标签
 * @author tangtanglove
 */
function get_tags($artid)
{
    $tags = M('Tags')->where(array('article_id'=>$artid))->select();
    if (!empty($tags)) {
        foreach ($tags as $key => $value) {
            $tags_name = urlencode($value['tags_name']);
            $i = $key+1;
            $str =$str."<a href='/tag/$tags_name' title='".$value['tags_name']."' target='_blank'  class='c".$i."'>".$value['tags_name']."</a> ";
        }
    }
    return $str;

}

/**
 * 获取tags列表标签
 * @author tangtanglove
 */
function get_tags_list()
{
    $tags = M('Tags')->field('count(tags_name) as num,tags_name')->order('num desc')->limit(24)->group('tags_name')->select();
    if (!empty($tags)) {
        foreach ($tags as $key => $value) {
            $tags_name = urlencode($value['tags_name']);
            $url = "/tag/".$tags_name;
            $str =$str."<li><a title='".$value['num']."个话题' href='".$url."'>".$value['tags_name']."</a></li>";
        }
    }
    return $str;

}

/**
 * 获取文章内图片数量
 * @author tangtanglove
 */
function article_images_count($artid)
{
    $content = M('DocumentArticle')->where(array('id'=>$artid))->getField('content');
    preg_match_all('~<img [^>]* />~', $content, $thePics );
    $count = count($thePics[0]);
    return $count; 

}

/**
 * 获取文章内图片列表
 * @author tangtanglove
 */
function article_images_list($artid)
{
    $content = M('DocumentArticle')->where(array('id'=>$artid))->getField('content');
    preg_match_all("|src=(.*) |U", $content, $result); 
    $count = count($result[1]);
    $url = U("Home/Article/detail?id=$artid");
    if (1<=$count && $count<4) { 
        $path = $result[1][0];
        $imglist = "<a class='thumbnail' href='$url'><span class='item'><span class='thumb-span'><img class='thumb' data-original=$path src=$path style='display: inline;'></span></span></a>";
    }elseif (4<=$count &&$count<8) {
        $imglist = "<a target='_blank' href='$url' class='thumbnail'>";
        foreach ($result[1] as $key => $value) {
            $imglist = $imglist."<span class='item'><span class='thumb-span'><img data-original=$value class='thumb' /></span></span>";
            if($key===3) {
                break; //break 终止循环
            }
        }
        $imglist = $imglist."</a>";
    }else{
        $imglist = "<a target='_blank' href='$url' class='thumbnail'>";
        foreach ($result[1] as $key => $value) {
            $imglist = $imglist."<span class='item'><span class='thumb-span'><img data-original=$value class='thumb' /></span></span>";
            if($key===7) {
                break; //break 终止循环
            }
        }
        $imglist = $imglist."</a>";
    }

    return $imglist;

}


/**
 * 获取文章内图片
 * @author tangtanglove
 */
function get_article_images($artid)
{
    $content = M('DocumentArticle')->where(array('id'=>$artid))->getField('content');
    preg_match_all("|src=(.*) |U", $content, $result); 
    $count = count($result[1]);
    $url = U("Home/Article/detail?id=$artid");
    if (1<=$count) { 
        $path = $result[1][0];
        $imglist = "<p><img src=$path width='100%'></p>";
    }
    return $imglist;

}


// 获取用户拥有的文章
function user_article_count()
{
    $where['status'] = array('gt',0);
    $where['uid']    = is_login();
    return M('Document')->where($where)->count();
}

// 获取下载文件模型字段
function downloadinfo($downid,$field)
{
    $result = M('DocumentDownload')->where(array('id'=>$downid))->getField($field);

    if ($field=='size') {
        $result = $result/(1024*1024);
        $result = round($result,2);
    } 

    return $result;
}