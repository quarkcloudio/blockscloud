<?php
namespace Api\Controller;

/**
 * 用户评论
 * @author jing
 */
class CommentController extends CommonController
{
    /**
     * 评论
     */
    public function do_post()
    {
        //获取当前登录用户
        $uid = I('post.uid');
        $data['uid'] = $uid;
        $data['pid'] = I('post.pid', 0);
        $data['app_type'] = I('post.appType','article');
        $data['app_detail_id'] = I('post.appDetailId');
        $data['content'] = I('post.content');
        $data['create_time'] = time();
        //接收数据
        $badwords = C('COMMENT_BADWORDS');
        if ($uid && $uid == UID) {
            //敏感词检测.如果comment的内容存在敏感词,则不允许提交
            $words = explode('，', $badwords);
            $count = count($words);
            for ($i = 0; $i < $count; $i++) {
                if (strstr($data['content'], $words[$i]) !== false) {
                    $this->restError('存在敏感词汇！');
                } else {
                    $data['status'] = 1;
                    //写入Comment表
                    M('Comment')->add($data);
                    //返回数据
                    $return['status'] = 200;
                    $return['info'] = '评论成功！';
                    $return['data'] = array('uid' => $data['uid'], 'content' => $data['content'], 'article_id' => $data['article_id']);
                    $this->response($return, 'json');
                }
            }
        } else {
            $this->restError('身份不符！');
        }
    }

    /**
     * 取消评论
     */
    public function cancel_post()
    {
        //获取当前登录为uid的用户信息
        $uid = I('post.uid');
        $data['id'] = I('post.id');
        //验证身份
        if ($uid && $uid == UID) {
            // 查找当前登录的用户评论的是商品还是商家信息
            $comment = M('Comment')->where(array('uid' => $uid, 'id' => $data['id']))->find();
            // 如果存在，则取消评论
            if ($comment) {
                //评论则删除Comment表记录
                $result = M('Comment')->where(array('uid' => $uid, 'id' => $data['id']))->delete();
                // 返回数据
                if ($result) {
                    $return['status'] = 200;
                    $return['info'] = '取消成功！';
                    $return['data'] = array('uid' => $uid, 'id' => $data['id'], 'status' => -1);
                    $this->response($return, 'json');
                } else {
                    $this->restError('取消失败！');
                }
            } else {
                $this->restError('取消失败！');
            }
        } else {
            $this->restError('身份不符！');
        }
    }
    /**
     * 我的评论
     */
    public function mylists_get()
    {
        //获取当前登录用户
        $uid = I('get.uid');
        $page = I('get.page', 1);
        $num = I('get.num', 10);
        if ($uid && $uid == UID) {
            //查询评论表
            $result = M('Comment')->where(array('uid' => $uid, 'status' => 1))->page("{$page},{$num}")->select();
            foreach ($result as $key => $value) {
                $result[$key]['nickname'] = M('Member')->where(array('uid' => $value['uid']))->getField('nickname');
                $path = M('Avatar')->where(array('uid' => $value['uid']))->getField('path');
                $path = str_replace('./', '/', $path);
                $result[$key]['avatar'] = $path;
            }
            if ($result) {
                //返回数据
                $return['status'] = 200;
                $return['info'] = '我的评论列表';
                $return['data'] = $result;
                $this->response($return, 'json');
            } else {
                $this->restError('无评论！');
            }
        } else {
            $this->restError('身份不符！');
        }
    }
    //评论点赞接口
    public function like_post()
    {
        $id = I('post.commentId');
        $uid = I('post.uid');
        if (empty($id)) {
            $this->restError('参数错误！');
        }
        //验证身份
        if ($uid && $uid == UID) {
            $result = M('Comment')->where(array('id' => $id))->setInc('like');
            //返回数据
            if ($result) {
                $this->restSuccess('操作成功！');
            } else {
                $this->restError('操作失败！');
            }
        } else {
            $this->restError('身份不符！');
        }
    }
}