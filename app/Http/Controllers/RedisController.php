<?php
namespace App\Http\Controllers;



use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function testRedis() {
        Redis::set('name', 'wsphp');
        $res = Redis::get('name');
        dd($res);
    }
}