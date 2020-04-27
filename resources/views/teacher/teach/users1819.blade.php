@extends('public/layout')
@section('content')
 <div class="x-nav">
  @include('public/messages')
          <span class="layui-breadcrumb">
            <a href="{{url('index')}}">首页</a>
            <a>
              <cite>2016-2017学年评教列表</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                             <p>请选择评教学年与学期：</p>
                            <form class="layui-form layui-col-space5" method="post" action="{{url('teacher/teacherTeachList')}}">
                                <input type="hidden" name="choose" value="" class="input-xlarge">
                                <div class="layui-input-inline layui-show-xs-block">
                                    <select name="schoolyear">
                                        <option  value="2016-2017" @if($schoolyear =="2016-2017")selected @endif>2016-2017</option>
                                        <option  value="2017-2018" @if($schoolyear =="2017-2018")selected @endif>2017-2018</option>
                                        <option  value="2018-2019" @if($schoolyear =="2018-2019")selected @endif>2018-2019</option>
                                        <option  value="2019-2020" @if($schoolyear =="2019-2020")selected @endif>2019-2020</option>
                                    </select>
                                    </div>
                                    <div class="layui-input-inline layui-show-xs-block">
                                    <select name="term">
                                        <option  value="1" @if($terms ==1)selected @endif>第一学期</option>
                                        <option  value="2" @if($terms ==2)selected @endif>第二学期</option>
                                    </select>
                                </div>
                                
                                <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="sreach">选择</button>
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
                                     <th>教师名</th>
                                     <th>得分</th>
                                    <th>操作</th></tr>
                                </thead>
                                <tbody>
                                 @foreach($lists as $v)
                                  <tr>
                                    <td>{{$v['schoolyear']}}</td>
                                    <td>{{$v['term']}}</td>
                                    <td>{{$v['sname']}}</td>
                                    <td>{{$v['username']}}</td>
                                    <td>{{$v['score']}}</td>
                                    <td>
                                    @if($v['score']==0||$v['score']=="")
                                      <a title="评教"  onclick="xadmin.open('评教','{{route('teacher/teacherTeachA', ['tid' => $v['tid'],'mid'=>$v['id'],'term'=>$v['term'],'schoolyear'=>$v['schoolyear']])}}',600,400)" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                      </a>
                                      @endif
                                      @if($v['score']!=0)
                                      <p>已评教</p>
                                      @endif
                                   </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
                                 {{ $list->links() }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        @include('public/footer')
        
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