@extends('public/layout')
@section('content')
        <div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="index">首页</a>
                <a href="teach">教学质量评价</a>
                <a>
                    <cite>同行评教结果查看</cite></a>
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
                            <h4>同行教评总阅：</h4>
                             <div class="layui-input-inline" style="width:720px;float:left">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>题目</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 @foreach($comment as $v)
                               <tr>
                                  <td>{{$v['cname']}}</td>
                                </tr>
                                 @endforeach
                                </tbody>
                            </table>
                          </div>
                           <div class="layui-input-inline" style="width:125px;float:left">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>好评率</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      <td>{{$thao1*100}}%</td>
                                    </tr>
                                    <tr>
                                      <td>{{$thao2*100}}%</td>
                                    </tr>
                                    <tr>
                                      <td>{{$thao3*100}}%</td>
                                    </tr>
                                </tbody>
                            </table>
                          </div>
                           <div class="layui-input-inline" style="width:125px;float:left">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>得分占比率</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      <td>{{$zhanbi1}}</td>
                                    </tr>
                                    <tr>
                                      <td>{{$zhanbi2}}</td>
                                    </tr>
                                    <tr>
                                      <td>{{$zhanbi3}}</td>
                                    </tr>
                                </tbody>
                            </table>
                          </div>
                            <div class="layui-input-inline" style="width:90px;float:left">
                            <table class="layui-table layui-form">
                              <thead>
                              <tr>
                                <th>总排名</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr style="height: 117px">
                                <td>{{$p}}</td>
                              </tr>
                            </tbody>
                            </table>
                            </div>
                            <div>
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>学号</th>
                                    <th>评教科目</th>
                                    <th>评教教师名</th>
                                    <th>分数</th>
                                  </tr>
                                </thead>
                                <tbody>
                                 @foreach($list as $z)
                                  <tr>
                                    <td>{{$z['aid']}}</td>
                                    <td>{{$z['sname']}}</td>
                                    <td>{{$z['username']}}</td>
                                    <td>{{$z['tscore']}}</td>
                                 </tr>
                                  @endforeach
                                </tbody>
                            </table>
                            <table class="layui-table layui-form">
                               
                            </table>
                            <table class="layui-table layui-form">
                               
                            </table>
                        </div>
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