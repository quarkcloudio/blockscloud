<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace Admin\Builder;

class AdminListBuilder extends AdminBuilder
{
    private $_title;
    private $_keyList = array();
    private $_buttonList = array();
    private $_pagination = array();
    private $_data = array();
    private $_setStatusUrl;
    private $_searchPostUrl;
    private $_search = array();

    /**
     * @param $url string 已被U函数解析的地址
     * @return $this
     */
    public function setStatusUrl($url)
    {
        $this->_setStatusUrl = $url;
        return $this;
    }

    /**设置搜索提交表单的URL
     * @param $url
     * @return $this
     * @auth 陈一枭
     */
    public function setSearchPostUrl($url)
    {
        $this->_searchPostUrl = $url;
        return $this;
    }

    public function button($title, $attr)
    {
        $this->_buttonList[] = array('title' => $title, 'attr' => $attr);
        return $this;
    }

    public function buttonNew($href, $title = '新增', $attr = array())
    {
        $attr['href'] = $href;
        return $this->button($title, $attr);
    }

    public function ajaxButton($url, $params, $title, $attr = array())
    {
        $attr['class'] = 'btn ajax-post';
        $attr['url'] = $this->addUrlParam($url, $params);
        $attr['target-form'] = 'ids';
        return $this->button($title, $attr);
    }

    public function buttonSetStatus($url, $status, $title, $attr)
    {
        $attr['class'] = 'btn ajax-post';
        $attr['url'] = $this->addUrlParam($url, array('status' => $status));
        $attr['target-form'] = 'ids';
        return $this->button($title, $attr);
    }

    public function buttonDisable($url = null, $title = '禁用', $attr = array())
    {
        if (!$url) $url = $this->_setStatusUrl;
        return $this->buttonSetStatus($url, 0, $title, $attr);
    }

    public function buttonEnable($url = null, $title = '启用', $attr = array())
    {
        if (!$url) $url = $this->_setStatusUrl;
        return $this->buttonSetStatus($url, 1, $title, $attr);
    }

    /**
     * 删除到回收站
     */
    public function buttonDelete($url = null, $title = '删除', $attr = array())
    {
        if (!$url) $url = $this->_setStatusUrl;
        return $this->buttonSetStatus($url, -1, $title, $attr);
    }

    public function buttonRestore($url = null, $title = '还原', $attr = array())
    {
        if (!$url) $url = $this->_setStatusUrl;
        return $this->buttonSetStatus($url, 1, $title, $attr);
    }

    /**清空回收站
     * @param null $model 要清空回收站的模型
     * @return $this
     * @auth 陈一枭
     */
    public function buttonClear($model = null)
    {
        return $this->button('清空', array('class' => 'btn ajax-post tox-confirm', 'data-confirm' => '您确实要清空回收站吗？（清空后不可恢复）', 'url' => U('', array('model' => $model)), 'target-form' => 'ids'));
    }

    public function buttonSort($href, $title = '排序', $attr = array())
    {
        $attr['href'] = $href;
        return $this->button($title, $attr);
    }

    /**搜索
     * @param string $title 标题
     * @param string $name 键名
     * @param string $type 类型，默认文本
     * @param string $des 描述
     * @param        $attr 标签文本
     * @return $this
     * @auth 陈一枭
     */
    public function search($title = '搜索', $name = 'key', $type = 'text', $des = '', $attr)
    {
        $this->_search[] = array('title' => $title, 'name' => $name, 'type' => $type, 'des' => $des, 'attr' => $attr);
        return $this;
    }

    public function key($name, $title, $type, $opt = null)
    {
        $key = array('name' => $name, 'title' => $title, 'type' => $type, 'opt' => $opt);
        $this->_keyList[] = $key;
        return $this;
    }

    public function keyText($name, $title)
    {
        return $this->key($name, $title, 'text');
    }

    public function keyHtml($name, $title)
    {
        return $this->key($name, $title, 'html');
    }

    public function keyMap($name, $title, $map)
    {
        return $this->key($name, $title, 'map', $map);
    }

    public function keyId($name = 'id', $title = 'ID')
    {
        return $this->keyText($name, $title);
    }

    /**
     * @param $name
     * @param $title
     * @param $getUrl Closure|string
     * 可以是函数或U函数解析的字符串。如果是字符串，该函数将附带一个id参数
     *
     * @return $this
     */
    public function keyLink($name, $title, $getUrl)
    {
        //如果getUrl是一个字符串，则表示getUrl是一个U函数解析的字符串
        if (is_string($getUrl)) {
            $getUrl = $this->createDefaultGetUrlFunction($getUrl);
        }

        //添加key
        return $this->key($name, $title, 'link', $getUrl);
    }

    public function keyStatus($name = 'status', $title = '状态')
    {
        $map = array(-1 => '删除', 0 => '禁用', 1 => '启用', 2 => '未审核');
        return $this->key($name, $title, 'status', $map);
    }

    public function keyYesNo($name, $title)
    {
        $map = array(0 => '不是', 1 => '是');
        return $this->keymap($name, $title, $map);
    }

    public function keyBool($name, $title)
    {
        return $this->keyYesNo($name, $title);
    }

    public function keyImage($name, $title)
    {
        return $this->key($name, $title, 'image');
    }

    public function keyTime($name, $title)
    {
        return $this->key($name, $title, 'time');
    }

    public function keyCreateTime($name = 'create_time', $title = '创建时间')
    {
        return $this->keyTime($name, $title);
    }

    public function keyUpdateTime($name = 'update_time', $title = '更新时间')
    {
        return $this->keyTime($name, $title);
    }

    public function keyUid($name = 'uid', $title = '用户')
    {
        return $this->key($name, $title, 'uid');
    }

    public function keyTitle($name = 'title', $title = '标题')
    {
        return $this->keyText($name, $title);
    }

    public function keyDoAction($getUrl, $text, $title = '操作')
    {
        //获取默认getUrl函数
        if (is_string($getUrl)) {
            $getUrl = $this->createDefaultGetUrlFunction($getUrl);
        }

        //确认已经创建了DOACTIONS字段
        $doActionKey = null;
        foreach ($this->_keyList as $key) {
            if ($key['name'] === 'DOACTIONS') {
                $doActionKey = $key;
                break;
            }
        }
        if (!$doActionKey) {
            $this->key('DOACTIONS', $title, 'doaction', array());
        }

        //找出第一个DOACTIONS字段
        $doActionKey = null;
        foreach ($this->_keyList as &$key) {
            if ($key['name'] == 'DOACTIONS') {
                $doActionKey = & $key;
                break;
            }
        }

        //在DOACTIONS中增加action
        $doActionKey['opt']['actions'][] = array('text' => $text, 'get_url' => $getUrl);
        return $this;
    }

    public function keyDoActionEdit($getUrl, $text = '编辑')
    {
        return $this->keyDoAction($getUrl, $text);
    }

    public function keyDoActionRestore($text = '还原')
    {
        $that = $this;
        $setStatusUrl = $this->_setStatusUrl;
        $getUrl = function () use ($that, $setStatusUrl) {
            return $that->addUrlParam($setStatusUrl, array('status' => 1));
        };
        return $this->keyDoAction($getUrl, $text, array('class' => 'ajax-get'));
    }

    public function keyTruncText($name, $title, $length)
    {
        return $this->key($name, $title, 'trunktext', $length);
    }

    /**
     * 不要给listRows默认值，因为开发人员很可能忘记填写listRows导致翻页不正确
     * @param $totalCount
     * @param $listRows
     * @return $this
     */
    public function pagination($totalCount, $listRows)
    {
        $this->_pagination = array('totalCount' => $totalCount, 'listRows' => $listRows);
        return $this;
    }

    public function data($list)
    {
        $this->_data = $list;
        return $this;
    }

    public function display()
    {
        //key类型的等价转换
        //map转换成text
        $this->convertKey('map', 'text', function ($value, $key) {
            return $key['opt'][$value];
        });

        //uid转换成text
        $this->convertKey('uid', 'text', function ($value) {
            $value = get_username($value);
            return $value;
        });

        //time转换成text
        $this->convertKey('time', 'text', function ($value) {
            if($value!=0){
                return time_format($value);
            }
            else{
                return '-';
            }
        });

        //trunctext转换成text
        $this->convertKey('trunktext', 'text', function ($value, $key) {
            $length = $key['opt'];
            return msubstr($value, 0, $length);
        });

        //text转换成html
        $this->convertKey('text', 'html', function ($value) {
            return $value;
        });

        //link转换为html
        $this->convertKey('link', 'html', function ($value, $key, $item) {
            $value = htmlspecialchars($value);
            $getUrl = $key['opt'];
            $url = $getUrl($item);
            return "<a href=\"$url\">$value</a>";
        });

        //image转换为图片

        $this->convertKey('image', 'html', function ($value, $key, $item) {
            $value = htmlspecialchars($value);
            $sc_src = get_cover($value, 'path');

            $src = getThumbImageById($value, 80, 80);
            $sc_src = $sc_src == '' ? $src : $sc_src;
            return "<div class='popup-gallery'><a title=\"查看大图\" href=\"$sc_src\"><img src=\"$src\"/ style=\"width:80px;height:80px\"></a></div>";
        });

        //doaction转换为html
        $this->convertKey('doaction', 'html', function ($value, $key, $item) {
            $actions = $key['opt']['actions'];
            $result = array();
            foreach ($actions as $action) {
                $getUrl = $action['get_url'];
                $linkText = $action['text'];
                $url = $getUrl($item);
                $result[] = "<a href=\"$url\">$linkText</a>";
            }
            return implode(' ', $result);
        });

        //status转换为html
        $setStatusUrl = $this->_setStatusUrl;
        $that = & $this;
        $this->convertKey('status', 'html', function ($value, $key, $item) use ($setStatusUrl, $that) {
            //如果没有设置修改状态的URL，则直接返回文字
            $map = $key['opt'];
            $text = $map[$value];
            if (!$setStatusUrl) {
                return $text;
            }

            //返回带链接的文字
            $switchStatus = $value == 1 ? 0 : 1;
            $url = $that->addUrlParam($setStatusUrl, array('status' => $switchStatus, 'ids' => $item['id']));
            return "<a href=\"{$url}\" class=\"ajax-get\">$text</a>";
        });

        //如果html为空
        $this->convertKey('html', 'html', function ($value) {
            if ($value === '') {
                return '<span style="color:#bbb;">（空）</span>';
            }
            return $value;
        });

        //编译buttonList中的属性
        foreach ($this->_buttonList as &$button) {
            $button['tag'] = isset($button['attr']['href']) ? 'a' : 'button';
            $this->addDefaultCssClass($button);
            $button['attr'] = $this->compileHtmlAttr($button['attr']);
        }

        //生成翻页HTML代码
        C('VAR_PAGE', 'page');
        $pager = new \Think\Page($this->_pagination['totalCount'], $this->_pagination['listRows'], $_REQUEST);
        $pager->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $paginationHtml = $pager->show();

        //显示页面
        $this->assign('title', $this->_title);
        $this->assign('keyList', $this->_keyList);
        $this->assign('buttonList', $this->_buttonList);
        $this->assign('pagination', $paginationHtml);
        $this->assign('list', $this->_data);
        /*加入搜索*/
        $this->assign('searches', $this->_search);
        $this->assign('searchPostUrl', $this->_searchPostUrl);
        parent::display('admin_list');
    }

    public function doSetStatus($model, $ids, $status)
    {
        $ids = is_array($ids) ? $ids : explode(',', $ids);
        M($model)->where(array('id' => array('in', $ids)))->save(array('status' => $status));
        $this->success('设置成功', $_SERVER['HTTP_REFERER']);
    }

    private function convertKey($from, $to, $convertFunction)
    {
        foreach ($this->_keyList as &$key) {
            if ($key['type'] == $from) {
                $key['type'] = $to;
                foreach ($this->_data as &$data) {
                    $value = & $data[$key['name']];
                    $value = $convertFunction($value, $key, $data);
                    unset($value);
                }
                unset($data);
            }
        }
        unset($key);
    }

    private function addDefaultCssClass(&$button)
    {
        if (!isset($button['attr']['class'])) {
            $button['attr']['class'] = 'btn';
        } else {
            $button['attr']['class'] .= ' btn';
        }
    }

    /**
     * @param $pattern U函数解析的URL字符串，例如 Admin/Test/index?test_id=###
     * Admin/Test/index?test_id={other_id}
     * ###将被id替换
     * {other_id}将被替换
     * @return callable
     */
    private function createDefaultGetUrlFunction($pattern)
    {
        return function ($item) use ($pattern) {
            $pattern = str_replace('###', $item['id'], $pattern);
            //调用ThinkPHP中的解析引擎解析变量
            $view = new \Think\View();
            $view->assign($item);
            $pattern = $view->fetch('', $pattern);
            return U($pattern);
        };
    }

    public function addUrlParam($url, $params)
    {
        if (strpos($url, '?') === false) {
            $seperator = '?';
        } else {
            $seperator = '&';
        }
        $params = http_build_query($params);
        return $url . $seperator . $params;
    }

    /**自动处理清空回收站
     * @param string $model 要清空的模型
     * @auth 陈一枭
     */
    public function clearTrash($model = '')
    {
        if (IS_POST) {
            if ($model != '') {
                $result = D($model)->where(array('status' => -1))->delete();
                if ($result) {
                    $this->success('成功清空回收站，共删除 ' . $result . ' 条记录。');
                }
                $this->error('回收站是空的，未能删除任何东西。');
            } else {
                $this->error('请选择要清空的模型。');
            }
        }
    }

    /**
     * keyLinkByFlag  带替换表示的链接
     * @param        $name
     * @param        $title
     * @param        $getUrl
     * @param string $flag
     * @return $this
     * @author:xjw129xjt xjt@ourstu.com
     */
    public function keyLinkByFlag($name, $title, $getUrl, $flag = 'id')
    {

        //如果getUrl是一个字符串，则表示getUrl是一个U函数解析的字符串
        if (is_string($getUrl)) {
            $getUrl = $this->ParseUrl($getUrl, $flag);
        }

        //添加key
        return $this->key($name, $title, 'link', $getUrl);
    }

    private function ParseUrl($pattern, $flag)
    {
        return function ($item) use ($pattern, $flag) {

            $pattern = str_replace('###', $item[$flag], $pattern);
            //调用ThinkPHP中的解析引擎解析变量
            $view = new \Think\View();
            $view->assign($item);
            $pattern = $view->fetch('', $pattern);
            return U($pattern);
        };
    }

}