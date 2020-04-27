@extends('public/layout')
@section('content')
 <div class="x-nav">
  @include('public/messages')
          <span class="layui-breadcrumb">
            <a href="{{url('index')}}">首页</a>
            <a>
              <cite>领导列表</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5" action="{{url('userFind')}}" method="post">
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" id="findusername"  name="findusername" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit=""  lay-filter="sreach" type="submit"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn" onclick="xadmin.open('添加用户','{{url('userAdd')}}',600,400)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>工号</th>
                                    <th>用户名</th>
                                    <th>电话号码</th>
                                    <th>身份ID</th>
                                    <th>籍贯</th>
                                    <th>性别</th>
                                    <th>操作</th></tr>
                                </thead>
                                <tbody>
                                 @foreach($list as $v)
                                  <tr>
                                    <td>{{$v->sid}}</td>
                                    <td>{{$v->username}}</td>
                                    <td>{{$v->tel}}</td>
                                    <td>{{$v->category}}</td>
                                    <td>{{$v->address}}</td>
                                    <td>{{$v->sex}}</td>
                                    <td>
                                      <a title="编辑"  onclick="xadmin.open('编辑','{{route('userEdit', ['id' => $v->id])}}',600,400)" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                      </a>
                                      <a title="删除"  id="delete"  onclick="member_del(this,{{$v->id}})" href="javascript:;">
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
     function member_del(obj,id){
      //console.log(id);
      //console.log(obj);
      layer.confirm('确认要删除吗？',function(index){
        $.ajax({
                      type:'GET',
                      url:'{{url('userDelete')}}',
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
@endsection