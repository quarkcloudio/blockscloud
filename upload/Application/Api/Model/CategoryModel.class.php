<?php
namespace Api\Model;
use Think\Model;

/**
 * 短信验证码模型模型
 */

class CategoryModel extends Model {

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
