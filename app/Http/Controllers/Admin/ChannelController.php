<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class ChannelController extends Controller
{
    /**
     * @method 渠道登陆
     * @param Request $request
     */
    public function getCLogin(Request $request){
        $uname = $request->input('uname', '');
        $pwd = $request->input('pwd', '');
        if (empty($uname) && empty($pwd)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        $data['username'] = $uname;
        $data['password'] = sha1($pwd);
        $get = DB::table('addchannel')->where($data)->first();
        if (isset($get->username) && isset($get->password) && $get->username == $uname && $get->password == sha1($pwd)) {
            $request->session()->put('channel', $uname);
            $request->session()->put('id', $get->id);
            $request->session()->save();
            return response()->json(['code' => 200, 'msg' => '登陆成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '登陆失败']);
        }
    }
    /**
     * @brief 注销登陆
     * @param Request $request
     */
    public function Clogout(Request $request){
        if ($request->session()->has('channel')) {
            $request->session()->forget('channel');
            $request->session()->forget('id');
            $res = ['code' => 200, 'msg' => '注销成功'];
        } else {
            $res = ['code' => 400, 'msg' =>'注销失败'];
        }
        return response()->json($res);
    }

    /**
     * @method 显示给渠道
     */
    public function showChannel(Request $request){
        if ($request->session()->has('channel') != true) {
            return response()->json(['code' => 405, 'msg' => '异常登陆']);
        }
        $limit = $request->input('limit', 15);
        $page = $request->input('page', 1);
        $id = $request->session()->get('id');
        $ch = DB::table('addchannel')->where(['id' => $id])->value('channels');
        $total = DB::table('channelstatistics')->where(['recycle' => 1, 'channel' => $ch])->count();
        $startpage = ceil($page - 1) * $limit;
        $totalPage = ceil($total/$limit);
        $details = DB::select("SELECT id, is_success, downloadnumber, run_number, terminal_number, create_time FROM tb_output WHERE `channel`='{$ch}' AND is_success=1 GROUP BY create_time ORDER BY create_time DESC LIMIT $startpage,$limit");
        $details_arr = array_map('get_object_vars', $details);
        $details1 = DB::select("SELECT id, is_success, downloadnumber, run_number, terminal_number, create_time FROM tb_output WHERE `channel`='{$ch}' AND is_success=1 GROUP BY create_time");
        $details_arr1 = array_map('get_object_vars', $details1);
        $totalProcess = $process = DB::table('channelstatistics')->where(['channel' => $ch, 'recycle' => 1])->groupBy('online_qq')->get()->map(function ($value) {
            return (array) $value;
        })->toArray();
        $price = DB::table('addchannel')->where(['id' => $id])->value('price');
        $percentage = DB::table('addchannel')->where(['id' => $id])->value('percentage');
        $totalPrice = count($process) > 100 ? count($process) :count($process) * ($percentage / 100);
        $totalProcess = 0;
        $totalMoney = 0;
        foreach ($details_arr1 as $k=>$v) {
            $st = strtotime(date('Y-m-d 00:00:00', strtotime($v['create_time'])));
            $et = strtotime(date('Y-m-d 23:59:59', strtotime($v['create_time'])));
            $process = DB::table('channelstatistics')->where(['recycle' => 1, 'channel' => $ch])->whereBetween('create_time', [$st, $et])->groupBy('online_qq')->get()->map(function ($value) {
                return (array) $value;
            })->toArray();
            $totalProcess += ceil(count($process) * ($percentage / 100));
            $totalMoney += (ceil(count($process) * ($percentage / 100)) * $price);
        }
        $list = array();
        foreach ($details_arr as $k=>$v) {
            $st = strtotime(date('Y-m-d 00:00:00', strtotime($v['create_time'])));
            $et = strtotime(date('Y-m-d 23:59:59', strtotime($v['create_time'])));
            $process = DB::table('channelstatistics')->where(['recycle' => 1, 'channel' => $ch])->whereBetween('create_time', [$st, $et])->groupBy('online_qq')->get()->map(function ($value) {
                return (array) $value;
            })->toArray();
            $list[$k]['times'] = $v['create_time'];
            $list[$k]['process'] = ceil(count($process) * ($percentage / 100));
            $list[$k]['price'] = $price;
            $list[$k]['money'] = ceil(count($process) * ($percentage / 100)) * $price;
        }
        return response()->json(['code' => 200, 'page' => $page, 'totalPage' => $totalPage, 'totalProcess' => $totalProcess, 'totalMoney' => $totalMoney, 'list' => $list]);
    }
    /**
     * @method 获取ip、区域、地址等详细信息
     * @param Request $request
     */
    public function cDetails(Request $request){
        if ($request->session()->has('channel') != true) {
            return response()->json(['code' => 405, 'msg' => '异常登陆']);
        }
        $id = $request->session()->get('id');
        $ch = DB::table('addchannel')->where(['id' => $id])->value('channels');
        $times = $request->input('times', date('Y-m-d', time()));
        $limit = $request->input('limit', 15);
        $page = $request->input('page', 1);
        if ($ch == 0 || empty($ch)) {
            return response()->json(['code' => 400, 'msg' => '渠道异常']);
        }
        $st = strtotime(date('Y-m-d 00:00:00', strtotime($times)));
        $et = strtotime(date('Y-m-d 23:59:59', strtotime($times)));
        $total = DB::table('channelstatistics')->where(['recycle' => 1, 'channel' => $ch])->whereBetween('create_time', [$st, $et])->count();
        $startpage = ceil($page - 1) * $limit;
        $totalPage = ceil($total/$limit);
        $datas = DB::select("SELECT * FROM tb_channelstatistics WHERE `channel`='{$ch}' AND recycle=1 AND create_time BETWEEN '{$st}' AND '{$et}' GROUP BY online_qq ORDER BY create_time DESC LIMIT $startpage,$limit");
        $datas_arr = array_map('get_object_vars', $datas);
        $percentage = DB::table('addchannel')->where(['recycle' => 1, 'channels' => $ch])->value('percentage');
        $percentage = $percentage / 100;
        $channel_look = ceil(count($datas_arr) * $percentage);
        $list = [];
        for ($i = 0;$i < $channel_look; $i++) {
            $list[$i]['times'] = date('Y-m-d H:i:s', $datas_arr[$i]['create_time']);
            $list[$i]['qq'] = $datas_arr[$i]['online_qq'];
            $list[$i]['ip'] = $datas_arr[$i]['ip'];
        }
        /*foreach ($datas_arr as $k=>$v) {
            $success = DB::table('succes')->where(['qq' => $v['online_qq']])->value('success');
            $list[$k]['times'] = date('Y-m-d H:i:s', $v['create_time']);
            $list[$k]['qq'] = $v['online_qq'];
            $list[$k]['mac'] = $v['computer_code'];
            $list[$k]['ip'] = $v['ip'];
            $list[$k]['areas'] = $v['areas'];
            $list[$k]['q_edition'] = $v['q_edition'];
            $list[$k]['edition'] = $v['edition'];
            $list[$k]['status'] = $success == 0 ? '成功' : '失败';
        }*/
        return response()->json(['code' => 200, 'page' => $page, 'totalPage' => $totalPage, 'list' => $list]);
    }
  	/**
     * @method 显示给渠道
     */
    public function showChannel4(Request $request){
        if ($request->session()->has('channel') != true) {
            return response()->json(['code' => 405, 'msg' => '异常登陆']);
        }
        $limit = $request->input('limit', 15);
        $page = $request->input('page', 1);
        $id = $request->session()->get('id');
        $ch = DB::table('addchannel')->where(['id' => $id])->value('channels');
        $total = DB::table('channelstatistics')->where(['recycle' => 1, 'channel' => $ch])->count();
        $startpage = ceil($page - 1) * $limit;
        $totalPage = ceil($total/$limit);
        $details = DB::select("SELECT id, is_success, downloadnumber, run_number, terminal_number, create_time FROM tb_output WHERE `channel`='{$ch}' AND is_success=1 GROUP BY create_time ORDER BY create_time DESC LIMIT $startpage,$limit");
        $details_arr = array_map('get_object_vars', $details);
        $totalProcess = $process = DB::table('flow')->where(['channel' => $ch])->groupBy('qq')->get()->map(function ($value) {
            return (array) $value;
        })->toArray();
        $price = DB::table('addchannel')->where(['id' => $id])->value('price');
        $percentage = DB::table('addchannel')->where(['id' => $id])->value('percentage');
        $totalPrice = count($process) > 100 ? count($process) :count($process) * ($percentage / 100);
        $list = array();
        foreach ($details_arr as $k=>$v) {
            $st = strtotime(date('Y-m-d 00:00:00', strtotime($v['create_time'])));
            $et = strtotime(date('Y-m-d 23:59:59', strtotime($v['create_time'])));
            $process = DB::table('flow')->where(['channel' => $ch])->whereBetween('time', [$st, $et])->groupBy('qq')->get()->map(function ($value) {
                return (array) $value;
            })->toArray();

            $list[$k]['times'] = $v['create_time'];
            $list[$k]['process'] = ceil(count($process) * ($percentage / 100));
            $list[$k]['price'] = $price;
            $list[$k]['money'] = ceil(count($process) * ($percentage / 100)) * $price;
        }
        return response()->json(['code' => 200, 'page' => $page, 'totalPage' => $totalPage, 'totalProcess' => ceil(count($totalProcess) * ($percentage / 100)), 'totalMoney' => $totalPrice, 'list' => $list]);
    }
}
