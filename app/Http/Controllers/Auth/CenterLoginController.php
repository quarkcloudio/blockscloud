<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Services\Helper;

class CenterLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * 用户退出方法
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function logout()
    {
        $result = Auth::guard('center')->logout();
        return Helper::jsonSuccess('退出成功','./login.html');
    }

    /**
     * 用户登录方法
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function login(Request $request)
    {
        if($request->isMethod('post')){
            $username = $request->input('username');
            $password = $request->input('password');
            if (Auth::guard('center')->attempt(['name' => $username, 'password' => $password])) {
                session(['lock' => '0']);
                return Helper::jsonSuccess('登录成功','./index.html');
            } else {
                return Helper::jsonError('用户名或密码错误！');
            }
        }
    }

}
