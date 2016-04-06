<?php
namespace Api\Controller;

/**
 * 搜索
 */
class SearchController extends BaseController
{
	//搜索
	public function search_get(){

		$page   = I('get.page',1);
		$num    = I('get.num',10);
		$catid  = I('get.catid');
		//搜索关键词
		$q    = I('get.q');

		if (!empty($q)) {
			$q = mb_convert_encoding($q, "UTF-8", "auto");
			$where1['title'] = $where['title'] = array('like','%'.$q.'%');
		}else{
			$this->error('参数错误！');
		}
		
		if (!empty($catid)) {

            $children = D('Category')->getAllChildrenId($catid);
            if (!empty($children)) {
                //如果有子分类
                //分割分类
                $children = explode(',', $children);
                //将当前分类的文章和子分类的文章混合到一起
                $cates = $children;
                //合并分类
                array_push($cates, $catid);
                //组合条件
                $where['category_id'] = array('in',$cates);
            }else{
                $where['category_id'] = $catid;
            }

		}

		$where['status'] = 1;

		$data = M('Document')->where($where)->page("$page,$num")->order($order)->select();

        foreach ($data as $key => $value) {
            $data[$key]['cover_id']   = get_cover($value['cover_id']);
            $data[$key]['create_time'] = date('Y-m-d H',$value['create_time']);
            $data[$key]['update_time'] = date('Y-m-d H',$value['update_time']);
        }

        //返回数据
        if ($data) {
            $return['status'] = 200;
            $return['info'] = "获取成功！";
            $return['data'] = $data;
            $this->response($return,'json');
        } else {
            $this->restError("获取失败！");
        }

	}
	
}
