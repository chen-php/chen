@extends('public/layout')
@section('content')
<div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                        	@if(!empty(session('admin')))
                            <blockquote class="layui-elem-quote">欢迎管理员：
                                <span class="x-black">{{session('admin')}}</span>
                            </blockquote>
                            @elseif(!empty(session('student')))
                            <blockquote class="layui-elem-quote">欢迎学生：
                                <span class="x-black">{{session('student')}}</span>
                            </blockquote>
                            @elseif(!empty(session('teacher')))
                            <blockquote class="layui-elem-quote">欢迎教师：
                                <span class="x-black">{{session('teacher')}}</span>
                            </blockquote>
                            @elseif(!empty(session('user')))
                            <blockquote class="layui-elem-quote">欢迎学校领导：
                                <span class="x-black">{{session('user')}}</span>
                            </blockquote>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12">
                    <div class="layui-card">
                    	
                        </div>
                    </div>
            </div>
</div>
@include('public/footer')
@endsection
