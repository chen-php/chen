<?php


namespace app\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * @method 科目列表
     * @param Request $request
     */
    public function subjectList(Request $request){
        $data = DB::table('subject')->orderBy('schoolyear','asc')->orderBy('term','asc')->paginate(10);
        $list = $data->all();
        $list = array_map('get_object_vars', $list);
        foreach ($list as $k=>$v) {
            $list[$k]['tname'] = DB::table('user')->where(['sid' => $v['tid']])->value('username');
        }
        return view('admin/subject/users', ['list' => $list, 'data' => $data]);
    }

    /**
     * @method 添加科目
     * @param Request $request
     */
    public function subjectAdd(Request $request){
        if ($request->isMethod('POST')) {
            //接收科目信息
            $data = $request->all();
            //添加科目
            /*科目存在判断*/
            $exist = DB::table('subject')->where(['sname' => $data['sname']])->first();
            if (isset($exist->sname) && $exist->sname == $data['sname']) {
                $data=[
                    'status'=>1,
                    'messgae'=>'该科目以存在！'
                ];
                return $data;
            }
            //添加操作
            $datas = [
                'create_time' => time()
            ];
            /*合并数组*/
            $datass = array_merge($data, $datas);
            /*添加*/
            $res = DB::table('subject')->insert($datass);
            if ($res) {
               $data=[
                    'status'=>0,
                    'message'=>'添加科目成功'
               ];
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'添加科目失败'
                ];
            }
            return $data;
        }
        $teacher = DB::table('user')->where(['category' => 3])->select('sid', 'username')->get()->map(function ($value) { return (array) $value; })->toArray();
        //var_dump($teacher);
        return view('admin/subject/usere', ['teacher' => $teacher]);
    }
    /**
     * @method 编辑科目
     * @param Request $request
     */
    public function subjectEdit(Request $request){
        if ($request->isMethod('POST')) {
            //获取科目信息
            $data = $request->all();

            //更新操作
            $data = array_map('trim', $data);
            $datas = [
                'create_time' => time()
            ];
            /*合并数组*/
            $data = array_merge($data, $datas);
            /*比较数组取差值*/
            $datass = array_diff_key($data, ['id' => $data['id']]);
            /*更新*/
            $res = DB::table('subject')->where(['id' => $data['id']])->update($datass);
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'编辑科目成功'
                ];
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'编辑科目失败'
                ];
            }
            return $data;
        }
        $teacher = DB::table('user')->where(['category' => 3])->select('sid', 'username')->get()->map(function ($value) { return (array) $value; })->toArray();
        $oexist = DB::table('subject')->where(['id' => $request->input('id')])->first();
        return view('admin/subject/usera', ['one' => $oexist, 'teacher' => $teacher]);
    }
    /**
     * @method 科目删除
     * @param Request $request
     */
    public function subjectDelete(Request $request){
        if ($request->isMethod('GET')) {
            //获取删除科目id
            $data = $request->input('id');
            //删除
            $res = DB::table('subject')->where(['id' => $data])->delete();
            if ($res) {
                $data=[
                    'status'=>0,
                    'message'=>'删除科目成功'
                ];
            } else {
                $data=[
                    'status'=>1,
                    'message'=>'删除科目失败'
                ];
               
            }
            return $data;
        }
        return view('admin/subject/usera');
    }
    /**
     * @method 科目查找
     * @param Request $request
     */
    public function subjectFind(Request $request){
        if($request->isMethod('post')){
            //获取查找科目名
            $data=$request->input('findname');
            //数据库查询
            $datas=DB::table('subject')->where(['sname'=>$data])->first();
            if(!$datas){
                return redirect('/subject')->with('errors','暂未有此科目！');
            }
            else{
                $datass=DB::table('subject')->where(['sname'=>$data])->paginate(10);
                $list = $datass->all();
                $list = array_map('get_object_vars', $list);
                foreach ($list as $k=>$v) {
                $list[$k]['tname'] = DB::table('user')->where(['sid' => $v['tid']])->value('username');
                }
             return view('admin/subject/users', ['list' => $list, 'data' => $datass]);
            }
        }
    }
}