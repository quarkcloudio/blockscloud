<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace Common\TagLib;
use Think\Template\TagLib;
//积木云标签库
class Cloud extends TagLib {
    // 标签定义
    protected $tags = array(
        //前台模板标签
        'template' => array('attr' => 'file,theme', 'close' => 0),
        //前台同级栏目列表标签通常用于menu
        'catelist' => array('attr' => 'name,category', 'close' => 1),
        //前台子级栏目列表标签通常用于menu
        'subcatelist' => array('attr' => 'name,category', 'close' => 1),
        //前台banner
        'banner' => array('attr' => 'name,pos', 'close' => 1),
        //前台友情链接
        'friendlink' => array('attr' => 'name,num', 'close' => 1),
        //获取指定文档列表
        'artlist' => array('attr' => 'name,catid,num,pos,order,subday','close' => 1),
        //获取上一篇文章信息
        'prev'     => array('attr' => 'name,info', 'close' => 1), 
        //获取下一篇文章信息
        'next'     => array('attr' => 'name,info', 'close' => 1), 
        //列表分页
        'page'     => array('attr' => 'cate,listrow', 'close' => 0), 
        //获取指定分类列表(带分页)
        'list'     => array('attr' => 'name,category,child,page,row,field', 'close' => 1), 
        //获取指定文章的信息
        'artinfo'  => array('attr' => 'artid,strip,num,field', 'close' => 0), 
    );

    /**
     * 加载前台模板
     * 格式：<template file="Content/footer.php" theme="主题"/>
     * @staticvar array $_templateParseCache
     * @param type $attr file，theme
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function _template($attr, $content) {
        $theme = C('SITE_THEME');
        $templateFile = $attr['file'];
        //不是直接指定模板路径的
        if (false === strpos($templateFile, C('TMPL_TEMPLATE_SUFFIX'))) {
            $templateFile = './Theme/' . $theme . '/' . $templateFile . C('TMPL_TEMPLATE_SUFFIX');
        } else {
            $templateFile = './Theme/' . $theme . '/' . $templateFile;
        }
        //判断模板是否存在
        if (!file_exists_case($templateFile)) {
            $templateFile = str_replace($theme . '/', 'Default/', $templateFile);
            if (!file_exists_case($templateFile)) {
                return '';
            }
        }
        //读取内容
        $tmplContent = file_get_contents($templateFile);
        //解析模板
        $parseStr = $this->tpl->parse($tmplContent);
        return $parseStr;
    }

    /**
     * 前台同级栏目列表标签通常用于menu
     * 格式：<catelist name="my" category="6" >{$my.title}</catelist> 
     * @param type $attr name，category
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function _catelist($tag, $content){
        $name   = $tag['name'];
        $cate   = $tag['category'];
        $parse  = '<?php ';
        $parse .= '$__LIST__ = D(\'Category\')->getSameLevel('.$cate.');';
        $parse .= ' ?>';
        $parse .= '<volist name="__LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        //解析模板
        $parseStr = $this->tpl->parse($parse);
        return $parseStr;
    }

    /**
     * 前台子级栏目列表标签通常用于menu
     * 格式：<catelist name="my" category="6" >{$my.title}</catelist> 
     * @param type $attr name，category
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function _subcatelist($tag, $content){
        $name   = $tag['name'];
        $cate   = $tag['category'];
        $parse  = '<?php ';
        $parse .= '$__LIST__ = D(\'Cloud\')->getSubCateList('.$cate.');';
        $parse .= ' ?>';
        $parse .= '<volist name="__LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        //解析模板
        $parseStr = $this->tpl->parse($parse);
        return $parseStr;
    }

    /**
     * banner注意：需要安装广告位插件
     * 格式：<banner name="vo" pos="6" >{$vo.title}</banner> 
     * @param type $attr name，pos
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function _banner($tag, $content){
        $name   = $tag['name'];
        $pos    = $tag['pos'];
        $parse  = '<?php ';
        $parse .= '$__LIST__ = D(\'Cloud\')->banner('.$pos.');';
        $parse .= ' ?>';
        $parse .= '<volist name="__LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        //解析模板
        $parseStr = $this->tpl->parse($parse);
        return $parseStr;
    }

    /**
     * friendlink注意：需要安装广告位插件
     * 格式：<friendlink name="vo" >{$vo.title}</friendlink> 
     * @param type $attr name
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function _friendlink($tag, $content){
        $name   = $tag['name'];
        $num    = $tag['num'];
        $parse  = '<?php ';
        $parse .= '$__LIST__ = D(\'Cloud\')->friendlink('.$num.');';
        $parse .= ' ?>';
        $parse .= '<volist name="__LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        //解析模板
        $parseStr = $this->tpl->parse($parse);
        return $parseStr;
    }

    /**
     * artlist 获取指定文档列表
     * 格式：<artlist name="vo" >{$vo.title}</artlist> 
     * @param type $attr name,catid,num,pos,order,subday
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function _artlist($tag, $content){
        $name   = $tag['name'];
        $catid  = empty($tag['catid']) ? '0' : $tag['catid'];
        $num    = empty($tag['num']) ? '6' : $tag['num'];
        $pos    = empty($tag['pos']) ? '' : $tag['pos'];
        $order  = empty($tag['order']) ? '' : $tag['order'];
        $subday = empty($tag['subday']) ? '' : $tag['subday'];

        $parse  = '<?php ';
        $parse .= '$__LIST__ = D(\'Cloud\')->artlist(';
        $parse .= $catid . ',';
        $parse .= '\''.$num . '\',';
        $parse .= '\''.$pos . '\',';
        $parse .= '\''.$order . '\',';
        $parse .= '\''.$subday.'\');';
        $parse .= ' ?>';
        $parse .= '<volist name="__LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        //解析模板
        $parseStr = $this->tpl->parse($parse);
        return $parseStr;
    }

    /**
     * list 获取指定分类列表（带分页）
     * 格式：<list name="vo" >{$vo.title}</list> 
     * @param type $attr name,category,child,page,row,field
     * @param type $content
     * @return string|array 返回模板解析后的内容
     */
    public function _list($tag, $content){
        $name   = $tag['name'];
        $cate   = $tag['category'];
        $child  = empty($tag['child']) ? 'false' : $tag['child'];
        $row    = empty($tag['row'])   ? '10' : $tag['row'];
        $field  = empty($tag['field']) ? 'true' : $tag['field'];

        $parse  = '<?php ';
        $parse .= '$__CATE__ = D(\'Category\')->getChildrenId('.$cate.');';
        $parse .= '$__LIST__ = D(\'Document\')->page(!empty($_GET["p"])?$_GET["p"]:1,'.$row.')->lists(';
        $parse .= '$__CATE__, \'`level` DESC,`id` DESC\', 1,';
        $parse .= $field . ');';
        $parse .= ' ?>';
        $parse .= '<volist name="__LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        //解析模板
        $parseStr = $this->tpl->parse($parse);
        return $parseStr;
    }
    
    /* 列表数据分页 */
    public function _page($tag){
        $cate    = $tag['cate'];
        $listrow = $tag['listrow'];
        $parse   = '<?php ';
        $parse  .= '$__PAGE__ = new \Think\Page(get_list_count(' . $cate . '), ' . $listrow . ');';
        $parse  .= 'echo $__PAGE__->showFront();';
        $parse  .= ' ?>';
        //解析模板
        $parseStr = $this->tpl->parse($parse);
        return $parseStr;
    }

    /* 获取下一篇文章信息 */
    public function _next($tag, $content){
        $name   = $tag['name'];
        $info   = $tag['info'];
        $parse  = '<?php ';
        $parse .= '$' . $name . ' = D(\'Document\')->next($' . $info . ');';
        $parse .= ' ?>';
        $parse .= '<notempty name="' . $name . '">';
        $parse .= $content;
        $parse .= '</notempty>';
        //解析模板
        $parseStr = $this->tpl->parse($parse);
        return $parseStr;
    }

    /* 获取上一篇文章信息 */
    public function _prev($tag, $content){
        $name   = $tag['name'];
        $info   = $tag['info'];
        $parse  = '<?php ';
        $parse .= '$' . $name . ' = D(\'Document\')->prev($' . $info . ');';
        $parse .= ' ?>';
        $parse .= '<notempty name="' . $name . '">';
        $parse .= $content;
        $parse .= '</notempty>';
        //解析模板
        $parseStr = $this->tpl->parse($parse);
        return $parseStr;
    }

    /**
     * artid:文章id,strip:是否去除html标签,num：截取字符数量,field：获取的字段
     */
    public function _artinfo($tag, $content){
        $name   = $tag['name'];
        $artid  = $tag['artid'];
        $strip  = $tag['strip'];
        $num    = $tag['num'];
        $field  = $tag['field'];
        $content = D('Cloud')->artinfo($artid,$field);

        //开启过滤html标签
        if ($strip == 1) {
            $content = strip_tags($content);
        }

        if (!empty($num)) {
            $content = mb_substr($content,0,$num,'utf-8').'...';
        }

        $parse = $content;

        //解析模板
        $parseStr = $this->tpl->parse($parse);
        return $parseStr;
    }

}
