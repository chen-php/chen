<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
	/**
     * @method 学生个人信息列表
     * @param Request $request
     */
	public function studentList(Request $request){
        $data = DB::table('user')->where(['sid' => session('sid'),'category'=>2])->paginate(10);
        return view('student/people/users', ['list' => $data]);
    }
	 /**
     * @method 学生个人信息编辑
     * @param Request $request
     */
    public function studentEdit(Request $request){
        if ($request->isMethod('POST')) {
        	//接收信息
            $data = $request->all();
            //dd($data);
			//更新操作
			/*回调，修剪没有必要的空格*/
            $data = array_map('trim', $data);
            $datas = [
                'create_time' => time(),
                'category' => 2
            ];
			/*合并两个数组*/
            $data = array_merge($data, $datas);
			/*比较两数组的键名 ，并返回差集。*/
            $datass = array_diff_key($data, ['sid' => $data['sid']]);
		    $res = DB::table('user')->where(['sid' => $data['sid'],'category'=>2])->update($datass);
		    //返回更新结果
            if ($res) {
                $data=[
                	'status'=>0,
                	'message'=>'修改个人信息成功'
                ];
            } else {
                $data=[
                	'status'=>1,
                	'message'=>'修改个人信息失败'
                ];
            }
            return $data;
        }
        $oexist = DB::table('user')->where(['sid' => $request->input('sid')])->first();
        return view('student/people/usera', ['one' => $oexist]);
    }
	/**
     * @method 学生个人成绩列表
     * @param Request $request
     */
	public function studentExamList(Request $request){
		$data = DB::table('score')->where(['xid'=>session('sid')])->paginate(10);
		$list = $data->all();
		/*获取学生成绩数组中的所有属性*/
		$list = array_map('get_object_vars', $list);
		/*遍历数组*/
        foreach ($list as $k=>$v) {
            $list[$k]['kname'] = DB::table('subject')->where(['id' => $v['sid']])->value('sname');
			$list[$k]['term'] = DB::table('subject')->where(['id' => $v['sid']])->value('term');
			$list[$k]['schoolyear'] = DB::table('subject')->where(['id' => $v['sid']])->value('schoolyear');
        }
		$subject = DB::table('subject')->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('student/exam/users', ['list' => $list, 'data' => $data,'subject' => $subject]);
    }
	/**
     * @method 学生个人课程列表
     * @param Request $request
     */
	 public function studentSubjectList(Request $request){
        $data = DB::table('subject')->orderBy('schoolyear','asc')->orderBy('term','asc')->paginate(10);
		$list = $data->all();
		/*获取学生课程数组中的所有属性*/
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
            $list[$k]['tname'] = DB::table('user')->where(['sid' => $v['tid']])->value('username');
        }
        return view('student/subject/users', ['list' => $list, 'data' => $data]);
    }
	/**
     * @method 学生个人成绩列表按学年查询
     * @param Request $request
     */
	 public function studentChooseYear(Request $request){
		 
		  if ($request->isMethod('get')) {
			$datas=$request->all();
			$schoolyear=$datas['schoolyear'];
			//成绩存在判断
			$choose=DB::table('score')->where(['xid'=>session('sid'),'schoolyear'=>$schoolyear])->get();
			if(!($choose->first()))
			{
				return redirect('/student/studentExamList')->with('errors','你在该时间段内还暂时没有成绩！！');
			}	
			else{
				$data = DB::table('score')->where(['xid'=>session('sid'),'schoolyear'=>$schoolyear])->paginate(10);
				$list = $data->all();
				/*获取学生成绩数组中的所有属性*/
			    $list = array_map('get_object_vars', $list);
			    foreach ($list as $k=>$v) {
				$list[$k]['kname']=DB::table('subject')->where(['id'=>$v['sid']])->value('sname');
				}
				$schoolyears=$request->input('schoolyear');
				$subject = DB::table('subject')->get()->map(function ($value) { return (array) $value; })->toArray();
				return view('student/exam/usera', ['list' => $list, 'data' => $data, 'subject' => $subject,'schoolyear'=>$schoolyears]);
		  }
		  
		  }
		  
	 }
	 /**
     * @method 学生个人成绩列表按科目查询
     * @param Request $request
     */
	 public function studentChooseSubject(Request $request){
		if ($request->isMethod('get')) {
			$datas=$request->all();
			//学生成绩存在判断
			$exist=DB::table('score')->where(['sid'=>$datas['subject'],'xid'=>session('sid')])->get();
			if(!($exist->first()))
			{
				return redirect('/student/studentExamList')->with('errors','你该科目还暂时没有成绩！！');
			}
			else
			{
			 $data=DB::table('subject')->where(['id'=>$datas['subject']])->paginate(10);
			 $list = $data->all();
			 /*获取学生成绩数组中的所有属性*/
			  $list = array_map('get_object_vars', $list);
			  foreach ($list as $k=>$v) {
		         $list[$k]['kname']=DB::table('subject')->where(['id'=>$v['id']])->value('sname');
				$list[$k]['score']=DB::table('score')->where(['sid'=>$v['id']])->value('score');
				$list[$k]['gpa']=DB::table('score')->where(['sid'=>$v['id']])->value('gpa');
				}
				$subject = DB::table('subject')->get()->map(function ($value) { return (array) $value; })->toArray();
				return view('student/exam/usere', ['list' => $list, 'data' => $data, 'subject' => $subject]);
	    }
	 }
	 
	 }
	 /**
     * @method 学生教评列表
     * @param Request $request
     */
	  public function studentTeachList(Request $request){
	   if($request->isMethod('post')){
		$datas=$request->all();
		$data = DB::table('subject')->where(['schoolyear' =>$datas['schoolyear'],'term'=>$datas['term']])->paginate(10);
		//课程存在判断
		if(!($data->first()))
		{
			 return redirect('/student/studentTeachList')->with('errors','在此时间段内暂时没有课程！！！');
		}
		$list = $data->all();
		//取课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'sid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear=$datas['schoolyear'];
		$terms=$datas['term'];
		//根据学年跳转界面
		switch($schoolyear){
			case '2016-2017':
			 return view('student/teach/users1617', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
			case '2017-2018':
			 return view('student/teach/users1718', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
			case '2018-2019':
			 return view('student/teach/users1819', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
			case '2019-2020':
			 return view('student/teach/users1920', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
		}
		
	  }
	       return view('student/teach/test');
	  }
	   /**
     * @method 学生1617教评页面1
     * @param Request $request
     */
	  public function studentTeachLists(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2016-2017','term'=>1])->paginate(10);
		$list = $data->all();
		//获取1617学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'sid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2016-2017';
		$terms=1;
		return view('student/teach/users1617', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	   /**
     * @method 学生1617教评页面2
     * @param Request $request
     */
	  public function studentTeachListes(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2016-2017','term'=>2])->paginate(10);
		$list = $data->all();
		//获取1617学年2学期课程的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'sid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2016-2017';
		$terms=2;
		return view('student/teach/users1617', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	     /**
     * @method 学生1718教评页面1
     * @param Request $request
     */
	  public function studentTeachListss(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2017-2018','term'=>1])->paginate(10);
		$list = $data->all();
		//获取1718学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'sid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2017-2018';
		$terms=1;
		return view('student/teach/users1718', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	     /**
     * @method 学生1718教评页面2
     * @param Request $request
     */
	  public function studentTeachListess(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2017-2018','term'=>2])->paginate(10);
		$list = $data->all();
		//获取1718学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'sid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2017-2018';
		$terms=2;
		return view('student/teach/users1718', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	     /**
     * @method 学生1819教评页面1
     * @param Request $request
     */
	  public function studentTeachListsss(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2018-2019','term'=>1])->paginate(10);
		$list = $data->all();
		//获取1819学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'sid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2018-2019';
		$terms=1;
		return view('student/teach/users1819', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	     /**
     * @method 学生1819教评页面2
     * @param Request $request
     */
	  public function studentTeachListesss(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2018-2019','term'=>2])->paginate(10);
		$list = $data->all();
		//获取1819学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'sid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2018-2019';
		$terms=2;
		return view('student/teach/users1819', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	    /**
     * @method 学生1920教评页面1
     * @param Request $request
     */
	  public function studentTeachListssss(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2019-2020','term'=>1])->paginate(10);
		$list = $data->all();
		//获取1920学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'sid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2019-2020';
		$terms=1;
		return view('student/teach/users1920', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	     /**
     * @method 学生1920教评页面2
     * @param Request $request
     */
	  public function studentTeachListessss(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2019-2020','term'=>2])->paginate(10);
		$list = $data->all();
		//获取1920学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'sid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2019-2020';
		$terms=2;
		return view('student/teach/users1920', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	  /**
     * @method 学生教评中转
     * @param Request $request
     */
	 public function studentTeachA(Request $request){
		  if ($request->isMethod('get')) {
			  //获取评价选择内容
            $data = $request->all();
			$mid=$request->input('mid');
			$exist = DB::table('pscore')->where(['sid' => session('sid'), 'tid' =>$data['tid'],'mid'=>$mid])->get();
			//dd($exist->first());
           if ($exist->first()) {
               return redirect('/student/studentTeachList')->with('errors','你已经评教过该老师！！！');
            }
        }
		$terms=$request->input('term',0);
		$schoolyears=$request->input('schoolyear',0);
        $cid = $request->input('tid', 0);
		$mid=$request->input('mid',0);
        $comment = DB::table('comment')->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('student/teach/usere', ['comment' => $comment, 'tid' => $cid, 'mid'=>$mid,'term'=>$terms,'schoolyear'=>$schoolyears]);
	 }
	 
	 /**
     * @method 学生教评
     * @param Request $request
     */
	 public function studentTeach(Request $request){
		  if ($request->isMethod('post')) {
		  	//接收评教信息
            $data = $request->all();
            //dd($data);
            //评教操作
            $t1=$data['score'][0];
            $t2=$data['score'][1];
            $t3=$data['score'][2];
            $datas = [
                'create_time' => time(),
				'category'=>2,
				'mid'=>$request->input('mid'),
				'schoolyear'=>$request->input('schoolyear'),
				'term'=>$request->input('term'),
				't1'=>$t1,
                't2'=>$t2,
                't3'=>$t3
				
			];
			//计算总分数
            $data['tscore'] = array_sum($data['score']);
			$data['sid'] = session('sid');
			//合并数组
			$data = array_merge($data, $datas);
			//比较键名取差值
            $datass = array_diff_key($data, ['score' => $data['score']]);
            $res = DB::table('pscore')->insert($datass);
            if ($res) {
				$data=[
					'status'=>0,
					'message'=>'评教成功'
				];
            } else {
               $data=[
					'status'=>1,
					'message'=>'评教失败'
				]; 
            }
			return $data;
        }
        $terms=$request->input('term',0);
		$schoolyears=$request->input('schoolyear',0);
        $cid = $request->input('tid', 0);
		$mid=$request->input('mid',0);
        $comment = DB::table('comment')->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('student/teach/usere', ['comment' => $comment, 'tid' => $cid, 'mid'=>$mid,'term'=>$terms,'schoolyear'=>$schoolyears]);
}
	 
    
}

    
