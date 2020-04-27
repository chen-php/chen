@extends('public/layout')
@section('content')
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form"  method="post">
                  <div class="layui-form-item">
                      <label for="sid" class="layui-form-label">
                          <span class="x-red">*</span>分数
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="score" name="score" required="" 
                          autocomplete="off" class="layui-input">
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>学生姓名
                      </label>
                      <div class="layui-input-inline">
                          <select type="text" id="xid" name="xid" required="" 
                          autocomplete="off" class="layui-input">
                           @foreach($student as $v)
                                <option value="{{$v['sid']}}">{{$v['username']}}</option>
                           @endforeach
                        </select>
                      </div>
                  </div>
                    <div class="layui-form-item">
                      <label for="pass" class="layui-form-label">
                          <span class="x-red">*</span>科目
                      </label>
                      <div class="layui-input-inline">
                          <select type="text" id="sid" name="sid" required="" 
                          autocomplete="off" class="layui-input">
                          @foreach($subject as $v)
                                    <option value="{{$v['id']}}">{{$v['sname']}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          增加
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
                      type:'POST',
                      url:'{{url('examA')}}',
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
