@extends('public/layout')
@section('content')
@include('public/messages')
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
                            <p>请选择评教学年与学期：</p>
                            <form class="layui-form layui-col-space5" method="post" action="{{url('teacher/teacherTeachList')}}">
                                <div class="layui-input-inline layui-show-xs-block">
                                    <select name="schoolyear">
                                        <option  value="2016-2017">2016-2017</option>
                                        <option  value="2017-2018">2017-2018</option>
                                        <option  value="2018-2019">2018-2019</option>
                                        <option  value="2019-2020">2019-2020</option>
                                    </select>
                                    </div>
                                    <div class="layui-input-inline layui-show-xs-block">
                                    <select name="term">
                                        <option  value="1">第一学期</option>
                                        <option  value="2">第二学期</option>
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