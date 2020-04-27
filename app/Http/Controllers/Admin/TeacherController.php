<?php


namespace app\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * @method 教师列表
     * @param Request $request
     */
    public function teacherList(Request $request){
        $data = DB::table('user')->where(['category' => 3])->paginate(10);
        return view('admin/teacher/users', ['list' => $data]);
    }

    /**
     * @method 添加教师
     * @param Request $request
     */
    public function teacherAdd(Request $request){
        if ($request->isMethod('POST')) {
            //接收教师信息
            $data = $request->all();
                 //表单验证
            if($data['sid']==null||$data['sid']=="")
            {
                $data=[
                    'status'=>1,
                    'message'=>'请输入工号！'
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
                    'message'=>'该教师已存在'
                ];
                return $data;
            }
            /*添加操作*/
             $datas = [
                'create_time' => time()
            ];
            //md5加密密码
            $data['passwd'] = md5($data['passwd']);
            /*合并数组*/
            $data = array_merge($data, $datas);
            /*添加*/
            $res = DB::table('user')->insert($data);
            
            //返回添加结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'添加教师成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'添加教师失败'
                ];

            }
            return $data;
        }
        return view('admin/teacher/usere');
    }
    /**
     * @method 编辑教师
     * @param Request $request
     */
    public function teacherEdit(Request $request){
        if ($request->isMethod('POST')) {
            //接收教师信息
            $data = $request->all();
            //更新操作
            $data = array_map('trim', $data);
            $datas = [
                'create_time' => time()
            ];
            /*合并数组*/
            $data = array_merge($data, $datas);
            /*比较数组取差值*/
            $datass = array_diff_key($data,['sid' => $data['sid']]);
            /*更新*/
            $res = DB::table('user')->where(['sid' => $data['sid']])->update($datass);
            //返回编辑结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'编辑教师成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'编辑教师失败'
                ];

            }
            return $data;
        }
        $oexist = DB::table('user')->where(['sid' => $request->input('sid')])->first();
        return view('admin/teacher/usera', ['one' => $oexist]);
    }
    /**
     * @method 教师删除
     * @param Request $request
     */
    public function teacherDelete(Request $request){
        if ($request->isMethod('GET')) {
            //获取教师id
            $data = $request->all();
            //删除
            $res = DB::table('user')->where(['sid' => $data['sid']])->delete();
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'删除教师成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'删除教师失败'
                ];

            }
            return $data;
        }
    }
     /**
     * @method 查找教师
     * @param Request $request
     */
    public function teacherFind(Request $request){
       if ($request->isMethod('post')) {
           //获取查找教师的教师名
            $data=$request->input('findusername');
            //连接数据库查找
            $datas=DB::table('user')->where(['username'=>$data])->first();
            if(!$datas){
               return redirect('/teacher')->with('errors','查无此教师！！！！！');
              
            }else{
                
                $datass=DB::table('user')->where(['username'=>$data])->paginate(10);
                return view('admin/teacher/users',['list' => $datass]);

            }
       }
    }
}