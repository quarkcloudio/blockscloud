<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Helper;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Permission;
use App\PermissionRole;

class RoleController extends Controller
{

    // 获取列表
    public function index(Request $request)
    {
        // 获取当前页码
        $page      = $request->input('page');
        $name      = $request->input('name');

        $query = Role::query()->skip(($page-1)*10)->take(10)->orderBy('created_at', 'desc');
        $totalQuery = Role::query();
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
    public function store(Request $request)
    {

        $name      = $request->input('name');
        $displayName = $request->input('display_name');
        $description = $request->input('description');

        $role = new Role();
        $role->name         = $name;
        $role->display_name = $displayName; // optional
        $role->description  = $description; // optional
        $result = $role->save();

        if ($result) {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败，请重试！');
        }
    }

    // 编辑信息
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $result = Role::where('id',$id)->first();
        if ($result) {
            return Helper::jsonSuccess('获取成功！','',$result);
        } else {
            return Helper::jsonError('获取失败，请重试！');
        }
    }

    // 更新编辑信息
    public function update(Request $request)
    {
        $id = $request->input('id');
        $data['name'] = $request->input('name');
        $data['display_name'] = $request->input('display_name');
        $data['description'] = $request->input('description');

        $result = Role::where('id',$id)->update($data);
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
            $result = Role::where('id',$id)->delete();
        } else {
            $result = Role::where('id',$id)->update(['status'=>$status]);
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
            $result = Role::whereIn('id',$ids)->delete();
        } else {
            $result = Role::whereIn('id',$ids)->update(['status'=>$status]);
        }

        if ($result) {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }


    // 获取列表
    public function permissions(Request $request)
    {
        $id = $request->input('id');
        $checkedRoles = [];
        $lists = [];
        $checkedPermissions = [];
        $permissionLists = Permission::query()->orderBy('created_at', 'asc')->get();
        $permissionRole = PermissionRole::query()->where('role_id',$id)->get();

        if(!empty($permissionLists)) {
            foreach ($permissionLists as $key => $value) {
                $lists[] = $value['display_name'];
            }
        }
        if(!empty($permissionRole)) {
            foreach ($permissionRole as $key => $value) {
                $permissionInfo = Permission::query()->where('id',$value['permission_id'])->first();
                if(!empty($permissionInfo)) {
                    $checkedPermissions[] = $permissionInfo->display_name;
                }
            }
        }

        if(!empty($lists)) {
            $data['lists'] = $lists;
            $data['checkedPermissions'] = $checkedPermissions;
            return Helper::jsonSuccess('获取成功！','',$data);
        } else {
            return Helper::jsonSuccess('获取失败！');
        }
    }

    // 将权限规则给予用户组
    public function assignPermission(Request $request)
    {
        $id = $request->input('id');
        $permissions = $request->input('permissions');

        $role = Role::findOrFail($id);
        // 先清除
        PermissionRole::where('role_id',$id)->delete();

        if($permissions) {
            foreach ($permissions as $key => $value) {
                $permissionInfo = Permission::query()->where('display_name',$value)->first();
                $role->perms()->sync(array($permissionInfo->id));
            }
        }

        return Helper::jsonSuccess('操作成功！');
    }

}