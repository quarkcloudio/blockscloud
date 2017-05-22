<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Helper;
use Illuminate\Http\Request;
use App\Models\Navigations;
use Validator;
use DB;

class NavbarController extends CommonController
{

    // 获取列表
    public function index(Request $request)
    {

        $title      = $request->input('title');
        $query = Navigations::query()->orderBy('id', 'desc');

        if($title) {
            $query = $query->where('title',$title);
        }
        $lists = $query->get()->toArray();

        $tree = Helper::listToTree($lists);
        $orderList = Helper::treeToOrderList($tree,0,'title');
        $data = [];
        foreach ($orderList as $key => $value) {
            $data[$key]['id'] = $value['id'];
            $data[$key]['title'] = $value['title'];
            $data[$key]['url'] = $value['url'];
            $data[$key]['sort'] = $value['sort'];
            $data[$key]['status'] = $value['status'];
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
        $lists = Navigations::all()->toArray();
        $tree = Helper::listToTree($lists);
        $orderList = Helper::treeToOrderList($tree,0,'title');
        $data = [];
        $data[0]['value'] = 0;
        $data[0]['label'] = '无节点';
        foreach ($orderList as $key => $value) {
            $data[$key+1]['value'] = $value['id'];
            $data[$key+1]['label'] = $value['title'];
        }
        if ($data) {
            return Helper::jsonSuccess('操作成功！','',$data);
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    // 添加信息
    public function store(Request $request)
    {
        $data['title'] = $request->input('title');
        $data['pid'] = $request->input('pid');
        $data['url'] = $request->input('url');
        $data['sort'] = $request->input('sort');
        $data['status'] = 1;
        $result = Navigations::create($data);
        if ($result) {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    // 编辑信息
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $result = Navigations::where('id',$id)->first()->toArray();

        $lists = Navigations::all()->toArray();
        $tree = Helper::listToTree($lists);
        $orderList = Helper::treeToOrderList($tree,0,'title');
        $data = [];
        $data[0]['value'] = 0;
        $data[0]['label'] = '无节点';
        foreach ($orderList as $key => $value) {
            $data[$key+1]['value'] = $value['id'];
            $data[$key+1]['label'] = $value['title'];
        }

        $result['options'] = $data;

        if ($result) {
            return Helper::jsonSuccess('获取成功！','',$result);
        } else {
            return Helper::jsonError('获取失败，请重试！');
        }

    }

    // 执行编辑信息
    public function update(Request $request)
    {
        $id = $request->input('id');
        $data['title'] = $request->input('title');
        $data['pid'] = $request->input('pid');
        $data['url'] = $request->input('url');
        $data['sort'] = $request->input('sort');

        $result = Navigations::where('id',$id)->update($data);
        if ($result) {
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
            $result = Navigations::where('id',$id)->delete();
        } else {
            $result = Navigations::where('id',$id)->update(['status'=>$status]);
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
            $result = Navigations::whereIn('id',$ids)->delete();
        } else {
            $result = Navigations::whereIn('id',$ids)->update(['status'=>$status]);
        }

        if ($result) {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

}