<?php


namespace app\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * @method 学生列表
     * @param Request $request
     */
    public function studentList(Request $request){
        $data = DB::table('user')->where(['category' => 2])->paginate(10);
        return view('admin/student/users', ['list' => $data]);
    }

    /**
     * @method 添加学生
     * @param Request $request
     */
    public function studentAdd(Request $request){
        if ($request->isMethod('POST')) {
            //接收信息
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
            if($data['profession']==null||$data['profession']=="")
            {
                $data=[
                    'status'=>1,
                    'message'=>'请输入专业！'
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
                    'message'=>'该学生已存在'
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
                    'message'=>'添加学生成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'添加学生失败'
                ];

            }
            return $data;
        }
        return view('admin/student/usere');
    }
	
    /**
     * @method 编辑学生
     * @param Request $request
     */
    public function studentEdit(Request $request){
        if ($request->isMethod('POST')) {
            //接收学生信息
            $data = $request->all();
            //更新操作
            /*回调，修剪没必要的空格*/
            $data = array_map('trim', $data);
            $datas = [
                'create_time' => time()
            ];
            /*合并数组*/
            $data = array_merge($data, $datas);
            /*比较数组取差值*/
            $datass = array_diff_key($data, ['sid' => $data['sid']]);
            /*更新*/
            $res = DB::table('user')->where(['sid' => $data['sid']])->update($datass);
            //返回编辑结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'编辑学生成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'编辑学生失败'
                ];

            }
            return $data;
        }
        $oexist = DB::table('user')->where(['sid' => $request->input('sid')])->first();
        return view('admin/student/usera', ['one' => $oexist]);
    }
    /**
     * @method 学生删除
     * @param Request $request
     */
    public function studentDelete(Request $request){
        if ($request->isMethod('GET')) {
            //获取删除学生的id
            $data = $request->all();
            //删除
            $res = DB::table('user')->where(['sid' => $data['sid']])->delete();
          if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'删除学生成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'删除学生失败'
                ];

            }
            return $data;
        }
    }
    /**
     * @method 查找学生
     * @param Request $request
     */
    public function studentFind(Request $request){
       if ($request->isMethod('post')) {
           //获取查找学生的姓名
            $data=$request->input('findusername');
            //查询数据库
            $datas=DB::table('user')->where(['username'=>$data])->first();
            if(!$datas){
               return redirect('/student')->with('errors','查无此学生！！！！！');
              
            }else{
                
                $datass=DB::table('user')->where(['username'=>$data])->paginate(10);
                return view('admin/student/users',['list' => $datass]);

            }
       }
    }
}