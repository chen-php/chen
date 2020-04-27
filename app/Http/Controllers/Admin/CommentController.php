<?php


namespace app\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * @method 评教题目列表
     * @param Request $request
     */
    public function commentList(Request $request){
        $data = DB::table('comment')->paginate(10);
        return view('admin/comment/users', ['list' => $data]);
    }

    /**
     * @method 添加评教题目
     * @param Request $request
     */
    public function commentAdd(Request $request){
        if ($request->isMethod('POST')) {
            //接收题目信息
            $data = $request->all();
            //题目添加
            /*题目存在判断*/
            $exist = DB::table('comment')->where(['cname' => $data['cname']])->first();
            if (isset($exist->cname) && $exist->cname == $data['cname']) {
                $data=[
                    'status'=>1,
                    'message'=>'该题目已存在'
                ];
                return $data;
            }
            //添加操作
            /*获取当前添加时间*/
            $datas = [
                'create_time' => time()
            ];
            /*合并数组*/
            $datass = array_merge($data, $datas);
            /*添加*/
            $res = DB::table('comment')->insert($datass);
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'添加题目成功'
                ];
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'添加题目失败'
                ];
            }
            return $data;
        }
        return view('admin/comment/usere');
    }
    /**
     * @method 编辑评教题目
     * @param Request $request
     */
    public function commentE(Request $request){
        if ($request->isMethod('POST')) {
            //获取题目信息
            $data = $request->all();
            //更新操作
            /*回调，修剪掉一些没有必要的空格*/
            $data = array_map('trim', $data);
            /*获取时间*/
            $datas = [
                'create_time' => time()
            ];
            /*合并数组*/
            $data = array_merge($data, $datas);
            /*使用键名比较数组取差集*/ 
            $datass = array_diff_key($data, ['id' => $data['id']]);
            /*更新*/
            $res = DB::table('comment')->where(['id' => $data['id']])->update($datass);
            //返回编辑结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'编辑题目成功'
                ];
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'编辑题目失败'
                ];
            }
            return $data;
        }
        $oexist = DB::table('comment')->where(['id' => $request->input('id')])->first();
        return view('admin/comment/usera', ['one' => $oexist]);
    }
    /**
     * @method 评教题目删除
     * @param Request $request
     */
    public function commentDelete(Request $request){
        if ($request->isMethod('GET')) {
            //获取题目id
            $data = $request->input('id');
            //删除操作
            $res = DB::table('comment')->where(['id' => $data])->delete();
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'删除题目成功'
                ];
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'删除题目失败'
                ];
            }
            return $data;
        }
        return view('admin/comment/usera');
    }
}