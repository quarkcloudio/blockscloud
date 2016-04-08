<?php
namespace Api\Controller;

/**
 * 文章功能API
 */
class ArticleController extends BaseController{

    /**
     * 获取导航栏
     */
    public function navigation_get(){
        $pid   = I('get.pid',0);
        $limit = I('get.limit',10);
        $data  = M('Channel')->where(array('pid'=>$pid,'status'=>1))->limit($limit)->order('sort asc')->select();

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

    /**
     * 获取文章列表
     */
    public function lists_get(){

        $page   = I('get.page',1);
        $num    = I('get.num',10);
        //分类标识
        $name   = I('get.name');

        //搜索关键词
        $q    = I('get.q');

        if (!empty($q)) {
            $q = mb_convert_encoding($q, "UTF-8", "auto");
            $where['title'] = array('like','%'.$q.'%');
        }
        
        if (!empty($name)) {

            $catid = M('Category')->where(array('name'=>$name))->getField('id');
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

        $data = M('Document')->where($where)->page("$page,$num")->order('level asc,id desc')->select();

        foreach ($data as $key => $value) {
            $data[$key]['cover']   = get_cover($value['cover_id']);
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
    

    /**
     * 获取文章内容
     */
    public function detail_get(){

        $id         = I('get.id');

        //获得基本数据
        $data       = M('Document')->where(array('id'=>$id))->find();

        //获得内容
        $content    = M('DocumentArticle')->where(array('id'=>$id))->getField('content');

        //内容图片加域名
        $content    = $this->replacePicUrl($content,'http://'.$_SERVER['HTTP_HOST'].__ROOT__);
        
        /* 更新浏览数 */
        M('Document')->where(array('id' => $id))->setInc('view');
        $data['update_time'] = date('Y-m-d H',$data['update_time']);
        $data['username'] = get_username($data['uid']);
        //返回数据
        if ($data) {
            //组合数据
            $data['content'] = $content;
            $return['status'] = 200;
            $return['info'] = "获取成功！";
            $return['data'] = $data;
            $this->response($return,'json');
        } else {
            $this->restError("获取失败！");
        }
        

    }
    
    /** 
     * 替换内容中的图片 添加域名 
     * @param  string $content 要替换的内容 
     * @param  string $strUrl 内容中图片要加的域名 
     * @return string  
     * @eg  
     */  
    private function replacePicUrl($content = null, $strUrl = null) {  
        if ($strUrl) {  
            //提取图片路径的src的正则表达式 并把结果存入$matches中    
            preg_match_all("/<img(.*)src=\"([^\"]+)\"[^>]+>/isU",$content,$matches);  
            $img = "";    
            if(!empty($matches)) {    
            //注意，上面的正则表达式说明src的值是放在数组的第三个中    
            $img = $matches[2];    
            }else {    
               $img = "";    
            }  
            if (!empty($img)) {    
                $patterns= array();    
                $replacements = array();    
                foreach($img as $imgItem){    
                    $final_imgUrl = $strUrl.$imgItem;    
                    $replacements[] = $final_imgUrl;    
                    $img_new = "/".preg_replace("/\//i","\/",$imgItem)."/";    
                    $patterns[] = $img_new;    
                }    
    
                //让数组按照key来排序    
                ksort($patterns);    
                ksort($replacements);    
    
                //替换内容    
                $vote_content = preg_replace($patterns, $replacements, $content);  
          
                return $vote_content;  
            }else {  
                return $content;  
            }                     
        } else {  
            return $content;  
        }  
    }

    /**
     * 评论列表
     */
    public function commentLists_get() {
         //评论信息
        $page                   = I('get.page',1);
        $num                    = I('get.num',10);
        $where['app_type']      = I('get.appType');
        $where['app_detail_id'] = I('get.appDetailId');
        $where['status']        = 1;
        $where['pid']           = 0;

        $data = M('Comment')->where($where)->page("$page,$num")->order('id asc')->select();

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $data[$key]['replynum'] = M('Comment')->where(array('pid'=>$value['id'],'status'=>1))->count();
                $data[$key]['nickname'] = M('Member')->where(array('uid'=>$value['uid']))->getField('nickname');
                $path = M('Avatar')->where(array('uid'=>$value['uid']))->getField('path');
                $path = str_replace('./', '/', $path);
                $data[$key]['avatar'] = $path;
                $data[$key]['create_time'] = date('Y-m-d H',$data['create_time']);
            }
        }

        if (!empty($data)) {
            $return['status']=200;
            $return['info']="获取成功！";
            $return['data']=$data;
        }else{
            $return['status']=300;
            $return['info']="无评论！";
            $return['data']=$data;
        }

        $this->response($return,'json');

    }

    /**
    * 回复我的评论
    */
    public function replyLists_get() {
        //获取当前登录用户
        $id   = I('get.commentId');
        $uid  = I('get.uid');
        $page = I('get.page',1);
        $num  = I('get.num',10);

        if (empty($id)) {
            $this->restError("参数错误！");
        }
        
        //查询评论表
        $result=M('Comment')->where(array('id'=>$id,'status'=>1))->find();
        $list=M('Comment')->where(array('pid'=>$id,'status'=>1))->page("$page,$num")->select();
        foreach ($list as $key => $value) {
            $list[$key]['replynum'] = M('Comment')->where(array('pid'=>$value['id'],'status'=>1))->count();
            $list[$key]['nickname'] = M('Member')->where(array('uid'=>$value['uid']))->getField('nickname');
            $path = M('Avatar')->where(array('uid'=>$value['uid']))->getField('path');
            $path = str_replace('./', '/', $path);
            $list[$key]['avatar'] = $path;
            $result[$key]['create_time'] = date('Y-m-d H',$data['create_time']);
        }
        $result['replynum'] = M('Comment')->where(array('pid'=>$result['id'],'status'=>1))->count();
        $result['nickname'] = M('Member')->where(array('uid'=>$result['uid']))->getField('nickname');
        $path = M('Avatar')->where(array('uid'=>$result['uid']))->getField('path');
        $path = str_replace('./', '/', $path);
        $result['avatar'] = $path;
        $result['replyList'] = $list;

        if($result){
          //返回数据
         $return['status']=200;
         $return['info']="我的评论列表";
         $return['data']=$result;
         $this->response($return,'json');
        }else{
            $this->restError("无评论！");
        }
        
    }
    
    
}