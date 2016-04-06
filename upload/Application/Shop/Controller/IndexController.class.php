<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace Shop\Controller;
use Think\Controller;

/**
 * tangtanglove
 */
class IndexController extends Controller
{

    /**
     * 商城首页
     * @author tangtanglove
     */
    public function index()
    {
        $this->display(use_theme());
    }

    /**
     * 商品页
     * @author tangtanglove
     */
    public function goods()
    {
        $this->display(use_theme());
    }

    /**
     * 商品详情页
     * @author tangtanglove
     */
    public function goodsDetail($id = 0)
    {
        $this->display(use_theme());
    }

    /**
     * 购买商品
     * @author tangtanglove
     */
    public function goodsBuy()
    {
        $this->display(use_theme());
    }

    /**
     * 个人商品页
     * @author tangtanglove
     */
    public function myGoods()
    {
        $this->display(use_theme());

    }
}