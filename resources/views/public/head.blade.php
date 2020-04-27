 <meta charset="UTF-8">
        <title>基于php的考试成绩查询和评教系统</title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!--<meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />-->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="{{asset('css/font.css')}}">
        <link rel="stylesheet" href="{{asset('css/xadmin.css')}}">
        <!-- <link rel="stylesheet" href="./css/theme5.css"> -->
        <script src="{{asset('lib/jquery-1.7.2.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('lib/layui/layui.js')}}" charset="utf-8"></script>
        <script src="{{asset('lib/bootstrap/js/bootstrap.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/xadmin.js')}}"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            // 是否开启刷新记忆tab功能
            // var is_remember = false;
        </script>