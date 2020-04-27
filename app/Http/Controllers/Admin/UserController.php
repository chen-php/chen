<?php


namespace app\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @method 用户列表
     * @param Request $request
     */
    public function userList(Request $request){
        $data = DB::table('user')->where(['category' => 1])->paginate(10);
        return view('admin/users/users', ['list' => $data]);
    }	

    /**
     * @method 添加用户
     * @param Request $request
     */
    public function userAdd(Request $request){
        if ($request->isMethod('POST')) {
            //接收用户信息
            $data = $request->all();
                 //表单验证
            if($data['sid']==null||$data['sid']=="")
            {
                $data=[
                    'status'=>1,
                    'message'=>'请输入学号！'
                ];
                return $data;
            }
            if($data['username']==null||$data['username']=="")
            {
                $data=[
                    'status'=>1,
                    'message'=>'请输入姓名！'
                ];
                return $data;
            }
            if($data['passwd']==null||$data['passwd']=="")
            {
                $data=[
                    'status'=>1,
                    'message'=>'请输入密码！'
                ];
                return $data;
            }
            if($data['address']==null||$data['address']=="")
            {
                $data=[
                    'status'=>1,
                    'message'=>'请输入籍贯！'
                ];
                return $data;
            }
            if($data['sex']==null||$data['sex']=="")
            {
                $data=[
                    'status'=>1,
                    'message'=>'请输入性别！'
                ];
                return $data;
            }
            //添加用户
            /*用户存在判断*/
            $exist = DB::table('user')->where(['sid' => $data['sid']])->first();
            if (isset($exist->sid) && $exist->sid == $data['sid']) {
                $data=[
                    'status'=>1,
                    'message'=>'该用户已存在'
                ];
                return $data;
            }
            /*添加操作*/
             $datas = [
                'create_time' => time()
            ];
            //md5加密密码
            $data['passwd'] = md5($data['passwd']);
            //合并数组
            $data = array_merge($data, $datas);
            //添加
            $res = DB::table('user')->insert($data);
            
            //返回添加结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'添加领导成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'添加领导失败'
                ];

            }
            return $data;
        }
        return view('admin/users/usere');
    }
    /**
     * @method 编辑用户
     * @param Request $request
     */
    public function userEdit(Request $request){
        if ($request->isMethod('POST')) {
            //接收用户信息
            $data = $request->all();
            //更新操作
            /*回调，修剪没有必要的空格*/
            $data = array_map('trim', $data);
            $datas = [
                'create_time' => time(),
            ];
            /*合并数组*/
            $data = array_merge($data, $datas);
            /*比较数组取差值*/
            $datass = array_diff_key($data, ['id' => $data['id']]);
            /*更新*/
            $res = DB::table('user')->where(['id' => $data['id']])->update($datass);
            //返回编辑结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'编辑领导成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'编辑领导失败'
                ];

            }
            return $data;
        }
        $oexist = DB::table('user')->where(['id' => $request->input('id')])->first();
        return view('admin/users/usera', ['one' => $oexist]);
    }
    /**
     * @method 用户删除
     * @param Request $request
     */
    public function userDelete(Request $request){
        if ($request->isMethod('GET')) {
            //获取id
            $data = $request->input('id');
            //删除
            $res = DB::table('user')->where(['id' => $data])->delete();
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'删除领导成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'删除领导失败'
                ];

            }
            return $data;
        }
    }
    /**
     * @method 查找用户
     * @param Request $request
     */
    public function userFind(Request $request){
       if ($request->isMethod('post')) {
           //获取查找的用户名
            $data=$request->input('findusername');
            //连接数据库查找
            $datas=DB::table('user')->where(['username'=>$data])->first();
            if(!$datas){
               return redirect('/user')->with('errors','查无此人！！！！！');
              
            }else{
                
                $datass=DB::table('user')->where(['username'=>$data])->paginate(10);
                return view('admin/users/users',['list' => $datass]);

            }
       }
    }
}