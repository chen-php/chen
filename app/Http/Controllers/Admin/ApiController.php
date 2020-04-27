<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * @method 设置管理员密码
     * @param Request $request
     */
    public function setAdminPass(Request $request){
        if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }
        $pwd = $request->input('pwd', '');
        if (empty($pwd)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        $data['password'] = md5($pwd);
        $res = DB::table('admin')->where('id', 1)->update($data);
        if ($res != false) {
            return response()->json(['code' => 200, 'msg' => '设置密码成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '设置密码失败']);
        }
    }

    /**
     * @method 登陆
     * @param Request $request
     */
    public function getLogin(Request $request){
        $uname = $request->input('uname', '');
        $pwd = $request->input('pwd', '');
        $type = $request->input('type', '');
        if (empty($uname) && empty($pwd)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        $data['username'] = $uname;
        $data['password'] = md5($pwd);
        switch ($type) {
            case '普通用户':
                /*DB::connection()->enableQueryLog();*/
                $get = DB::table('users')->where($data)->first();
                /*$log = DB::getQueryLog();
                dd($log);*/
                if (isset($get->username) && isset($get->password) && $get->username == $uname && $get->password == md5($pwd)) {
                    $id = DB::table('users')->where($data)->value('id');
                    $oid = DB::table('order')->where(['uid' => $id])->value('id');
                    $request->session()->put('users', $uname);
                    $request->session()->put('id', $id);
                    $request->session()->save();
                    return response()->json(['code' => 200, 'msg' => '登陆成功', 'id' => $request->session()->get('id'), 'oid' => $oid]);
                } else {
                    return response()->json(['code' => 400, 'msg' => '登陆失败']);
                }
                break;
            case '医生':
                $get = DB::table('doctor')->where(['jobnumber' => $uname, 'pwd' => md5($pwd)])->first();
                if (isset($get->jobnumber) && isset($get->pwd) && $get->jobnumber == $uname && $get->pwd == md5($pwd)) {
                    $id = DB::table('doctor')->where(['jobnumber' => $uname, 'pwd' => md5($pwd)])->value('id');
                    $request->session()->put('doctor', $uname);
                    $request->session()->put('id', $id);
                    $request->session()->save();
                    return response()->json(['code' => 200, 'msg' => '登陆成功', 'id' => $request->session()->get('id')]);
                } else {
                    return response()->json(['code' => 400, 'msg' => '登陆失败']);
                }
                break;
            case '管理员':
                $get = DB::table('admin')->where($data)->first();
                $uname = DB::table('admin')->where('id', 1)->value('username');
                $pwd = DB::table('admin')->where('id', 1)->value('password');
                if (isset($get->username) && isset($get->password) && $get->username == $uname && $get->password == $pwd) {
                    DB::table('admin')->where(['username' => $data['username'], 'password' => md5($pwd)])->update([
                        'login_ip' => ip2long($request->getClientIp()),
                        'last_time' => date('Y-m-d H:i:s', time())
                    ]);
                    $request->session()->put('admin', $uname);
                    $request->session()->save();
                    return response()->json(['code' => 200, 'msg' => '登陆成功']);
                } else {
                    return response()->json(['code' => 400, 'msg' => '登陆失败']);
                }
                break;
        }
    }

    /**
     * @brief 注销登陆
     * @param Request $request
     */
    public function logout(Request $request){
        if ($request->session()->has('admin')) {
            $request->session()->forget('admin');
            $res = ['code' => 200, 'msg' => '注销成功'];
        } else {
            $res = ['code' => 400, 'msg' =>'注销失败'];
        }
        return response()->json($res);
    }
    /**
     * @method 添加医生
     * @param Request $request
     */
    public function addDoctor(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $data = $request->all();
        $data = array_map('trim', $data);
        $exist = DB::table('doctor')->where('uname', $data['uname'])->first();
        if (isset($exist->uname)) {
            return response()->json(['code' => 400, 'msg' => '当前用户已存在']);
        }
        if (empty($data)) {
            return response()->json(['code' => 400, 'msg' => '数据不能为空']);
        }
        $data1 = array(
            'create_time' => time(),
            'pwd' => md5($data['pwd'])
        );
        $datas = array_merge($data, $data1);
        $res = DB::table('doctor')->insert($datas);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '添加医生成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '添加医生失败']);
        }
    }

    /**
     * @method 医生列表
     * @param Request $request
     */
    public function addList(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $keys = $request->input('keys', '');
        $uid = $request->input('uid', 0);
        $oid = $request->input('oid', 0);
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        if (empty($keys)) {
            $count = DB::table('doctor')->count();
            $res = DB::table('doctor')->paginate($limit);
        } else {
            $count = DB::table('doctor')->where('uname', 'like', '%'.$keys.'%')->count();
            $res = DB::table('doctor')->where('uname', 'like', '%'.$keys.'%')->paginate($limit);
        }
        $order = DB::table('order')->where(['uid' => $uid, 'id' => $oid])->first();
        if (!empty($order->status)) {
            $status = $order->status;
            $did = $order->did;
        } else {
            $status = 0;
            $did = 0;
        }
        return response()->json(['code' => 200, 'pagesize' => $limit, 'page' => $page, 'totalCount' => $count, 'status' => $status, 'dids' => $did, 'list' => $res]);
    }

    /**
     * @method 修改医生
     * @param Request $request
     */
    public function updateDoctor(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 405, 'msg' => '异常登陆']);
        }*/
        $data = $request->all();
        $data = array_map('trim', $data);
        if (empty($data['id']) && isset($data['id'])) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        $datas = [
            'create_time' => time(),
            'pwd' => md5($data['pwd'])
        ];
        $data = array_merge($data, $datas);
        $datas = array_diff_key($data, ['id' => $data['id']]);
        $result = DB::table('doctor')->where('id', $data['id'])->update($datas);
        if ($result != true) {
            $res = ['code' => 400, 'msg' => '更新失败'];
        } else {
            $res = ['code' => 200, 'msg' => '更新成功'];
        }
        return response()->json($res);
    }
    /**
     * @method 删除医生
     * @param Request $request
     */
    public function delDoctor(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $did = $request->input('id', '');
        $res = DB::table('doctor')->where(['id' => $did])->delete();
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '删除医生成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '删除医生失败']);
        }
    }
    /**
     * @method 添加用户
     * @param Request $request
     */
    public function addUser(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $data = $request->all();
        $data = array_map('trim', $data);
        $exist = DB::table('users')->where('tel', $data['tel'])->first();
        if (isset($exist->username)) {
            return response()->json(['code' => 400, 'msg' => '当前用户已存在']);
        }
        if (empty($data)) {
            return response()->json(['code' => 400, 'msg' => '数据不能为空']);
        }
        $data1 = array(
            'create_time' => time(),
            'password' => md5($data['password'])
        );
        $datas = array_merge($data, $data1);
        $datas = array_filter($datas);
        $res = DB::table('users')->insert($datas);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '添加用户成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '添加用户失败']);
        }
    }

    /**
     * @method 用户列表
     * @param Request $request
     */
    public function userList(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $keys = $request->input('keys', '');
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        if (empty($keys)) {
            $count = DB::table('users')->count();
            $res = DB::table('users')->paginate($limit);
        } else {
            $count = DB::table('users')->where('username', 'like', '%'.$keys.'%')->count();
            $res = DB::table('users')->where('username', 'like', '%'.$keys.'%')->paginate($limit);
        }
        return response()->json(['code' => 200, 'pagesize' => $limit, 'page' => $page, 'totalCount' => $count, 'list' => $res]);
    }
    /**
     * @method 修改用户
     * @param Request $request
     */
    public function updateUser(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 405, 'msg' => '异常登陆']);
        }*/
        $data = $request->all();
        $data = array_map('trim', $data);
        if (empty($data['id']) && isset($data['id'])) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        if (empty($data['password'])) {
            $datas = [
                'create_time' => time()
            ];
        } else {
            $datas = [
                'create_time' => time(),
                'password' => md5($data['password'])
            ];
        }
        $data = array_merge($data, $datas);
        $datas = array_diff_key($data, ['id' => $data['id']]);
        $result = DB::table('users')->where('id', $data['id'])->update($datas);
        if ($result != true) {
            $res = ['code' => 400, 'msg' => '更新失败'];
        } else {
            $res = ['code' => 200, 'msg' => '更新成功'];
        }
        return response()->json($res);
    }
    /**
     * @method 删除用户
     * @param Request $request
     */
    public function delUser(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $did = $request->input('id', '');
        $res = DB::table('users')->where(['id' => $did])->delete();
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '删除用户成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '删除用户失败']);
        }
    }
    /**
     * @method 订单列表
     * @param Request $request
     */
    public function orderList(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $keys = $request->input('keys', '');
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $uid = $request->input('uid', '');
        if (empty($uid)) {
            if (empty($keys)) {
                $count = DB::table('order')->count();
                $totalPage = ceil($count/$limit);
                $startPage = ($page - 1) * $limit;
                $res = DB::select("SELECT * FROM tb_order LIMIT $startPage,$limit");
            } else {
                $count = DB::table('order')->where([['orderid', 'like', '%'.$keys.'%']])->count();
                $totalPage = ceil($count/$limit);
                $startPage = ($page - 1) * $limit;
                $res = DB::select("SELECT * FROM tb_order WHERE orderid LIKE '%$keys%' LIMIT $startPage,$limit");
            }
        } else {
            if (empty($keys)) {
                $count = DB::table('order')->where(['uid' => $uid])->count();
                $totalPage = ceil($count/$limit);
                $startPage = ($page - 1) * $limit;
                $res = DB::select("SELECT * FROM tb_order WHERE uid='{$uid}' LIMIT $startPage,$limit");
            } else {
                $count = DB::table('order')->where([['uid', '=', $uid],['orderid', 'like', '%'.$keys.'%']])->count();
                $totalPage = ceil($count/$limit);
                $startPage = ($page - 1) * $limit;
                $res = DB::select("SELECT * FROM tb_order WHERE uid='{$uid}' AND orderid LIKE '%$keys%' LIMIT $startPage,$limit");
            }
        }
        return response()->json(['code' => 200, 'pagesize' => $limit, 'page' => $page, 'totalCount' => $count, 'list' => $res]);
    }
    /**
     * @method 删除订单
     * @param Request $request
     */
    public function delOrder(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $did = $request->input('id', '');
        $res = DB::table('order')->where(['id' => $did])->delete();
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '删除订单成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '删除订单失败']);
        }
    }

    /**
     * @method 提交预约
     * @param Request $request
     */
    public function clickAppion(Request $request){
        $did = $request->input('did', '');
        $uid = $request->input('uid', '');
        if (empty($did)) {
            return response()->json(['code' => 400, 'msg' => '医生数据异常']);
        }
        $exist = DB::table('order')->where(['did' => $did, 'uid' => $uid])->first();
        if (!empty($exist->id)) {
            return response()->json(['code' => 400, 'msg' => '您已经预约，请不要多次预约！']);
        }
        if (!empty($did)) {
            $status = DB::table('order')->where(['did' => $did])->value('status');
            if ($status == 3 || $status == 1 || empty($status)) {
                $data1 = $request->all();
                $data2 = [
                    'orderid' => date('YmdHis', time()).mt_rand(000000, 666666),
                    'appoint_time' => time()
                ];
                $datas = array_merge($data1, $data2);
                $res = DB::table('order')->insert($datas);
                if ($res) {
                    return response()->json(['code' => 200, 'msg' => '预约成功']);
                } else {
                    return response()->json(['code' => 400, 'msg' => '预约失败']);
                }
            } else {
                return response()->json(['code' => 200, 'msg' => '医生在忙，快去看看其他医生吧~']);
            }
        } else {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
    }

    /**
     * @method 用户取消订单
     * @param Request $request
     */
    public function cancelOrder(Request $request){
        $oid = $request->input('id', 0);
        if (empty($oid) && !isset($oid)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        $res = DB::table('order')->where(['id' => $oid])->update(['status' => 4]);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '取消成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '取消失败']);
        }
    }
    /**
     * @method 医生取消订单
     * @param Request $request
     */
    public function cancelDoctor(Request $request){
        $oid = $request->input('id', 0);
        if (empty($oid) && !isset($oid)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        $res = DB::table('order')->where(['id' => $oid])->update(['status' => 3]);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '取消成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '取消失败']);
        }
    }
    /**
     * @method 医生确诊订单
     * @param Request $request
     */
    public function corDoctor(Request $request){
        $oid = $request->input('id', 0);
        if (empty($oid) && !isset($oid)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        $res = DB::table('order')->where(['id' => $oid])->update(['status' => 1]);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '确认成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '确认失败']);
        }
    }
    /**
     * @method 医生开药订单
     * @param Request $request
     */
    public function doctorDrugs(Request $request){
        $oid = $request->input('id', 0);
        var_dump($oid);die;
        if (empty($oid) && !isset($oid)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        $res = DB::table('order')->where(['id' => $oid])->update(['is_open' => 2]);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '开药成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '开药失败']);
        }
    }
    /**
     * @method 添加手术室
     * @param Request $request
     */
    public function addRoom(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $data = $request->all();
        $data = array_map('trim', $data);
        $exist = DB::table('room')->where('rname', $data['rname'])->first();
        if (isset($exist->rname)) {
            return response()->json(['code' => 400, 'msg' => '当前手术室已存在']);
        }
        if (empty($data)) {
            return response()->json(['code' => 400, 'msg' => '数据不能为空']);
        }
        $data1 = array(
            'create_time' => time()
        );
        $datas = array_merge($data, $data1);
        $datas = array_filter($datas);
        $res = DB::table('room')->insert($datas);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '添加手术室成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '添加手术室失败']);
        }
    }
    /**
     * @method 手术室列表
     * @param Request $request
     */
    public function roomList(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $keys = $request->input('keys', '');
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        if (empty($keys)) {
            $count = DB::table('room')->count();
            $totalPage = ceil($count/$limit);
            $startPage = ($page - 1) * $limit;
            $res = DB::select("SELECT * FROM tb_room LIMIT $startPage,$limit");
        } else {
            $count = DB::table('room')->where('rname', 'like', '%'.$keys.'%')->count();
            $totalPage = ceil($count/$limit);
            $startPage = ($page - 1) * $limit;
            $res = DB::select("SELECT * FROM tb_room LIMIT WHERE rname LIKE '%{$keys}%' $startPage,$limit");
        }
        $details_arr = array_map('get_object_vars', $res);
        $list = array();
        foreach ($details_arr as $k=>$v) {
            $status = DB::table('apply')->where(['rname' => $v['rname']])->value('status');

            $list[$k]['rname'] = $v['rname'];
            $list[$k]['simple'] = $v['simple'];
            $list[$k]['status'] = $status;
        }
        return response()->json(['code' => 200, 'pagesize' => $limit, 'page' => $page, 'totalCount' => $count, 'list' => $list]);
    }
    /**
     * @method 修改手术室
     * @param Request $request
     */
    public function updateRoom(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 405, 'msg' => '异常登陆']);
        }*/
        $data = $request->all();
        $data = array_map('trim', $data);
        if (empty($data['id']) && isset($data['id'])) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        $exist = DB::table('room')->where('rname', $data['rname'])->first();
        if (isset($exist->rname)) {
            return response()->json(['code' => 400, 'msg' => '当前手术室已存在']);
        }
        $datas = [
            'create_time' => time(),
        ];
        $data = array_merge($data, $datas);
        $datas = array_diff_key($data, ['id' => $data['id']]);
        $result = DB::table('room')->where('id', $data['id'])->update($datas);
        if ($result != true) {
            $res = ['code' => 400, 'msg' => '更新失败'];
        } else {
            $res = ['code' => 200, 'msg' => '更新成功'];
        }
        return response()->json($res);
    }
    /**
     * @method 删除手术室
     * @param Request $request
     */
    public function delRoom(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $did = $request->input('id', '');
        $res = DB::table('room')->where(['id' => $did])->delete();
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '删除手术室成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '删除手术室失败']);
        }
    }
    /**
     * @method 申请手术室
     * @param Request $request
     */
    public function applyRoom(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $data = $request->all();
        $exist = DB::table('apply')->where(['did' => $data['did']])->first();
        if (!empty($exist->id)) {
            return response()->json(['code' => 400, 'msg' => '您已经预约，请不要多次预约！']);
        }
        $datas = [
            'create_time' => time(),
            'orderid' => date('YmdHis', time()).mt_rand(000000, 999999)
        ];
        $datass = array_merge($data, $datas);
        $res = DB::table('apply')->insert($datass);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '申请手术室成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '申请手术室失败']);
        }
    }
    /**
     * @method 处理申请
     * @param Request $request
     */
    public function handleRoom(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $rid = $request->input('id', '');
        $status = $request->input('status', '');
        /*DB::connection()->enableQueryLog();*/
        $res = DB::table('apply')->where(['id' => $rid])->update(['status' => $status]);
        /*$log = DB::getQueryLog();
        dd($log);*/
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '申请成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '申请失败']);
        }
    }
    /**
     * @method 申请列表
     * @param Request $request
     */
    public function applyList(Request $request){
        /*if ($request->session()->has('admin') != true) {
            return response()->json(['code' => 400, 'msg' => '异常登陆']);
        }*/
        $keys = $request->input('keys', '');
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        if (empty($keys)) {
            $count = DB::table('apply')->count();
            $res = DB::table('apply')->paginate($limit);
        } else {
            $count = DB::table('apply')->where('rname', 'like', '%'.$keys.'%')->count();
            $res = DB::table('apply')->where('rname', 'like', '%'.$keys.'%')->paginate($limit);
        }
        return response()->json(['code' => 200, 'pagesize' => $limit, 'page' => $page, 'totalCount' => $count, 'list' => $res]);
    }
}