<?php
// +----------------------------------------------------------------------
// | BlocksCloud [ Building website as simple as building blocks ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.blockscloud.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtnglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace Common\Model;
use Think\Model;
/**标签模型
 */
class CloudModel {

    /**
     * banner
     * @param type $pos 广告位位置
     * @return string|array 返回模板解析后的内容
     */
    public function banner($pos){
           return M('Advs')->where(array('position'=>$pos))->select(); 
    }

    /**
     * friendlink
     * @param type $num 友情链接数量
     * @return string|array 返回模板解析后的内容
     */
    public function friendlink($num=10){
           return M('SuperLinks')->limit($num)->select();
    }

    /**
     * artlist 获取指定文档列表
     * @param catid,num,pos,order,subday
     */
    public function artlist($catid,$num,$pos,$order,$subday)
    {
        //列表排序
        if (empty($order)) {
            $order = 'id desc';
        }else{
            $order = $order;
        }
        //文章状态
        $map['status'] = 1;

        $children = D('Category')->getChildrenId($catid);

        if (!empty($children)) {
            //如果有子分类
            //分割分类
            $children = explode(',', $children);
            //将当前分类的文章和子分类的文章混合到一起
            $cates = $children;
            //合并分类
            array_push($cates, $catid);
            //组合条件
            $map['category_id'] = array('in',$cates);
        }else{
            $map['category_id'] = $catid;
        }

        //推荐位
        if (!empty($pos)) {
            $map['position'] = array('in',$pos);
        }
        //近期文章
        if (is_numeric($subday)) {
            //如果是数字则是多少天之内的文章
            $starttime = strtotime("-".$subday." day");

        }elseif(!empty($subday)){
            switch ($subday) {
                case 'day'://当天的文章
                    $starttime = strtotime(date('Y-m-d'));
                    break;
                case 'week'://一周的文章
                    $starttime = strtotime("last Sunday");
                    break;
                case 'month'://一月的文章
                    $starttime = strtotime(date('Y-m-1'));
                    break;
                default:
                    $starttime = 0;
                    break;
            }
        }

        if (!empty($subday)) {
            $endtime   = time();
            $map['create_time'] = array(array('gt',$starttime),array('lt',$endtime));
        }

        $list = M('Document')->where($map)->order($order)->limit($num)->select();
        return $list;
    }

    /**
     * 获取指定分类的子分类
     * @param  integer $id    分类ID
     * @param  boolean $field 查询字段
     * @return array
     * @author tangtanglove <dai_hang_love@126.com>         
     */
    public function getSubCateList($id, $field = true){
        $map = array('pid' => $id, 'status' => 1);
        return M('Category')->field($field)->where($map)->order('sort')->select();
    }

    /**
     * 获取指定文章的信息
     * @param  integer $artid    文章ID
     * @param  boolean $field 查询字段
     * @return array
     * @author tangtanglove <dai_hang_love@126.com>         
     */
    public function artinfo($artid, $field = true){
        $map = array('id' => $artid);
        if ($field!='content') {
            $result = M('Document')->where($map)->getField($field);
        }else{
            $result = M('DocumentArticle')->where($map)->getField($field);
        }
        return $result;
    }

} 