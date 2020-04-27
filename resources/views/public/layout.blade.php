<!doctype html>
<html class="x-admin-sm">
    <head>
       @include('public/head')
    </head>
    <body class="index">
                @section('content')
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <iframe src='{{url('welcome')}}' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
                    </div>
                </div>

                <div id="tab_show"></div>
            </div>
        </div>
        <div class="page-content-bg"></div>
        <style id="theme_style"></style>
        @show
        <!-- 右侧主体结束 -->
    </body>
</html>