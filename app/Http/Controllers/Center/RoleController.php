<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Helper;
use Illuminate\Http\Request;
use App\User;
use App\Role;

class RoleController extends Controller
{

    // 获取列表
    public function index(Request $request)
    {
        // 获取当前页码
        $page      = $request->input('page');
        $name      = $request->input('name');

        $query = Role::query();
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

    // 创建用户组
    public function create()
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

    // 将权限规则给予用户组
    public function permissionAssignRole()
    {
        $permissionId = 1; // 权限id
        $roleId = 1; // 用户组id
        $role = Role::findOrFail($roleId);
        $role->perms()->sync(array($permissionId));
    }

}