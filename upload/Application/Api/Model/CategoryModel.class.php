<?php
namespace Api\Model;
use Think\Model;

/**
 * 分类模型
 */

class CategoryModel extends Model {


    //存放无限分类结果如果一页面有多个无限分类可以使用 Tool::$treeList = array(); 清空
    static public $treeList = array(); 

    /**
     * 获取指定分类子分类ID
     * @param  string $cate 分类ID
     * @return string       id列表
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function getAllChildrenId($cate){
        /* 获取所有分类 */
        $map  = array('status' => 1);
        $list = $this->field($field)->where($map)->order('sort')->field('id,pid')->select();
        $get_ids = $category = D('Category')->tree($list,$cate);
        foreach ($get_ids as $key => $value) {
            $ids[] = $value['id'];
        }
        return implode(',', $ids);
    }

     /**
     * 无限级分类
     * @access public 
     * @param Array $data     //数据库里获取的结果集 
     * @param Int $pid             
     * @param Int $count       //第几级分类
     * @return Array $treeList   
     */
    static public function tree(&$data,$pid = 0,$count = 1) {
        foreach ($data as $key => $value){
            if($value['pid']==$pid){
                $value['count'] = $count;
                self::$treeList []=$value;
                unset($data[$key]);
                self::tree($data,$value['id'],$count+1);
            } 
        }
        return self::$treeList ;
    }

    /**
     * getCateInfo 获取分类文章
     * @param  string $name 分类标识
     * @return array               数组
     * @author tangtanglove  <869716224@qq.com>
     */

    public function getInfo($name){
        return $this->alias('a')
             ->join('category_content as b ON b.cid = a.id')
             ->where(array('a.name'=>$name))
             ->field('a.title,b.content,a.create_time')->select();
    }

}
