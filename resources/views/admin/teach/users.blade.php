@extends('public/layout')
@section('content')
        <div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="index">首页</a>
                <a>
                    <cite>选择教师页面</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
                <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
            </a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <p>请选择查看的教师</p>
                            <form class="layui-form layui-col-space5" method="post" action="{{url('teach')}}">
                                <div class="layui-input-inline layui-show-xs-block">
                                    <select name="teacher">
                                        @foreach($teacher as $v)
                                        <option value="{{$v['sid']}}">{{$v['username']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="sreach">选择</button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-body ">
                            
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script>layui.use(['laydate', 'form'],
        function() {
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#start' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#end' //指定元素
            });
        });
    </script>
@endsection