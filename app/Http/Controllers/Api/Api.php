<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Api extends Controller
{
    /**
     * @notes 业务返回exe端
     * @return \Illuminate\Http\JsonResponse
     */
    public function busins(){
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (!is_array($data)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        if (empty($data['channels']) || !isset($data['channels'])) {
            return response()->json(['code' => 400, 'msg' => '请选择渠道']);
        }
        $existBusin = DB::table('addchannel')->where(['channels' => $data['channels'], 'status' => 1])->value('reserved');
        $existBusins = explode(',', $existBusin);
      	if (!empty($existBusins)) {
          	foreach($existBusins as $k=>$v){
            	$count = DB::table('flow')->where(['bid' => $v])->count();
              	$magn = DB::table('addbusiness')->where(['ab_id' => $v])->value('ab_magnitude');
              	if ($magn == $count) {
                	unset($existBusins[$k]);
                }
            }
        	$res = DB::table('addbusiness')->where(['ab_reserved' => 1, 'ab_status' => 1])->whereIn('ab_id', $existBusins)->orderBy('ab_weights' ,'desc')->get()->map(function ($value) {
                return (array)$value;
            })->toArray();
        }
        return response()->json(['code' => 200, 'list' => $res]);
    }

    /**
     * @method 从exe获取渠道统计数据
     */
    public function getChannelStati(){
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (!is_array($data)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        /*if (array_search("", $data) !== false) {
            return response()->json(['code' => 400, 'msg' => '不能为空']);
        }*/
        $data = array_map('trim', $data);
        $datas = [
            'create_time' => time()
        ];
        $data = array_merge($data, $datas);
        $res = DB::table('channelstatistics')->insert($data);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '']);
        } else {
            return response()->json(['code' => 400, 'msg' => '获取渠道数据异常']);
        }
    }
    /**
     * @method 从exe获取渠道出量概况
     */
    public function getChannelOutput(){
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (!is_array($data)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        /*if (array_search("", $data) !== false) {
            return response()->json(['code' => 400, 'msg' => '不能为空']);
        }*/
        $data = array_map('trim', $data);
        $res = DB::table('output')->insert($data);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '']);
        } else {
            return response()->json(['code' => 400, 'msg' => '获取渠道数据异常']);
        }
    }
    /**
     * @method 从exe获取下载统计数据
     */
    public function getDownloadStati(){
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (!is_array($data)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        /*if (array_search("", $data) !== false) {
            return response()->json(['code' => 400, 'msg' => '不能为空']);
        }*/
        $data = array_map('trim', $data);
        $datas = [
            'createtime' => time()
        ];
        $data = array_merge($data, $datas);
        $res = DB::table('download')->insert($data);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '']);
        } else {
            return response()->json(['code' => 400, 'msg' => '获取下载数据异常']);
        }
    }
    /**
     * @method Exe报告执行错误的信息
     */
    public function getErrorStati(){
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (!is_array($data)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        /*if (array_search("", $data) !== false) {
            return response()->json(['code' => 400, 'msg' => '不能为空']);
        }*/
        $data = array_map('trim', $data);
        $datas = [
            'e_time' => time()
        ];
        $data = array_merge($data, $datas);
        $res = DB::table('errorinfo')->insert($data);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '']);
        } else {
            return response()->json(['code' => 400, 'msg' => '获取错误信息数据异常']);
        }
    }
    /**
     * @method Exe报告执行正确的信息
     */
    public function getSuccessStati(){
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (!is_array($data)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        /*if (array_search("", $data) !== false) {
            return response()->json(['code' => 400, 'msg' => '不能为空']);
        }*/
        $data = array_map('trim', $data);
        $datas = [
            'create_time' => time()
        ];
        $data = array_merge($data, $datas);
        $res = DB::table('succes')->insert($data);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '']);
        } else {
            return response()->json(['code' => 400, 'msg' => '获取错误信息数据异常']);
        }
    }
    /**
     * @method Exe流量统计
     */
    public function getFlowStati(){
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (!is_array($data)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        /*if (array_search("", $data) !== false) {
            return response()->json(['code' => 400, 'msg' => '不能为空']);
        }*/
        $data = array_map('trim', $data);
        $exist = DB::table('flow')->where(['bid' => $data['bid'], 'channel' => $data['channel'], 'qq' => $data['qq']])->get();
        if ($exist->first()) {
            $datas = [
                'time' => time(),
                'reserved' =>  1
            ];
        } else {
            $datas = [
                'time' => time(),
                'reserved' =>  2
            ];
        }
        $data = array_merge($data, $datas);
        $res = DB::table('flow')->insert($data);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '']);
        } else {
            return response()->json(['code' => 400, 'msg' => '获取错误信息数据异常']);
        }
    }

    /**
     * @method 获取exe终端信息
     */
    public function getTerminal(){
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (!is_array($data)) {
            return response()->json(['code' => 400, 'msg' => '数据异常']);
        }
        /*if (array_search("", $data) !== false) {
            return response()->json(['code' => 400, 'msg' => '不能为空']);
        }*/
        $data = array_map('trim', $data);
        $datas = [
            'create_time' => time()
        ];
        $data = array_merge($data, $datas);
        $res = DB::table('term')->insert($data);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '']);
        } else {
            return response()->json(['code' => 400, 'msg' => '获取exe终端异常']);
        }
    }
}
