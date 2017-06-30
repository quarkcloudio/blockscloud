<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Helper;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\RoleUser;
use Validator;
use DB;

class UserController extends CommonController
{

    protected function validator(array $data)
    {
        $messages = [
            'name.required' => '用户名必须填写！',
            'name.unique' => '用户名已经被注册！',
            'email.required' => '邮箱必须填写！',
            'email.email' => '邮箱格式不正确！',
            'email.unique' => '邮箱已经被注册！',
            'password.required' => '密码必须填写！',
            'password.min' => '密码必须大于6位！',
        ];
        return Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ],$messages);
    }

    // 获取列表
    public function index(Request $request)
    {
        // 获取当前页码
        $page      = $request->input('page');
        $name      = $request->input('name');

        $query = User::query()->skip(($page-1)*10)->take(10)->where('status', '<>', -1)->orderBy('created_at', 'desc');
        $totalQuery = User::query()->where('status', '<>', -1);
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

    // 获取信息
    public function info()
    {
        // 获取当前用户登录的信息
        $userInfo  = Auth::user();
        if($userInfo['status'] != 1) {
            return '用户被禁用或删除！';
        }
        if(!empty($userInfo)) {
            return $userInfo;
        } else {
            return '无法获取数据';
        }
    }

    // 添加信息
    public function store(Request $request)
    {
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['password'] = $request->input('password');
        $uuid = Helper::createUuid();

        $validatorMsg = $this->validator($data);
        if ($validatorMsg->fails()) {
            return Helper::jsonError($validatorMsg->errors()->first());
        }

        $result = User::create([
            'uuid' => $uuid,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        if ($result) {
            // 初始化dock
            DB::table('docks')->insert([
                [
                    'uid' => $result->id,
                    'app_id' => 3,
                    'sort' => 0
                ],
                [
                    'uid' => $result->id,
                    'app_id' => 4,
                    'sort' => 1
                ],
                [
                    'uid' => $result->id,
                    'app_id' => 6,
                    'sort' => 2
                ],
                [
                    'uid' => $result->id,
                    'app_id' => 13,
                    'sort' => 3
                ],
            ]);
            // 初始化壁纸
            $keyValue['wallpaper'] = 1;
            DB::table('key_values')->insert([
                [
                    'collection' => 'users.wallpaper',
                    'uuid' => $uuid,
                    'data' => json_encode($keyValue),
                ]
            ]);
            // 初始化桌面文件
            Helper::makeDir(Helper::appToSystemChar(storage_path('app/public/user/').$data['name']));
            Helper::copyFileToDir(Helper::appToSystemChar(storage_path('app/public/desktop/home/')),Helper::appToSystemChar(storage_path('app/public/user/').$data['name']));
            Helper::copyFileToDir(Helper::appToSystemChar(storage_path('app/public/desktop/recycle/')),Helper::appToSystemChar(storage_path('app/public/user/').$data['name']));

            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    // 编辑信息
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $result = User::where('id',$id)->first();
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

    // 设置状态
    public function setStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        if($status == -1) {
            $result = User::where('id',$id)->delete();
        } else {
            $result = User::where('id',$id)->update(['status'=>$status]);
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
            $result = User::whereIn('id',$ids)->delete();
        } else {
            $result = User::whereIn('id',$ids)->update(['status'=>$status]);
        }

        if ($result) {
            return Helper::jsonSuccess('操作成功！');
        } else {
            return Helper::jsonError('操作失败！');
        }
    }

    public function changePassword(Request $request)
    {
        if($request->isMethod('post')){
            $oldPassword = $request->input('oldPassword');
            $newPassword = $request->input('newPassword');

            if(empty($newPassword) || strlen($newPassword)<6) {
                return Helper::jsonError('密码不能为空且须大于6为！');
            }

            $userInfo  = Auth::user();
            if (!Auth::guard('center')->attempt(['name' => $userInfo['name'], 'password' => $oldPassword])) {
                return Helper::jsonError('原密码错误！');
            }
            $where['name']      = $userInfo['name'];
            $result = User::where($where)->update(['password'=>bcrypt($newPassword)]);
            if ($result) {
                return Helper::jsonSuccess('修改成功！');
            } else {
                return Helper::jsonError('修改失败，请重试！');
            }
        }
    }

    // 获取列表
    public function roles(Request $request)
    {
        $userId = $request->input('id');
        $checkedRoles = [];
        $roleLists = Role::query()->orderBy('created_at', 'asc')->get();
        $roleUser = RoleUser::query()->where('user_id',$userId)->get();
        foreach ($roleLists as $key => $value) {
            $lists[] = $value['display_name'];
        }
        foreach ($roleUser as $key => $value) {
            $roleInfo = Role::query()->where('id',$value['role_id'])->orderBy('created_at', 'asc')->first();
            $checkedRoles[] = $roleInfo->display_name;
        }
        if($lists) {
            $data['lists'] = $lists;
            $data['checkedRoles'] = $checkedRoles;
            return Helper::jsonSuccess('获取成功！','',$data);
        } else {
            return Helper::jsonSuccess('获取失败！');
        }
    }

    // 将用户给予用户组
    public function assignRole(Request $request)
    {
        $id = $request->input('id');
        $roles = $request->input('roles');

        // 先清除
        RoleUser::where('user_id',$id)->delete();
        $user = User::where('id',$id)->first();

        if($roles) {
            foreach ($roles as $key => $value) {
                $roleInfo = Role::query()->where('display_name',$value)->first();
                $userResult = $user->roles()->attach($roleInfo->id);
            }
        }

        return Helper::jsonSuccess('操作成功！');

    }
}