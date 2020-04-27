<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException; 

class DepartmentController extends Controller
{
    /**
     * @method 部门列表
     * @param Request $request
     */
    public function departmentList(Request $request){
        $data = DB::table('department')->paginate(10);
        return view('admin/department/users',  ['list' => $data]);
    }
    /**
     * @method 添加部门
     * @param Request $request
     */
    public function departmentAdd(Request $request){
        if ($request->isMethod('POST')) {
            //接收部门信息
            $data = $request->all();
			//存在验证
            $exist = DB::table('department')->where(['id' => $data['id']])->first();
            if (isset($exist->id) && $exist->id == $data['id']) {
                $data=[
                    'status'=>1,
                    'message'=>'该部门已存在'
                ];
                return $data;
            }
            /*添加操作*/
            $res = DB::table('department')->insert($data);
            
            //返回添加结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'添加部门成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'添加部门失败'
                ];

            }
            return $data;
        }
        return view('admin/department/usere');
    }
    /**
     * @method 编辑部门
     * @param Request $request
     */
    public function departmentEdit(Request $request){
        if ($request->isMethod('POST')) {
            //接收部门信息
            $data = $request->all();
            //更新操作
            /*回调，修剪不必要的空格*/
            $data = array_map('trim', $data);
            /*使用键名比较数组取差集*/
            $datass = array_diff_key($data, ['id' => $data['id']]);
            /*更新*/
            $res = DB::table('department')->where(['id' => $data['id']])->update($datass);

            //返回编辑结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'编辑部门成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'编辑部门失败'
                ];

            }
            return $data;
        }
        $oexist = DB::table('department')->where(['id' => $request->input('id')])->first();
        return view('admin/department/usera', ['one' => $oexist]);
    }
    /**
     * @method 删除部门
     * @param Request $request
     */
    public function departmentDelete(Request $request){
        if ($request->isMethod('GET')) {
            //获取部门id
            $data = $request->all();
            //删除操作
            $res = DB::table('department')->where(['id' => $data['id']])->delete();
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'删除成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'删除失败'
                ];

            }
            return $data;
        }
    }
     /**
     * @method 查找部门
     * @param Request $request
     */
    public function departmentFind(Request $request){
       if ($request->isMethod('post')) {
           //获取部门id
            $data=$request->input('findusername');
            //数据库查找
            $datas=DB::table('department')->where(['name'=>$data])->first();
            if(!$datas){
               return redirect('/department')->with('errors','查无此部门！！！！！');
              
            }else{
                
                $datass=DB::table('department')->where(['name'=>$data])->paginate(10);
                return view('admin/department/users',['list' => $datass]);

            }
       }
    }
}
