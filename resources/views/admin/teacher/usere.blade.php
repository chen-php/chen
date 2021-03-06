@extends('public/layout')
@section('content')
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form"  method="post">
                  <div class="layui-form-item">
                      <label for="sid" class="layui-form-label">
                          <span class="x-red">*</span>工号
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="sid" name="sid" required="" 
                          autocomplete="off" class="layui-input">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>将会成为唯一的登入用户名
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>姓名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="username" name="username" required="" 
                          autocomplete="off" class="layui-input">
                      </div>
                  </div>
                    <div class="layui-form-item">
                      <label for="pass" class="layui-form-label">
                          <span class="x-red">*</span>密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="passwd" name="passwd" required="" 
                          autocomplete="off" class="layui-input">
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="category" class="layui-form-label">
                          <span class="x-red">*</span>身份ID
                      </label>
                      <div class="layui-input-inline">
                          <input type="text"  value="3" id="category" name="category" required="" 
                          autocomplete="off" class="layui-input" readonly="readonly">
                      </div>
                  </div>
                   <div class="layui-form-item">
                      <label for="address" class="layui-form-label">
                          <span class="x-red">*</span>籍贯
                      </label>
                      <div class="layui-input-inline">
                          <input  type="text" rows="3" name="address" class="layui-input"></input>
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="sex" class="layui-form-label">
                          <span class="x-red">*</span>性别
                      </label>
                      <div class="layui-input-inline">
                           <input type="text" id="sex" name="sex" required="" 
                          autocomplete="off" class="layui-input">
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
                      url:'{{url('teacherA')}}',
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
