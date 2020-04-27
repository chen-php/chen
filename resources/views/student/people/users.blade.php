@extends('public/layout')
@section('content')
 <div class="x-nav">
  @include('public/messages')
          <span class="layui-breadcrumb">
            <a href="{{url('index')}}">首页</a>
            <a>
              <cite>个人信息列表</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                        </div>
                        <div class="layui-card-header">
                            
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            @foreach($list as $v)
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>学号</th>
                                    <th>姓名</th>
                                    <th>专业</th>
                                    <th>籍贯</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>{{$v->sid}}</td>
                                    <td>{{$v->username}}</td>
                                    <td>{{$v->profession}}</td>
                                    <td>{{$v->address}}</td>
                                   </tr>
                                </tbody>
                            </table>
                            <table>
                                <tr>
                                  <th>性别：</th>
                                  <td>{{$v->sex}}</td>
                                </tr>
                                <tr>
                                  <th>电话：</th>
                                  <td>{{$v->tel}}</td>
                                </tr>
                                <tr>
                                  <th>出生日期：</th>
                                  <td>{{$v->birthday}}</td>
                                </tr>
                                <tr>
                                  <th>兴趣爱好：</th>
                                  <td>{{$v->hobby}}</td>
                                </tr>
                                <tr>
                                  <th>个人简介：</th>
                                  <td>{{$v->profile}}</td>
                                </tr>
                                </table>
                                <p  align="right"><a title="编辑"  onclick="xadmin.open('编辑','{{route('student/studentEdit', ['sid' => $v->sid])}}',600,400)" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                      </a></p>
                                @endforeach
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
        <script type="text/javascript">
     function member_del(obj,sid){
      //console.log(id);
      //console.log(obj);
      layer.confirm('确认要删除吗？',function(index){
        $.ajax({
                      type:'GET',
                      url:'{{url('studentDelete')}}',
                      dataType:'json',
                      headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               },
                      data:{"sid":sid},
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
@endsection