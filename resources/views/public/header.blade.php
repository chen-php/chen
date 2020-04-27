<!-- 顶部开始 -->
        <div class="container">
            <div class="logo">
                <a style="font-size:x-small">基于php的考试成绩查询和评教系统</a>
            </div>
            <div class="left_open">
                <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
            </div>
            <ul class="layui-nav right" lay-filter="">
                <li class="layui-nav-item">
                    @if(!empty(session('admin')))
                    <a href="javascript:;">管理员：{{session('admin')}}</a>
                    @elseif(!empty(session('user')))
                    <a href="javascript:;">学校领导：{{session('user')}}</a>
                    @elseif(!empty(session('teacher')))
                    <a href="javascript:;">教师：{{session('teacher')}}</a>
                    @elseif(!empty(session('student')))
                    <a href="javascript:;">学生：{{session('student')}}</a>
                    @endif
                    <dl class="layui-nav-child">
                        <!-- 二级菜单 -->
                        <dd>
                            <a href="{{url('logout')}}">切换帐号</a></dd>
                        <dd>
                            <a href="{{url('logout')}}">退出</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item to-index">
                    <a href="index">首页</a></li>
            </ul>
        </div>