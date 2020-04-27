@extends('public/layout')
@section('content')
 @include('public/messages')
        <div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="index">首页</a>
                <a>
                    <cite>成绩查询页面</cite></a>
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
                            <p>请选择学年</p>
                                <form class="layui-form layui-col-space5" method="gets" action="{{url('student/studentChooseYear')}}">
                                <input type="hidden" name="schoolyear" value="" class="input-xlarge">
                                <div class="layui-input-inline layui-show-xs-block">
                                    <select name="schoolyear" style="width:200px">
                                       <option  value="2016-2017" @if($schoolyear=="2016-2017") selected @endif>2016-2017</option>
                                       <option  value="2017-2018" @if($schoolyear=="2017-2018") selected @endif>2017-2018</option>
                                       <option  value="2018-2019" @if($schoolyear=="2018-2019") selected @endif>2018-2019</option>
                                       <option  value="2019-2020" @if($schoolyear=="2019-2020") selected @endif>2019-2020</option>
                                    </select>
                                </div>
                                
                                <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="sreach">按学年查询成绩</button>
                                </div>
                            </form>
                                <p>请选择科目：</p>
                            <form class="layui-form layui-col-space5" method="get" action="{{url('student/studentChooseSubject')}}">
                                <input type="hidden" name="subject" value="" class="input-xlarge">
                                <div class="layui-input-inline layui-show-xs-block">
                                    <select name="subject" style="width:200px">
                                       @foreach($subject as $v)
                                      <option value="{{$v['id']}}">{{$v['sname']}}</option>
                                       @endforeach
                                    </select>
                                </div>
                                
                                <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="sreach">按科目查询成绩</button>
                                </div>
                            </form> 
                        </div>
                         <div class="layui-card-body layui-table-body layui-table-main">
                            
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>学年</th>
                                    <th>学期</th>
                                    <th>科目</th>
                                    <th>分数</th>
                                    <th>绩点</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $v)
                                  <tr>
                                    <td>{{$v['schoolyear']}}</td>
                                    <td>{{$v['term']}}</td>
                                    <td>{{$v['kname']}}</td>
                                    <td>{{$v['score']}}</td>
                                    <td>{{$v['gpa']}}</td>
                                   </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                 {{ $data->links() }}
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
    @include('public/footer')
@endsection