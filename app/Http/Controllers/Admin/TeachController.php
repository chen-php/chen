<?php


namespace app\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeachController extends Controller
{
    /**
     * @method 评教列表
     * @param Request $request
     */
    public function teachList(Request $request){
        if($request->isMethod('POST')){
            $data=$request->all();
            //dd($data);
            $teachers=DB::table('user')->where(['sid'=>$request->input('teacher')])->value('username');
            $datas=DB::table('pscore')->where(['tid'=>$data['teacher'],'category'=>1])->get();
            $datass=DB::table('pscore')->where(['tid'=>$data['teacher'],'category'=>2])->get();
            $datasss=DB::table('pscore')->where(['tid'=>$data['teacher'],'category'=>3])->get();
            $list=$datas->all();
            /*回调，获取领导评教分数数组中的所有属性*/
            $list = array_map('get_object_vars', $list);
            foreach ($list as $k=>$v) {
                $list[$k]['username'] = DB::table('user')->where(['sid' => $v['uid'], 'category'=>1])->value('username');
                $list[$k]['sname']=DB::table('subject')->where(['id'=>$v['mid']])->value('sname');
            }
            $lists=$datass->all();
            /*回调，获取学生评教分数数组中的所有属性*/
            $lists = array_map('get_object_vars', $lists);
            foreach($lists as $s=>$z){
                $lists[$s]['username']=DB::table('user')->where(['sid'=>$z['sid'],'category'=>2])->value('username');
                $lists[$s]['sname']=DB::table('subject')->where(['id'=>$z['mid']])->value('sname');
            }
            $listss=$datasss->all();
            /*回调，获取同行评教分数数组中的所有属性*/
            $listss = array_map('get_object_vars', $listss);
            foreach($listss as $a=>$b){
                $listss[$a]['username']=DB::table('user')->where(['sid'=>$b['aid'],'category'=>3])->value('username');
                $listss[$a]['sname']=DB::table('subject')->where(['id'=>$b['mid']])->value('sname');
            }
            $teacher=DB::table('user')->where(['category'=>3])->get()->map(function ($value) { return (array) $value; })->toArray();
            return view('admin/teach/usera',['teacher'=>$teacher,'list'=>$list,'lists'=>$lists,'listss'=>$listss,'teachers'=>$teachers]);
            }

            $teacher=DB::table('user')->where(['category'=>3])->get()->map(function ($value) { return (array) $value; })->toArray();
            return view('admin/teach/users',['teacher'=>$teacher]);
    }

    /**
     * @method 评教
     * @param Request $request
     */
    public function teachEdit(Request $request){
        if ($request->isMethod('POST')) {
            //获取分数
            $data = $request->all();
            //评教存在判断
            $exist = DB::table('pscore')->where(['tid' => $data['tid'], 'uid' => session('id')])->first();
            if (isset($exist->tid) && $exist->tid == $data['tid']) {
                return showMessage(['message' => '该老师已被评教', 'url' => url('teach')]);
            }
            //评教操作
            $datas = [
                'create_time' => time()
            ];
            /*计算总得分*/
            $data['tscore'] = array_sum($data['score']);
            $data['uid'] = session('id');
            /*合并数组*/
            $data = array_merge($data, $datas);
            /*比较取差值*/
            $datass = array_diff_key($data, ['_token' => $data['_token'], 'score' => $data['score']]);
            $res = DB::table('pscore')->insert($datass);
            if ($res) {
                return showMessage(['message' => '评教成功', 'url' => url('teach')]);
            } else {
                return showMessage(['message' => '评教失败', 'url' => url('commentEdit')]);
            }
        }
        $cid = $request->input('id', 0);
        $comment = DB::table('comment')->get()->map(function ($value) { return (array) $value; })->toArray();
        return view('admin/teach/usere', ['comment' => $comment, 'id' => $cid]);
    }
    /**
     * @method 评教删除
     * @param Request $request
     */
    public function teachDelete(Request $request){
        if ($request->isMethod('GET')) {
            //接收信息
            $data = $request->all();
            $res = DB::table('pscore')->where(['id' => $data['id']])->delete();
            if ($res) {
               $data=[
                'status'=>0,
                'message'=>'删除评教成功'
               ];
            } else {
                $data=[
                'status'=>1,
                'message'=>'删除评教失败'
               ];
            }
            return $data;

        }
    }
}