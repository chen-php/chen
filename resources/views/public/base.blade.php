<!doctype html>
<html class="x-admin-sm">
    <head>
       @include('public/head')
    </head>
    <body class="index">
        <!-- 顶部开始 -->
        @include('public/header')
        <!-- 顶部结束 -->
        <!-- 中部开始 -->
        <!-- 左侧菜单开始 -->
        @include('public/menu')
        <!-- 右侧主体开始 -->
       <div class="page-content">
            <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
                <ul class="layui-tab-title">
                    <li class="home">
                        <i class="layui-icon">&#xe68e;</i>我的首页</li></ul>
                <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                    <dl>
                        <dd data-type="this">关闭当前</dd>
                        <dd data-type="other">关闭其它</dd>
                        <dd data-type="all">关闭全部</dd></dl>
                </div>
        <!-- 中部结束 -->
        @include('public/layout')
    </body>

</html>