@extends('public/layout')
@section('content')
        <div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="index">首页</a>
                <a href="teach">选择教师页面</a>
                <a>
                    <cite>评教列表</cite></a>
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
                            <p>请选择查看的教师</p>(当前查看的教师：{{$teachers}})
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
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                               <h2>领导评教：</h2>
                                <thead>
                                  <tr>
                                    <th>工号</th>
                                    <th>评教科目</th>
                                    <th>评教领导名</th>
                                    <th>分数</th>
                                    <th>操作</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 @foreach($list as $v)
                                  <tr>
                                    <td>{{$v['uid']}}</td>
                                    <td>{{$v['sname']}}</td>
                                    <td>{{$v['username']}}</td>
                                    <td>{{$v['tscore']}}</td>
                                    <td>
                                      <a title="删除"  id="delete"  onclick="member_del(this,{{$v['id']}})" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                      </a>
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <table class="layui-table layui-form">
                               <h2>同行评教：</h2>
                                <thead>
                                  <tr>
                                    <th>工号</th>
                                    <th>评教科目</th>
                                    <th>评教教师名</th>
                                    <th>分数</th>
                                    <th>操作</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 @foreach($listss as $b)
                                  <tr>
                                     <td>{{$b['aid']}}</td>
                                     <td>{{$b['sname']}}</td>
                                     <td>{{$b['username']}}</td>
                                     <td>{{$b['tscore']}}</td>
                                     <td>
                                      <a title="删除"  id="delete"  onclick="member_del(this,{{$b['id']}})" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                      </a>
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <table class="layui-table layui-form">
                               <h2>学生评教:</h2>
                                <thead>
                                  <tr>
                                    <th>学号</th>
                                    <th>评教科目</th>
                                    <th>评教学生名</th>
                                    <th>分数</th>
                                    <th>操作</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 @foreach($lists as $z)
                                  <tr>
                                      <td>{{$z['sid']}}</td>
                                      <td>{{$z['sname']}}</td>
                                      <td>{{$z['username']}}</td>
                                      <td>{{$z['tscore']}}</td>
                                      <td>
                                      <a title="删除"  id="delete"  onclick="member_del(this,{{$z['id']}})" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                      </a>
                                    </td>
                                  </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('public/footer')
        <script type="text/javascript">
     function member_del(obj,id){
      //console.log(id);
      //console.log(obj);
      layer.confirm('确认要删除吗？',function(index){
        $.ajax({
                      type:'GET',
                      url:'{{url('teachDelete')}}',
                      dataType:'json',
                      headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               },
                      data:{"id":id},
                      success:function(data){
                        //弹窗提示提交成功并刷新父页面
                        if(data.status==0){
                          $(obj).parents("tr").remove();
                          layer.msg(data.message,{icon:6,time:1000});
                        }else{
                          layer.msg(data.message,{icon:5,time:1000});
                        }
                      }
                      
                      });
           
        });

     }

     </script>
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