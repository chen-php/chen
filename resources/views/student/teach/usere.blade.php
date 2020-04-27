@extends('public/layout')
@section('content')
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form"  method="post">
                  <input type="hidden" name="tid" value="{{$tid}}" />
                  <input type="hidden" name="mid" value="{{$mid}}" />
                  <input type="hidden" name="schoolyear" value="{{$schoolyear}}"/> 
                  <input type="hidden" name="term" value="{{$term}}" /> 
                  <div class="layui-form-item">
                     @foreach($comment as $k=>$v)
                     <div style="font-weight: 50px">
                      <label>{{$k = $k + 1}}、{{$v['cname']}}</label>
                    </div>
                    <h1></h1>
                      <div style="font-weight: 50px">
                          <input type="text" id="score" name="score[]" required="" 
                          autocomplete="off" class="layui-input" placeholder="请输入0到10的分数">
                      </div>
                      @endforeach
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          保存
                      </button>
                  </div>
              </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;

                //监听提交
                form.on('submit(add)',
                function(data) {
                    console.log(data);
                    //发异步，把数据提交给php

                    $.ajax({
                      type:'post',
                      url:'{{url('student/studentTeach')}}',
                      dataType:'json',
                      headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               },
                      data:data.field,
                      success:function(data){
                        //弹窗提示提交成功并刷新父页面
                        if(data.status==0){
                          layer.alert(data.message,{icon: 6},function(){
                            xadmin.close();
                            xadmin.father_reload();

                          });
                        }else{
                          layer.alert(data.message,{icon:5});
                        }
                      }
                      
                      });
                      
                    return false;
                });

            });
          </script>
@endsection
