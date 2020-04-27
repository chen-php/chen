<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * @method 登陆
     * @param Request $request
     */
    public function getLogin(Request $request){
     if ($request->isMethod('post')) {
            /*获取登录信息*/
            $data = $request->all();
            /*数据库查询是否有该用户*/
			$admin=DB::table('admin')->where(['uname'=>$data['uname']])->first();
            $user=DB::table('user')->where(['sid' => $data['uname']])->first();
            /*判断是否存在用户，取身份标识*/
			if(!$admin&&!$user)
			{
				return redirect('/login')->with('errors','该用户不存在！！');
			}
			elseif(!$admin&&!empty($user))
			{
				$category=$user->category;
			}
			else
			{
				$category=$admin->category;
            }
            /*通过判断用户登录账号在数据库中表的账号密码做验证，再根据身份标识跳转到相对应的欢迎界面*/
            switch ($category) {
                case 1:
					if($user->passwd!=md5($data['pwd']))
					{
						return redirect('/login')->with('errors','密码错误');
					}
					$request->session()->put('user', $user->username);
                    $request->session()->put('sid', $user->sid);
                    return view('public/base')->with(['errors'],'登录成功');
					break;
                case 2:
					if($user->passwd!=md5($data['pwd']))
					{
						return redirect('/login')->with('errors','密码错误');
					}
					$request->session()->put('student', $user->username);
                    $request->session()->put('sid', $user->sid);
					return view('public/base')->with(['errors'],'登录成功');
					break;
                case 3:
					if($user->passwd!=md5($data['pwd']))
					{
						return redirect('/login')->with('errors','密码错误');
					}
					$request->session()->put('teacher', $user->username);
                    $request->session()->put('sid', $user->sid);
                    return view('public/base')->with(['errors'],'登录成功');
					break;
                case 4:
					if($admin->pwd!=md5($data['pwd']))
					{
						return redirect('/login')->with('errors','密码错误');
					}
					$request->session()->put('admin', $data['uname']);
                    $request->session()->put('id', $admin->id);
                    return view('public/base',['is' => 1])->with(['errors', '登陆成功']);
					break;
					
            }	
        }
        return view('admin/login/login');
    }
    /**
     * @brief 注销登陆
     * @param Request $request
     */
    public function logout(Request $request){
        if ($request->session()->has('admin')) {
            $request->session()->forget('admin');
            $request->session()->forget('id');
            return view('admin/login/login');
        } elseif ($request->session()->has('user')){
            $request->session()->forget('user');
            $request->session()->forget('id');
            return view('admin/login/login');
        } elseif ($request->session()->has('student')) {
            $request->session()->forget('student');
            $request->session()->forget('id');
            return view('admin/login/login');
        } elseif ($request->session()->has('teacher')) {
            $request->session()->forget('teacher');
            $request->session()->forget('id');
            return view('admin/login/login');
        } else {
            return view('admin/login/login');
        }
    }
}