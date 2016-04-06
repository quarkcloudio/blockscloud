<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace Admin\Builder;
use Think\View;
use Admin\Model\AuthGroupModel;
use Admin\Controller\AdminController;

/**
 * AdminBuilder：快速建立管理页面。
 *
 * 为什么要继承AdminController？
 * 因为AdminController的初始化函数中读取了顶部导航栏和左侧的菜单，
 * 如果不继承的话，只能复制AdminController中的代码来读取导航栏和左侧的菜单。
 * 这样做会导致一个问题就是当AdminController被官方修改后AdminBuilder不会同步更新，从而导致错误。
 * 所以综合考虑还是继承比较号好。
 *
 * Class AdminBuilder
 * @package Admin\Builder
 */
abstract class AdminBuilder extends AdminController {
    public function display($templateFile='',$charset='',$contentType='',$content='',$prefix='') {
        //获取模版的名称
        $template = dirname(__FILE__) . '/../View/Builder/' . $templateFile . '.html';

        //显示页面
        parent::display($template);
    }

    protected function compileHtmlAttr($attr) {
        $result = array();
        foreach($attr as $key=>$value) {
            $value = htmlspecialchars($value);
            $result[] = "$key=\"$value\"";
        }
        $result = implode(' ', $result);
        return $result;
    }
    public function title($title)
    {
        $this->_title = $title;
        $this->assign('meta_title',$title);
        return $this;
    }
}

