<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Helper;
use Illuminate\Http\Request;
use App\User;

class RoleController extends Controller
{

    // 获取用户列表
    public function getLists(Request $request)
    {
        // 获取当前页码
        $page      = $request->input('page');
        $name      = $request->input('name');

        $query = User::query();
        $query = $query->skip(($page-1)*10)->take(10)->where('status', '<>', -1);
        $totalQuery = $query->where('status', '<>', -1);
        if($name) {
            $query = $query->where('name',$name);
            $totalQuery = $totalQuery->where('name',$name);
        }
        $userLists = $query->get();
        $total     = $totalQuery->count();

        if($userLists) {
            $data['lists'] = $userLists;
            $data['total'] = $total;
            return Helper::jsonSuccess('获取成功！','',$data);
        } else {
            return Helper::jsonSuccess('获取失败！');
        }
    }

    // 创建用户组
    public function createRole()
    {
        $name = 'editor'; // 角色名称
        $displayName = '编辑'; // 展示名称
        $description = '网站的编辑人员'; // 角色描述

        $role = new Role();
        $role->name         = $name;
        $role->display_name = $displayName; // optional
        $role->description  = $description; // optional
        $role->save();
    }

    // 将用户给予用户组
    public function userAddRole()
    {
        $roleId = 1; // 角色id
        $username = 'administrator';
        $user = User::where('name',$username)->first();
        $user->roles()->attach($roleId);
    }

}