<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Permission;
use App\User;
use App\Services\Helper;

class PermissionController extends Controller
{

    // 获取列表
    public function index(Request $request)
    {
        // 获取当前页码
        $page      = $request->input('page');
        $name      = $request->input('name');

        $query = Permission::query();
        $query = $query->skip(($page-1)*10)->take(10);
        $totalQuery = $query;
        if($name) {
            $query = $query->where('name',$name);
            $totalQuery = $totalQuery->where('name',$name);
        }
        $lists = $query->get();
        $total = $totalQuery->count();

        if($lists) {
            $data['lists'] = $lists;
            $data['total'] = $total;
            return Helper::jsonSuccess('获取成功！','',$data);
        } else {
            return Helper::jsonSuccess('获取失败！');
        }
    }

    // 创建权限规则
    public function create()
    {
        $name = 'create-post'; // 规则名称
        $displayName = '创建文章'; // 展示名称
        $description = '创建文章的规则'; // 规则描述
        $permission = new Permission();
        $permission->name         = $name;
        $permission->display_name = $displayName; // optional
        $permission->description  = $description; // optional
        $permission->save();
    }

    // 编辑用户信息
    public function editUser(Request $request)
    {
        $id = $request->input('id');
        if ($request->isMethod('get')) {
            $result = User::where('id',$id)->first();
            if ($result) {
                return Helper::jsonSuccess('获取成功！','',$result);
            } else {
                return Helper::jsonError('获取失败，请重试！');
            }
        } elseif ($request->isMethod('post')) {
            $data['name'] = $request->input('name');
            $data['email'] = $request->input('email');
            $password = $request->input('password');

            if(!empty($password)) {
                $data['password'] = bcrypt($password);
            }

            $result = User::where('id',$id)->update($data);
            if ($result) {
                return Helper::jsonSuccess('操作成功！');
            } else {
                return Helper::jsonError('操作失败！');
            }
        }
    }

    // 设置状态
    public function setStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        if(empty($id)) {
            $selection = $request->input('selection');
            foreach ($selection as $key => $value) {
                $ids[] = $value['id'];
            }
            if($status == -1) {
                $result = User::whereIn('id',$ids)->delete();
            } else {
                $result = User::whereIn('id',$ids)->update(['status'=>$status]);
            }
        } else {
            if($status == -1) {
                $result = User::where('id',$id)->delete();
            } else {
                $result = User::where('id',$id)->update(['status'=>$status]);
            }
        }

        if ($result) {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    public function test()
    {
        $username = 'administrator';
        $user = User::where('name',$username)->first();
        dump($user->can('create-post'));
    }

}