@extends('public/layout')
@section('content')
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form"  method="post">
                  <div class="layui-form-item">
                      <label for="sid" class="layui-form-label">
                          <span class="x-red">*</span>编号
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="id" name="id" required="" 
                          autocomplete="off" class="layui-input">
                      </div>
                  <div class="layui-form-item">
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>部门名
                      </label>
                      <div class="layui-input-inline">
                          <input type="text" id="name" name="name" required="" 
                          autocomplete="off" class="layui-input">
                      </div>
                  </div>
                   <div class="layui-form-item">
                      <label for="address" class="layui-form-label">
                          <span class="x-red">*</span>简介
                      </label>
                      <div class="layui-input-inline">
                          <input  type="text" rows="3" name="synopsis" class="layui-input"></input>
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
                      url:'{{url('departmentA')}}',
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
