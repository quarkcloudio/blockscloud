<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use App\User;

class PermissionsController extends Controller
{
    // 创建权限规则
    public function createPermission()
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

    // 将权限规则给予用户组
    public function permissionAddRole()
    {
        $permissionId = 1; // 权限id
        $roleId = 1; // 用户组id
        $role = Role::findOrFail($roleId);
        $role->perms()->sync(array($permissionId));
    }

    public function test()
    {
        $username = 'administrator';
        $user = User::where('name',$username)->first();
        dump($user->can('create-post'));
    }

}