<?php

namespace App\Http\Controllers\Center;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Helper;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    // 获取登录的用户信息
    public function getUserInfo()
    {
        // 获取当前用户登录的信息
        $userInfo  = Auth::user();
        if(!empty($userInfo)) {
            return $userInfo;
        } else {
            return '无法获取数据';
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
}