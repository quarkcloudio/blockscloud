<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Helper\Model;
use Think\Model;

/**
 * 分类模型
 */
class CategoryModel extends Model{

     static public $treeList = array(); 
     //存放无限分类结果如果一页面有多个无限分类可以使用 Tree::$treeList = array(); 清空
    /**
     * 无限级分类
     * access public
     * @param Array $data        //数据库里获取的结果集
     * @param Int $pid
     * @param Int $count        //第几级分类
     * return Array $treeList
     */
    static public function tree($data,$pid = 0, $count = 0) {

        foreach ($data as $key => $value){

            if($value['pid']==$pid){
                $value['level'] = $count;
                //对标题进行格式化
                $value['title'] = str_repeat("\t", $count).'title:'.$value['title'];
                self::$treeList[] = $value;
                self::tree($data,$value['id'],$count + 1);
            }

        }
        return self::$treeList;
    }

}
