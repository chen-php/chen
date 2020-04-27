<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @method 学校领导个人信息列表
     * @param Request $request
     */
    public function userList(Request $request){
        $data = DB::table('user')->where(['category' => 1,'sid'=>session('sid')])->paginate(10);
        return view('user/people/users', ['list' => $data]);
    }
	/**
     * @method 学校领导个人信息编辑
     * @param Request $request
     */
    public function userEdit(Request $request){
        if ($request->isMethod('POST')) {
        	//接收信息
            $data = $request->all();
            //dd($data);
            /*回调，清除不必要的空格*/
            $data = array_map('trim', $data);
            $datas = [
                'create_time' => time(),
                'category' => 1
            ];
			/*合并两个数组*/
            $data = array_merge($data, $datas);
			/*比较两数组的键名 ，并返回差集。*/
            $datass = array_diff_key($data, ['sid' => $data['sid']]);
            //更新操作
		    $res = DB::table('user')->where(['sid' => $data['sid'],'category'=>1])->update($datass);
		    //返回更新结果
            if ($res) {
                $data=[
                	'status'=>0,
                	'message'=>'修改成功'
                ];
            } else {
                $data=[
                	'status'=>1,
                	'message'=>'修改失败'
                ];
            }
            return $data;
        }
        $oexist = DB::table('user')->where(['sid' => $request->input('sid')])->first();
        return view('user/people/usera', ['one' => $oexist]);
    }
	/**
     * @method 学校领导教评列表
     * @param Request $request
     */
	 public function userTeachList(Request $request){
	   if($request->isMethod('post')){
		$datas=$request->all();
		$data = DB::table('subject')->where([['schoolyear' ,$datas['schoolyear']],['term',$datas['term']]])->paginate(10);
		if(!($data->first()))
		{
			 return redirect('/teacher/teacherTeachList')->with('errors','在此时间段内暂时没有课程！！！');
		}
        $list = $data->all();
        //获取课程数组的所有属性组成一个新的数组
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'uid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear=$datas['schoolyear'];
        $terms=$datas['term'];
        //根据学年跳转到相对应的界面
		switch($schoolyear){
			case '2016-2017':
			 return view('user/teach/users1617', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
			case '2017-2018':
			 return view('user/teach/users1718', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
			case '2018-2019':
			 return view('user/teach/users1819', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
			case '2019-2020':
			 return view('user/teach/users1920', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
			 break;
		}
	  }
	       return view('user/teach/test');
	 }
	 /**
     * @method 学校领导1617教评页面1
     * @param Request $request
     */
	  public function userTeachLists(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2016-2017','term'=>1])->paginate(10);
        $list = $data->all();
        //获取1617学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'uid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2016-2017';
		$terms=1;
		return view('user/teach/users1617', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	  /**
     * @method 学校领导1617教评页面2
     * @param Request $request
     */
	  public function userTeachListes(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2016-2017','term'=>2])->paginate(10);
        $list = $data->all();
        //获取1617学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'uid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2016-2017';
		$terms=2;
		return view('user/teach/users1617', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	    /**
     * @method 学校领导1718教评页面1
     * @param Request $request
     */
	  public function userTeachListss(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2017-2018','term'=>1])->paginate(10);
        $list = $data->all();
        //获取1718学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'uid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2017-2018';
		$terms=1;
		return view('user/teach/users1718', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	   /**
     * @method 学校领导1718教评页面2
     * @param Request $request
     */
	  public function userTeachListess(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2017-2018','term'=>2])->paginate(10);
        $list = $data->all();
        //获取1718学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'uid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2017-2018';
		$terms=2;
		return view('user/teach/users1718', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	   /**
     * @method 学校领导1819教评页面1
     * @param Request $request
     */
	  public function userTeachListsss(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2018-2019','term'=>1])->paginate(10);
        $list = $data->all();
        //获取1819学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'uid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2018-2019';
		$terms=1;
		return view('user/teach/users1819', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	   /**
     * @method 学校领导1819教评页面2
     * @param Request $request
     */
	  public function userTeachListesss(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2018-2019','term'=>2])->paginate(10);
        $list = $data->all();
        //获取1819学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'uid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2018-2019';
		$terms=2;
		return view('user/teach/users1819', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	   /**
     * @method 学校领导1920教评页面1
     * @param Request $request
     */
	  public function userTeachListssss(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2019-2020','term'=>1])->paginate(10);
        $list = $data->all();
        //获取1920学年1学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'uid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2019-2020';
		$terms=1;
		return view('user/teach/users1920', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	  /**
     * @method 学校领导1920教评页面2
     * @param Request $request
     */
	  public function userTeachListessss(Request $request){
		$data = DB::table('subject')->where(['schoolyear' =>'2019-2020','term'=>2])->paginate(10);
        $list = $data->all();
        //获取1920学年2学期课程数组的所有属性
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
			$list[$k]['username']=DB::table('user')->where(['sid'=>$v['tid'],'category'=>3])->value('username');
            $list[$k]['score'] = DB::table('pscore')->where(['tid' => $v['tid'], 'uid' => session('sid'),'mid'=>$v['id']])->value('tscore');
        }
		$schoolyear='2019-2020';
		$terms=2;
		return view('uid/teach/users1920', ['list' => $data, 'lists' => $list,'terms'=>$terms,'schoolyear'=>$schoolyear]);
	  }
	   /**
     * @method 学校领导教评判断
     * @param Request $request
     */
	 public function userTeachA(Request $request){
		  if ($request->isMethod('get')) {
            $data = $request->all();
            $mid=$request->input('mid');
            //存在判断
			$exist = DB::table('pscore')->where(['uid' => session('sid'), 'tid' =>$data['tid'],'mid'=>$mid])->get();
			//dd($exist->first());
           if ($exist->first()) {
               return redirect('/user/userTeachList')->with('errors','你已经评教过该老师！！！');
            }
        }
		$terms=$request->input('term',0);
		$schoolyears=$request->input('schoolyear',0);
        $cid = $request->input('tid', 0);
		$mid=$request->input('mid',0);
        $comment = DB::table('comment')->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('user/teach/usere', ['comment' => $comment, 'tid' => $cid, 'mid'=>$mid,'term'=>$terms,'schoolyear'=>$schoolyears]);
	 }
	 /**
     * @method 学校领导教评
     * @param Request $request
     */
	 public function userTeach(Request $request){
		  if ($request->isMethod('post')) {
		  	//获取信息
            $data = $request->all();
            $t1=$data['score'][0];
            $t2=$data['score'][1];
            $t3=$data['score'][2];
            $datas = [
                'create_time' => time(),
				'category'=>1,
				'mid'=>$request->input('mid'),
				'schoolyear'=>$request->input('schoolyear'),
				'term'=>$request->input('term'),
				't1'=>$t1,
                't2'=>$t2,
                't3'=>$t3
				
            ];
            //计算总得分
            $data['tscore'] = array_sum($data['score']);
            $data['uid'] = session('sid');
            //合并数组
            $data = array_merge($data, $datas);
            //比较键名取差值
            $datass = array_diff_key($data, ['score' => $data['score']]);
            //评教操作
            $res = DB::table('pscore')->insert($datass);
            //返回评教结果
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
        return view('user/teach/usere', ['comment' => $comment, 'tid' => $cid, 'mid'=>$mid,'term'=>$terms,'schoolyear'=>$schoolyears]);
}

}
