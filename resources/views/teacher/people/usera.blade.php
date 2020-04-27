@extends('public/layout')
@section('content')
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form"  method="post">
                  <input type="hidden" name="sid" value="{{$one->sid}}" class="input-xlarge">
                  <div class="layui-form-item">
                      <label for="sid" class="layui-form-label">
                          <span class="x-red">*</span>工号
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="sid" name="sid" required="" 
                          autocomplete="off" class="layui-input" value="{{$one->sid}}">
                      </div>
                      <div class="layui-form-mid layui-word-aux">
                          <span class="x-red">*</span>唯一的登入用户名
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>姓名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="username" name="username" required="" 
                          autocomplete="off" class="layui-input" value="{{$one->username}}">
                      </div>
                  </div>
                    <div class="layui-form-item">
                      <label for="pass" class="layui-form-label">
                          <span class="x-red">*</span>密码
                      </label>
                      <div class="layui-input-inline">
                          <input type="password" id="passwd" name="passwd" required="" 
                          autocomplete="off" class="layui-input" value="{{$one->passwd}}">
                      </div>
                  </div>
                   <div class="layui-form-item">
                      <label for="address" class="layui-form-label">
                          <span class="x-red">*</span>籍贯
                      </label>
                      <div class="layui-input-inline">
                          <input  type="text"  name="address" class="layui-input" value="{{$one->address}}"></input>
                      </div>
                  </div>
                   <div class="layui-form-item">
                      <label for="address" class="layui-form-label">
                          <span class="x-red">*</span>电话
                      </label>
                      <div class="layui-input-inline">
                          <input  type="text"  name="tel" class="layui-input" value="{{$one->tel}}"></input>
                      </div>
                  </div>
                   <div class="layui-form-item">
                      <label for="address" class="layui-form-label">
                          <span class="x-red">*</span>出生日期
                      </label>
                      <div class="layui-input-inline">
                          <input  type="text"  name="birthday" class="layui-input" value="{{$one->birthday}}"></input>
                      </div>
                  </div>
                   <div class="layui-form-item">
                      <label for="address" class="layui-form-label">
                          <span class="x-red">*</span>兴趣爱好
                      </label>
                      <div class="layui-input-inline">
                          <input  type="text"  name="hobby" class="layui-input" value="{{$one->hobby}}"></input>
                      </div>
                  </div>
                   <div class="layui-form-item">
                      <label for="address" class="layui-form-label">
                          <span class="x-red">*</span>个人简介
                      </label>
                      <div class="layui-input-inline">
                          <input  type="text" rows="3" name="profile" class="layui-input" value="{{$one->profile}}"></input>
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="sex" class="layui-form-label">
                          <span class="x-red">*</span>性别
                      </label>
                      <div class="layui-input-inline">
                           <input type="text" id="sex" name="sex" required="" 
                          autocomplete="off" class="layui-input" value="{{$one->sex}}">
                      </div>
                  </div>
                  <div class="layui-form-item">
                      <label for="L_repass" class="layui-form-label">
                      </label>
                      <button  class="layui-btn" lay-filter="add" lay-submit="">
                          修改
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
                    //console.log(data);
                    //发异步，把数据提交给php

                    $.ajax({
                      type:'POST',
                      url:'{{url('teacher/teacherE')}}',
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
