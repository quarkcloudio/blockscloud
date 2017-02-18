<?php
namespace App\Http\Middleware;

use Closure;
use Zizaco\Entrust\EntrustFacade as Entrust;
use Route,URL,Auth;

class AuthenticateCenter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard('center')->user()->id == 1){
            return $next($request);
        }
        $previousUrl = URL::previous();
        if(!Auth::guard('center')->user()->can(Route::current()->uri)) {
            $result['msg'] = '无权限！';
            $result['url'] = '';
            $result['status'] = 'error';
            return response()->json($result);
        }
        return $next($request);
    }
}