<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\Helper;
use App\Models\PostCate;

class PostCateController extends CommonController
{

    // 获取列表
    public function index(Request $request)
    {
        $name      = $request->input('name');
        $query = PostCate::query()->orderBy('id', 'desc');

        if($name) {
            $query = $query->where('name',$name);
        }
        $lists = $query->get()->toArray();

        $tree = Helper::listToTree($lists);
        $orderList = Helper::treeToOrderList($tree);
        $data = [];
        foreach ($orderList as $key => $value) {
            $data[$key]['id'] = $value['id'];
            $data[$key]['name'] = $value['name'];
            $data[$key]['slug'] = $value['slug'];
            $data[$key]['count'] = $value['count'];
        }

        if($data) {
            return Helper::jsonSuccess('获取成功！','',$data);
        } else {
            return Helper::jsonSuccess('获取失败！');
        }
    }

    // 添加信息
    public function create(Request $request)
    {
        $lists = PostCate::all()->toArray();
        $tree = Helper::listToTree($lists);
        $orderList = Helper::treeToOrderList($tree);
        $data = [];
        $data[0]['value'] = 0;
        $data[0]['label'] = '无节点';
        foreach ($orderList as $key => $value) {
            $data[$key+1]['value'] = $value['id'];
            $data[$key+1]['label'] = $value['name'];
        }
        if ($data) {
            return Helper::jsonSuccess('操作成功！','',$data);
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    // 执行添加信息
    public function store(Request $request)
    {
        $data['name'] = $request->input('name');
        $data['slug'] = $request->input('slug');
        $data['pid'] = $request->input('pid');
        $data['uuid'] = Helper::createUuid();
        $data['taxonomy'] = 'category';
        $data['description'] = '';

        $result = PostCate::create($data);

        $extend['lists_tpl'] = $request->input('lists_tpl');
        $extend['detail_tpl'] = $request->input('detail_tpl');
        $extend['page_num'] = $request->input('page_num');

        if ($result) {
            Helper::addKeyValue('post_cates.extend',$data['uuid'],$extend);
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    // 编辑信息
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $result = PostCate::where('id',$id)->first()->toArray();

        $lists = PostCate::all()->toArray();
        $tree = Helper::listToTree($lists);
        $orderList = Helper::treeToOrderList($tree);
        $data = [];
        $data[0]['value'] = 0;
        $data[0]['label'] = '无节点';
        foreach ($orderList as $key => $value) {
            $data[$key+1]['value'] = $value['id'];
            $data[$key+1]['label'] = $value['name'];
        }

        $keyValueInfo = Helper::getKeyValue($result['uuid'],'post_cates.extend');

        $result['options'] = $data;

        if(!empty($keyValueInfo)) {
            $newArray = array_merge($result,$keyValueInfo);
        } else {
            $newArray = $result;
        }

        if ($newArray) {
            return Helper::jsonSuccess('获取成功！','',$newArray);
        } else {
            return Helper::jsonError('获取失败，请重试！');
        }
    }

    // 执行编辑信息
    public function update(Request $request)
    {
        $id = $request->input('id');
        $data['name'] = $request->input('name');
        $data['slug'] = $request->input('slug');
        $data['pid']  = $request->input('pid');
        $data['uuid'] = $request->input('uuid');
        $data['taxonomy'] = 'category';
        $data['description'] = '';

        $extend['lists_tpl'] = $request->input('lists_tpl');
        $extend['detail_tpl'] = $request->input('detail_tpl');
        $extend['page_num'] = $request->input('page_num');

        if ($id == $data['pid']) {
            return Helper::jsonError('不可以选择自己作为父节点！');
        }

        $result = PostCate::where('id',$id)->update($data);
        $result1 = Helper::updateKeyValue('post_cates.extend',$data['uuid'],$extend);
        if ($result || $result1) {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    // 设置状态
    public function setStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        if($status == -1) {
            $postCateInfo = PostCate::where('id',$id)->first();
            $result = PostCate::where('id',$id)->delete();
            Helper::delKeyValue($postCateInfo->uuid,'post_cates.extend');
        } else {
            $result = PostCate::where('id',$id)->update(['status'=>$status]);
        }

        if ($result) {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    // 设置多选状态
    public function setAllStatus(Request $request)
    {
        $status = $request->input('status');
        $selection = $request->input('selection');

        foreach ($selection as $key => $value) {
            $ids[] = $value['id'];
        }

        if($status == -1) {
            $postCateLists = PostCate::whereIn('id',$ids)->get();
            $result = PostCate::whereIn('id',$ids)->delete();
            foreach ($postCateLists as $key => $value) {
                Helper::delKeyValue($value->uuid,'post_cates.extend');
            }
        } else {
            $result = PostCate::whereIn('id',$ids)->update(['status'=>$status]);
        }

        if ($result) {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

}