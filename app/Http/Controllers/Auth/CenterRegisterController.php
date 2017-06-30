<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\Helper;
use DB;

class CenterRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/index.html';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
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

    public function register(Request $request)
    {
        if($request->isMethod('post')){
            $data['name'] = $request->input('username');
            $data['password'] = $request->input('password');
            $data['email'] = $request->input('email');
            $data['uuid'] = Helper::createUuid();

            $validatorMsg = $this->validator($data);
            if ($validatorMsg->fails()) {
                return Helper::jsonError($validatorMsg->errors()->first());
            }
            $result = $this->create($data);
            if ($result) {
                // Authentication passed...
                session(['lock' => '0']);
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
                        'uuid' => $data['uuid'],
                        'data' => json_encode($keyValue),
                    ]
                ]);
                // 初始化用户组
                DB::table('role_user')->insert([
                    [
                        'user_id' => $result->id,
                        'role_id' => 1
                    ]
                ]);
                // 初始化桌面文件
                Helper::makeDir(Helper::appToSystemChar(storage_path('app/public/user/').$data['name']));
                Helper::copyFileToDir(Helper::appToSystemChar(storage_path('app/public/desktop/home/')),Helper::appToSystemChar(storage_path('app/public/user/').$data['name']));
                Helper::copyFileToDir(Helper::appToSystemChar(storage_path('app/public/desktop/recycle/')),Helper::appToSystemChar(storage_path('app/public/user/').$data['name']));
                if (Auth::guard('center')->attempt(['name' => $data['name'], 'password' => $data['password']])) {
                    session(['lock' => '0']);
                    return Helper::jsonSuccess('注册成功，正在登录...','./index.html');
                } else {
                    return Helper::jsonError('自动登录错误！');
                }

            } else {
                return Helper::jsonError('注册失败，请重试');
            }
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'uuid' => $data['uuid'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
