<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * @method 教师个人信息列表
     * @param Request $request
     */
	public function teacherList(Request $request){
        $data = DB::table('user')->where(['sid' => session('sid'),'category'=>3])->paginate(10);
        return view('teacher/people/users', ['list' => $data]);
    }
	 /**
     * @method 教师个人信息编辑
     * @param Request $request
     */
    public function teacherEdit(Request $request){
        if ($request->isMethod('POST')) {
            //获取信息
            $data = $request->all();
            //更新操作
            $data = array_map('trim', $data);
            $datas = [
                'create_time' => time(),
                'category' => 3
            ];
			/*合并两个数组*/
            $data = array_merge($data, $datas);
			/*比较两数组的键名 ，并返回差集。*/
            $datass = array_diff_key($data, ['sid' => $data['sid']]);
		    $res = DB::table('user')->where(['sid' => $data['sid'],'category'=>3])->update($datass);
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'编辑成功'
                ];
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'编辑失败'
                ];
            }
            return $data;
        }
        $oexist = DB::table('user')->where(['sid' => $request->input('sid')])->first();
        return view('teacher/people/usera', ['one' => $oexist]);
    }
	 /**
     * @method 教师个人教学科目列表
     * @param Request $request
     */
	public function teacherSubjectList(Request $request){
		$data=DB::table('subject')->where(['tid'=>session('sid')])->orderBy('schoolyear','asc')->paginate(10);
		return view('teacher/subject/users',['list'=>$data]);
	}
	 /**
     * @method 教师学生成绩管理列表
     * @param Request $request
     */
	public function studentExamList(Request $request){
		$data=DB::table('score')->where(['tid'=>session('sid')])->paginate(10);
        $list = $data->all();
        //取教师数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
            $list[$k]['uname'] = DB::table('user')->where(['sid' => $v['xid']])->value('username');
            $list[$k]['snumber'] = DB::table('user')->where(['sid' => $v['xid']])->value('sid');
            $list[$k]['kname'] = DB::table('subject')->where(['id' => $v['sid'],'tid'=>session('sid')])->value('sname');
        }
        return view('teacher/exam/users', ['list' => $list, 'data' => $data]);
		
    }
	/**
     * @method 教师修改学生成绩
     * @param Request $request
     */
	  public function studentexamE(Request $request){
		 if ($request->isMethod('post')) {
            //获取成绩信息
            $data = $request->all();
            //更新操作
			$gpa=$data['score']/20;
            $data = array_map('trim', $data);
            $datas = [
                'create_time' => time(),
				'gpa'=>$gpa
            ];
            //合并数组
            $data = array_merge($data, $datas);
            //比较键名取差值
            $datass = array_diff_key($data, [['xid' => $data['sid']]]);
            $res = DB::table('score')->where(['id' => $data['id']])->update($datass);
            //返回更新结果
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'修改成绩成功'
                ];
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'修改成绩失败'
                ];
            }
            return $data;
			
        }
        $student = DB::table('user')->where(['category' => 2])->select('sid', 'username')->get()->map(function ($value) { return (array) $value; })->toArray();
        $subject = DB::table('subject')->where(['tid'=>session('sid')])->get()->map(function ($value) { return (array) $value; })->toArray();
        $oexist = DB::table('score')->where(['id' => $request->input('id')])->first();
        return view('teacher/exam/usera', ['one' => $oexist, 'student' => $student, 'subject' => $subject]);
    }
	/**
     * @method 教师增加学生成绩
     * @param Request $request
     */
	 public function studentexamA(Request $request){
		  if ($request->isMethod('POST')) {
            //接收成绩信息
            $data = $request->all();
			$schoolyear=DB::table('subject')->where(['id'=>$data['sid']])->value('schoolyear');
			$trem=DB::table('subject')->where(['id'=>$data['sid']])->value('term');
            $gpa=$data['score']/20;
            //回调，修剪没有必要的空格
            $data = array_map('trim', $data);
            //存在验证
            $exist = DB::table('score')->where(['sid' => $data['sid'], 'xid' => $data['xid']])->first();
            if (isset($exist->sid) && $exist->sid == $data['sid']) {
                $data=[
                    'status'=>1,
                    'message'=>'该学生此科目以存在成绩'
                ];
                return $data;
            }
            $datas = [
                'create_time' => time(),
				'tid'=>session('sid'),
				'gpa'=>$gpa,
				'schoolyear'=>$schoolyear,
				'term'=>$trem
            ];
            //合并数组
            $data = array_merge($data, $datas);
            //添加操作
            $res = DB::table('score')->insert($data);
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
        $subject = DB::table('subject')->where(['tid'=>session('sid')])->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('teacher/exam/usere', ['student' => $student, 'subject' => $subject]);
	 }
	  /**
     * @method 成绩删除
     * @param Request $request
     */
    public function examDelete(Request $request){
        if ($request->isMethod('GET')) {
            //获取信息
            $data = $request->all();
            //删除操作
            $res = DB::table('score')->where(['id' => $data['id']])->delete();
            //返回操作结果
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
     * @method 教师教评列表
     * @param Request $request
     */
	 public function teacherTeachList(Request $request){
	   if($request->isMethod('post')){
		$datas=$request->all();
		$data = DB::table('subject')->where([['schoolyear' ,$datas['schoolyear']],['term',$datas['term']],['tid','<>',session('sid')]])->paginate(10);
		if(!($data->first()))
		{
			 return redirect('/teacher/teacherTeachList')->with('errors','在此时间段内暂时没有课程！！！');
		}
        $list = $data->all();
        //取课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'aid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear=$datas['schoolyear'];
        $terms=$datas['term'];
        //根据选择学年跳转界面
		switch($schoolyear){
			case '2016-2017':
			 return view('teacher/teach/users1617', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
			case '2017-2018':
			 return view('teacher/teach/users1718', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
			case '2018-2019':
			 return view('teacher/teach/users1819', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
			case '2019-2020':
			 return view('teacher/teach/users1920', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
		}
	  }
	       return view('teacher/teach/test');
	 }
	   /**
     * @method 教师1617教评页面1
     * @param Request $request
     */
	  public function teacherTeachLists(Request $request){
		$data = DB::table('subject')->where([['schoolyear' ,'2016-2017'],['term',1],['tid','<>',session('sid')]])->paginate(10);
        $list = $data->all();
        //获取1617学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'aid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2016-2017';
		$terms=1;
		return view('teacher/teach/users1617', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	  /**
     * @method 教师1617教评页面2
     * @param Request $request
     */
	  public function teacherTeachListes(Request $request){
		$data = DB::table('subject')->where([['schoolyear' ,'2016-2017'],['term',2],['tid','<>',session('sid')]])->paginate(10);
        $list = $data->all();
        //获取1617学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'aid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2016-2017';
		$terms=2;
		return view('teacher/teach/users1617', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	   /**
     * @method 教师1718教评页面1
     * @param Request $request
     */
	  public function teacherTeachListss(Request $request){
		$data = DB::table('subject')->where([['schoolyear' ,'2017-2018'],['term',1],['tid','<>',session('sid')]])->paginate(10);
        $list = $data->all();
        //获取1718学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'aid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2017-2018';
		$terms=1;
		return view('teacher/teach/users1718', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	  /**
     * @method 教师1718教评页面2
     * @param Request $request
     */
	  public function teacherTeachListess(Request $request){
		$data = DB::table('subject')->where([['schoolyear' ,'2017-2018'],['term',2],['tid','<>',session('sid')]])->paginate(10);
        $list = $data->all();
        //获取1718学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'aid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2017-2018';
		$terms=2;
		return view('teacher/teach/users1718', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	    /**
     * @method 教师1819教评页面1
     * @param Request $request
     */
	  public function teacherTeachListsss(Request $request){
		$data = DB::table('subject')->where([['schoolyear' ,'2018-2019'],['term',1],['tid','<>',session('sid')]])->paginate(10);
        $list = $data->all();
        //获取1819学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'aid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2018-2019';
		$terms=1;
		return view('teacher/teach/users1819', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	    /**
     * @method 教师1819教评页面2
     * @param Request $request
     */
	  public function teacherTeachListesss(Request $request){
		$data = DB::table('subject')->where([['schoolyear' ,'2018-2019'],['term',2],['tid','<>',session('sid')]])->paginate(10);
        $list = $data->all();
        //获取1819学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'aid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2018-2019';
		$terms=2;
		return view('teacher/teach/users1819', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	    /**
     * @method 教师1920教评页面1
     * @param Request $request
     */
	  public function teacherTeachListssss(Request $request){
		$data = DB::table('subject')->where([['schoolyear' ,'2019-2020'],['term',1],['tid','<>',session('sid')]])->paginate(10);
        $list = $data->all();
        //获取1920学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'aid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2019-2020';
		$terms=1;
		return view('teacher/teach/users1920', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	     /**
     * @method 教师1920教评页面2
     * @param Request $request
     */
	  public function teacherTeachListessss(Request $request){
		$data = DB::table('subject')->where([['schoolyear' ,'2019-2020'],['term',2],['tid','<>',session('sid')]])->paginate(10);
        $list = $data->all();
        //获取1920学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'aid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2019-2020';
		$terms=2;
		return view('teacher/teach/users1920', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	 /**
     * @method 教师教评中转
     * @param Request $request
     */
	 public function teacherTeachA(Request $request){
		if ($request->isMethod('get')) {
            $data = $request->all();
            $mid=$request->input('mid');
            //判断是否评教过老师
			$exist = DB::table('pscore')->where(['aid' => session('sid'), 'tid' =>$data['tid'],'mid'=>$mid])->get();
			//dd($exist->first());
           if ($exist->first()) {
               return redirect('/teacher/teacherTeachList')->with('errors','你已经评教过该老师！！！');
            }
        }
		$terms=$request->input('term',0);
		$schoolyears=$request->input('schoolyear',0);
        $cid = $request->input('tid', 0);
		$mid=$request->input('mid',0);
        $comment = DB::table('comment')->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('teacher/teach/usere', ['comment' => $comment, 'tid' => $cid, 'mid'=>$mid,'term'=>$terms,'schoolyear'=>$schoolyears]);
	 }
	  /**
     * @method 教师教评
     * @param Request $request
     */
	 public function teacherTeach(Request $request){
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
				'category'=>3,
				'mid'=>$request->input('mid'),
				'schoolyear'=>$request->input('schoolyear'),
				'term'=>$request->input('term'),
                't1'=>$t1,
                't2'=>$t2,
                't3'=>$t3

            ];
            //计算总得分
            $data['tscore'] = array_sum($data['score']);
            $data['aid'] = session('sid');
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
        return view('teacher/teach/usere', ['comment' => $comment, 'tid' => $cid, 'mid'=>$mid,'term'=>$terms,'schoolyear'=>$schoolyears]);
	 }
	 /**
     * @method 教师学生教评查看
     * @param Request $request
     */
	 public function teacherTeachL(Request $request){
         /*取相同工号的教师的得分信息集合*/
        $datas=DB::table('pscore')->where(['category'=>2])->orderBy('tid','asc')->get()->map(function ($value) { return (array) $value; })->toArray();
        $datass=DB::table('pscore')->where(['category'=>2])->groupby('tid')->pluck('tid');
        /*计算教师学生评教总得分*/
        $result = [];
        foreach ($datas as $item) {
            isset($result[$item['tid']]) || $result[$item['tid']] = 0;
            $result[$item['tid']] += $item['tscore'];
        }
        /*降序排序*/
        arsort($result);
        /*取成绩，工号排新二维数组*/
        foreach ($result as $key=>$value) {
            $t=$key;
            $arr[][$t]=$value;
         }
         $tid=session('sid')/1;
         /*遍历二维数组，找出登录教师的排名*/
         foreach ($arr as $y => $va) {
            foreach ($va as $ke => $val) {
               if($ke==$tid)
               {
                $p=$y+1;
               }
            }
           
         }
        $data=DB::table('pscore')->where(['tid'=>session('sid'),'category'=>2])->get();
        $len=count($data);
        if($len==0){
            return redirect('/teacher/xinxi')->with('errors','暂未有学生评价，请耐心等待！！');
        }
        else{
        for($i=0,$count1=0,$test1=0;$i<$len;$i++)//计算题目1得分大于8的条数
        {
            $t1=$data[$i]->t1;
            $test1=$test1+$t1;
            if($t1>8){
                $count1++;
            }
        }
           for($i=0,$count2=0,$test2=0;$i<$len;$i++)//计算题目2得分大于8的条数
        {
            $t2=$data[$i]->t2;
            $test2=$test2+$t2;
            if($t2>8){
                $count2++;
            }
        }
           for($i=0,$count3=0,$test3=0;$i<$len;$i++)//计算题目3得分大于8的条数
        {
            $t3=$data[$i]->t3;
            $test3=$test3+$t3;
            if($t3>8){
                $count3++;
            }
        }
    }
        //计算题目得分占比率
        $zhanbi1=sprintf("%.2f",$test1/($len*10));
        $zhanbi2=sprintf("%.2f",$test2/($len*10));
        $zhanbi3=sprintf("%.2f",$test3/($len*10));
        //计算题目好评率
        $thao1=sprintf("%.2f",$count1/$len);
        $thao2=sprintf("%.2f",$count2/$len);
        $thao3=sprintf("%.2f",$count3/$len);
        $list=$data->all();
        //获取得分数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
            $list[$k]['username'] = DB::table('user')->where(['sid' => $v['sid'], 'category'=>2])->value('username');
            $list[$k]['sname']=DB::table('subject')->where(['id'=>$v['mid']])->value('sname');
        }
        $comment = DB::table('comment')->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('teacher/teach/users',['data'=>$data,'comment'=>$comment,'thao1'=>$thao1,'thao2'=>$thao2,'thao3'=>$thao3,'list'=>$list,'zhanbi1'=>$zhanbi1,'zhanbi2'=>$zhanbi2,'zhanbi3'=>$zhanbi3,'p'=>$p]);

    }
    /**
     * @method 教师同行教评查看
     * @param Request $request
     */
     public function teacherTeachLs(Request $request){
         /*取相同工号的教师的得分信息集合*/
        $datas=DB::table('pscore')->where(['category'=>3])->orderBy('tid','asc')->get()->map(function ($value) { return (array) $value; })->toArray();
        $datass=DB::table('pscore')->where(['category'=>3])->groupby('tid')->pluck('tid');
        /*计算教师同行评教总得分*/
        $result = [];
        foreach ($datas as $item) {
            isset($result[$item['tid']]) || $result[$item['tid']] = 0;
            $result[$item['tid']] += $item['tscore'];
        }
        /*降序排序*/
        arsort($result);
        /*取成绩，工号排新二维数组*/
        foreach ($result as $key=>$value) {
            $t=$key;
            $arr[][$t]=$value;
         }
         $tid=session('sid')/1;
         /*遍历二维数组，找出登录教师的排名*/
         foreach ($arr as $y => $va) {
            foreach ($va as $ke => $val) {
               if($ke==$tid)
               {
                $p=$y+1;
               }
            }
           
         }
        
        $data=DB::table('pscore')->where(['tid'=>session('sid'),'category'=>3])->get();
        $len=count($data);
        if($len==0){
            return redirect('/teacher/xinxi')->with('errors','暂未有其他教师评价，请耐心等待！！');
        }
        else{
        for($i=0,$count1=0,$test1=0;$i<$len;$i++)//计算题目1得分大于8的条数
        {
            $t1=$data[$i]->t1;
            $test1=$test1+$t1;
            if($t1>8){
                $count1++;
            }
        }
           for($i=0,$count2=0,$test2=0;$i<$len;$i++)//计算题目2得分大于8的条数
        {
            $t2=$data[$i]->t2;
            $test2=$test2+$t2;
            if($t2>8){
                $count2++;
            }
        }
           for($i=0,$count3=0,$test3=0;$i<$len;$i++)//计算题目3得分大于8的条数
        {
            $t3=$data[$i]->t3;
            $test3=$test3+$t3;
            if($t3>8){
                $count3++;
            }
        }
    }
        //计算得分占比率
        $zhanbi1=sprintf("%.2f",$test1/($len*10));
        $zhanbi2=sprintf("%.2f",$test2/($len*10));
        $zhanbi3=sprintf("%.2f",$test3/($len*10));
        //计算题目好评率
        $thao1=sprintf("%.2f",$count1/$len);
        $thao2=sprintf("%.2f",$count2/$len);
        $thao3=sprintf("%.2f",$count3/$len);
        $list=$data->all();
        //取得分数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach($list as $s=>$z){
            $list[$s]['username']=DB::table('user')->where(['sid'=>$z['aid'],'category'=>3])->value('username');
            $list[$s]['sname']=DB::table('subject')->where(['id'=>$z['mid']])->value('sname');
        }
        $comment = DB::table('comment')->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('teacher/teach/userss',['data'=>$data,'comment'=>$comment,'thao1'=>$thao1,'thao2'=>$thao2,'thao3'=>$thao3,'list'=>$list,'zhanbi1'=>$zhanbi1,'zhanbi2'=>$zhanbi2,'zhanbi3'=>$zhanbi3,'p'=>$p]);
    }
    /**
     * @method 教师领导教评查看
     * @param Request $request
     */
     public function teacherTeachLss(Request $request){
         /*取相同工号的教师的得分信息集合*/
        $datas=DB::table('pscore')->where(['category'=>1])->orderBy('tid','asc')->get()->map(function ($value) { return (array) $value; })->toArray();
        $datass=DB::table('pscore')->where(['category'=>1])->groupby('tid')->pluck('tid');
        /*计算教师领导评教总得分*/
        $result = [];
        foreach ($datas as $item) {
            isset($result[$item['tid']]) || $result[$item['tid']] = 0;
            $result[$item['tid']] += $item['tscore'];
        }
        /*降序排序*/
        arsort($result);
        /*取成绩，工号排新二维数组*/
        foreach ($result as $key=>$value) {
            $t=$key;
            $arr[][$t]=$value;
         }
         $tid=session('sid')/1;
         /*遍历二维数组，找出登录教师的排名*/
         foreach ($arr as $y => $va) {
            foreach ($va as $ke => $val) {
               if($ke==$tid)
               {
                $p=$y+1;
               }
            }
           
         }
        $data=DB::table('pscore')->where(['tid'=>session('sid'),'category'=>1])->get();
        $len=count($data);
        if($len==0){
            return redirect('/teacher/xinxi')->with('errors','暂未有领导评价，请耐心等待！！');
        }
        else{
         for($i=0,$count1=0,$test1=0;$i<$len;$i++)//计算题目1得分大于8的条数
        {
            $t1=$data[$i]->t1;
            $test1=$test1+$t1;
            if($t1>8){
                $count1++;
            }
        }
           for($i=0,$count2=0,$test2=0;$i<$len;$i++)//计算题目2得分大于8的条数
        {
            $t2=$data[$i]->t2;
            $test2=$test2+$t2;
            if($t2>8){
                $count2++;
            }
        }
           for($i=0,$count3=0,$test3=0;$i<$len;$i++)//计算题目3得分大于8的条数
        {
            $t3=$data[$i]->t3;
            $test3=$test3+$t3;
            if($t3>8){
                $count3++;
            }
        }
    }
        //计算得分占比率
        $zhanbi1=sprintf("%.2f",$test1/($len*10));
        $zhanbi2=sprintf("%.2f",$test2/($len*10));
        $zhanbi3=sprintf("%.2f",$test3/($len*10));
        //计算好评率
        $thao1=sprintf("%.2f",$count1/$len);
        $thao2=sprintf("%.2f",$count2/$len);
        $thao3=sprintf("%.2f",$count3/$len);
        $list=$data->all();
        $list = array_map('get_object_vars', $list);
        foreach($list as $a=>$b){
            $list[$a]['username']=DB::table('user')->where(['sid'=>$b['uid'],'category'=>1])->value('username');
            $list[$a]['sname']=DB::table('subject')->where(['id'=>$b['mid']])->value('sname');
        }
        $comment = DB::table('comment')->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('teacher/teach/usersss',['data'=>$data,'comment'=>$comment,'thao1'=>$thao1,'thao2'=>$thao2,'thao3'=>$thao3,'list'=>$list,'zhanbi1'=>$zhanbi1,'zhanbi2'=>$zhanbi2,'zhanbi3'=>$zhanbi3,'p'=>$p]);
    }
}
