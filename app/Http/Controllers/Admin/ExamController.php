<?php


namespace app\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException; 

class ExamController extends Controller
{
	
    /**
     * @method 成绩列表
     * @param Request $request
     */
    public function examList(Request $request){
        $data = DB::table('score')->paginate(10);
        /*获取前台的所有数据*/
        $list = $data->all();
        /*回调，修剪没必要的空格*/
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
            $list[$k]['uname'] = DB::table('user')->where(['sid' => $v['xid']])->value('username');
            $list[$k]['snumber'] = DB::table('user')->where(['sid' => $v['xid']])->value('sid');
            $list[$k]['kname'] = DB::table('subject')->where(['id' => $v['sid']])->value('sname');
        }
        return view('admin/exam/users', ['list' => $list, 'data' => $data]);
    }

    /**
     * @method 添加成绩
     * @param Request $request
     */
    public function examAdd(Request $request){
        if ($request->isMethod('POST')) {
            //接收成绩信息
            $data = $request->all();
			$teacher=DB::table('subject')->where(['id'=>$data['sid']])->value('tid');
			$schoolyear=DB::table('subject')->where(['id'=>$data['sid']])->value('schoolyear');
			$trem=DB::table('subject')->where(['id'=>$data['sid']])->value('term');
			$gpa=$data['score']/20;
            //添加成绩
            /*成绩存在判断*/
            $exist = DB::table('score')->where(['sid' => $data['sid'], 'xid' => $data['xid']])->first();
            if (isset($exist->sid) && $exist->sid == $data['sid']) {
                $data=[
                    'status'=>1,
                    'message'=>'该学生成绩已存在！'
                ];
                return $data;
            }
            //添加操作
            $datas = [
                'create_time' => time(),
				'tid'=>$teacher,
				'gpa'=>$gpa,
				'schoolyear'=>$schoolyear,
				'term'=>$trem
            ];
            /*合并数组*/
            $datass = array_merge($data, $datas);
            /*添加*/
            $res = DB::table('score')->insert($datass);
            //返回添加结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'添加成绩成功'
                ];
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'添加成绩失败'
                ];
            }
            return $data;
        }
        $student = DB::table('user')->where(['category' => 2])->select('sid', 'username')->get()->map(function ($value) { return (array) $value; })->toArray();
        $subject = DB::table('subject')->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('admin/exam/usere', ['student' => $student, 'subject' => $subject]);
    }
    /**
     * @method 编辑成绩
     * @param Request $request
     */
    public function examEdit(Request $request){
        if ($request->isMethod('POST')) {
            //获取成绩信息
            $data = $request->all();
            //更新操作
			$gpa=$data['score']/20;
            $teacher=DB::table('subject')->where(['id'=>$data['sid']])->value('tid');
            /*回调，修剪没有必要的空格*/
            $data = array_map('trim', $data);
            $datas = [
                'create_time' => time(),
				'gpa'=>$gpa,
                'tid'=>$teacher
            ];
            /*合并数组*/
            $data = array_merge($data, $datas);
            /*更新*/
            $res = DB::table('score')->where(['id' => $data['id']])->update($data);
            //返回编辑结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'编辑成绩成功'
                ];
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'编辑成绩失败'
                ];
            }
            return $data;
        }
        $oexist = DB::table('score')->where(['id' => $request->input('id')])->first();
        $student=DB::table('user')->where(['sid'=>$oexist->xid])->get()->map(function ($value) { return (array) $value; })->toArray();
        $subject=DB::table('subject')->where(['id'=>$oexist->sid])->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('admin/exam/usera', ['one' => $oexist,'student'=>$student,'subject'=>$subject]);
    }
    /**
     * @method 成绩删除
     * @param Request $request
     */
    public function examDelete(Request $request){
        if ($request->isMethod('GET')) {
            //获取成绩id
            $data = $request->input('id');
            //删除
            $res = DB::table('score')->where(['id' => $data])->delete();
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'删除成绩成功' 
                ];
                
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'删除成绩失败'
                ];

            }
            return $data;
        }
    }
  /**
     * @method 成绩查找
     * @param Request $request
     */
    public function examFind(Request $request){
        if($request->isMethod('post')){
            //获取查找学生sid
            $data=$request->input('findsid');
            //数据库查找
            $datas=DB::table('score')->where(['xid'=>$data])->first();
            if(!$datas){
                return redirect('/exam')->with('errors','该学生暂未有科目成绩！');
            }
            else{
                $datass=DB::table('score')->where(['xid'=>$data])->paginate(10);
                $list = $datass->all();
                /*回调，获取list数组中的属性，组成一个新数组*/
                $list = array_map('get_object_vars', $list);
                foreach ($list as $k=>$v) {
                $list[$k]['uname'] = DB::table('user')->where(['sid' => $v['xid']])->value('username');
                $list[$k]['snumber'] = DB::table('user')->where(['sid' => $v['xid']])->value('sid');
                $list[$k]['kname'] = DB::table('subject')->where(['id' => $v['sid']])->value('sname');
                 }
               return view('admin/exam/users', ['list' => $list, 'data' => $data]);
            }
        }
    }
}