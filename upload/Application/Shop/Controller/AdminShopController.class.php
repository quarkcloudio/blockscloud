<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use Admin\Builder\AdminConfigBuilder;
use Admin\Builder\AdminListBuilder;
use Admin\Builder\AdminTreeListBuilder;
use Think\Model;

/**
 * Class ShopController
 * @package Admin\controller
 * @郑钟良
 */
class AdminShopController extends AdminController
{

    function _initialize()
    {

    }

    /**商品分类
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function shopCategory()
    {

    }

    /**分类添加
     * @param int $id
     * @param int $pid
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function add($id = 0, $pid = 0)
    {

    }

    /**分类回收站
     * @param int $page
     * @param int $r
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function categoryTrash($page = 1, $r = 20,$model='')
    {

    }


    public function operate($type = 'move', $from = 0)
    {

    }

    /**商品分类合并
     * @param $id
     * @param $toid
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function doMerge($id, $toid)
    {

    }

    /**
     * 设置商品分类状态：删除=-1，禁用=0，启用=1
     * @param $ids
     * @param $status
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function setStatus($ids, $status)
    {

    }

    /**
     * 设置商品状态：删除=-1，禁用=0，启用=1
     * @param $ids
     * @param $status
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function setGoodsStatus($ids, $status)
    {

    }

    /**商品列表
     * @param int $page
     * @param int $r
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function goodsList($page = 1, $r = 20)
    {

    }

    /**设置是否为新品
     * @param int $id
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function setNew($id = 0)
    {

    }

    /**商品回收站
     * @param int $page
     * @param int $r
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function goodsTrash($page = 1, $r = 10,$model='')
    {

    }

    /**
     * @param int $id
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function goodsEdit()
    {

    }

    /**tox_money中文名称配置
     * @param int $id
     * @param string $cname
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function toxMoneyConfig($id = 0, $cname = '')
    {

    }

    public function hotSellConfig($id = 0, $cname = 0)
    {

    }

    /**已完成交易列表
     * @param int $page
     * @param int $r
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function goodsBuySuccess($page = 1, $r = 20)
    {

    }

    /**待发货交易列表
     * @param int $page
     * @param int $r
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function verify($page = 1, $r = 10)
    {

    }


    public function setGoodsBuyStatus($ids, $status)
    {

    }

    /**商城日志
     * @param int $page
     * @param int $r
     * @author 郑钟良<zzl@ourstu.com>
     */
    public function shopLog($page = 1, $r = 20)
    {

    }

}
