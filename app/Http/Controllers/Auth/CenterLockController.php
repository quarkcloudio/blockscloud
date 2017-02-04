<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Services\Helper;

class CenterLockController extends Controller
{

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
     * 用户锁屏
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function lock(Request $request)
    {
        session(['lock' => '1']);
    }

    /**
     * 用户解锁屏幕
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function unlock(Request $request)
    {
        if($request->isMethod('post')){
            $username = $request->input('username');
            $password = $request->input('password');
            if (Auth::guard('center')->attempt(['name' => $username, 'password' => $password])) {
                session(['lock' => '0']);
                return Helper::jsonSuccess('解锁成功');
            } else {
                return Helper::jsonError('密码错误，请重试！');
            }
        }
    }

    /**
     * 用户锁屏状态
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function lockStatus(Request $request)
    {
        $result = session('lock');
        return Helper::jsonSuccess('获取成功','',$result);
    }

}
