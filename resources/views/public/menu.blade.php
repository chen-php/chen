<!-- 左侧菜单开始 -->
        <div class="left-nav">
            <div id="side-nav">
                @if(session('admin'))
                <ul id="nav">
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="用户管理">&#xe6b8;</i>
                            <cite>用户管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('领导列表','{{url('user')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>领导列表</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('教师列表','{{url('teacher')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>教师列表</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('学生列表','{{url('student')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>学生列表</cite></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="部门管理">&#xe723;</i>
                            <cite>部门管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('部门列表','{{url('department')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>部门列表</cite></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="成绩管理">&#xe723;</i>
                            <cite>成绩管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('成绩列表','{{url('exam')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>成绩列表</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('科目列表','{{url('subject')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>科目列表</cite></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="评教管理">&#xe723;</i>
                            <cite>评教管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('题目列表','{{url('comment')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>题目列表</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('评教列表','{{url('teach')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>评教列表</cite></a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
                @endif
                 @if(session('teacher'))
                <ul id="nav">
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="信息维护">&#xe6b8;</i>
                            <cite>信息维护</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('个人信息','{{url('teacher/xinxi')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>个人信息</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('教学科目列表','{{url('teacher/teacherSubjectList')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>教学科目列表</cite></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="学生成绩管理">&#xe723;</i>
                            <cite>学生成绩管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('学生成绩列表','{{url('teacher/studentExamList')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>学生成绩列表</cite></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="教学质量评价">&#xe723;</i>
                            <cite>教学质量评价</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('同行评教','{{url('teacher/teacherTeachList')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>同行评教</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('学生评教结果查看','{{url('teacher/teacherTeachL')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>学生评教结果查看</cite></a>
                            </li>
                             <li>
                                <a onclick="xadmin.add_tab('同行评教结果查看','{{url('teacher/teacherTeachLs')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>同行评教结果查看</cite></a>
                            </li>
                             <li>
                                <a onclick="xadmin.add_tab('领导评教结果查看','{{url('teacher/teacherTeachLss')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>领导评教结果查看</cite></a>
                            </li>
                        </ul>
                    </li>      
                </ul>
                @endif
                @if(session('student'))
                <ul id="nav">
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="信息维护">&#xe6b8;</i>
                            <cite>信息维护</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('个人信息','{{url('student/xinxi')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>个人信息</cite></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="信息查询">&#xe723;</i>
                            <cite>信息查询</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('成绩查询','{{url('student/studentExamList')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>成绩查询</cite></a>
                            </li>
                             <li>
                                <a onclick="xadmin.add_tab('课程查询','{{url('student/studentSubjectList')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>课程查询</cite></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="教学质量评价">&#xe723;</i>
                            <cite>教学质量评价</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('学生评教','{{url('student/studentTeachList')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>学生评教</cite></a>
                            </li>
                        </ul>
                    </li>      
                </ul>
                @endif
                @if(session('user'))
                <ul id="nav">
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="信息维护">&#xe6b8;</i>
                            <cite>信息维护</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('个人信息','{{url('user/xinxi')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>个人信息</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('科目列表','{{url('subject')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>科目列表</cite></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont left-nav-li" lay-tips="教学质量评价">&#xe723;</i>
                            <cite>教学质量评价</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('领导评教','{{url('user/userTeachList')}}')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>领导评教</cite></a>
                            </li>
                        </ul>
                    </li>      
                </ul>
                @endif
            </div>
        </div>
        <!-- <div class="x-slide_left"></div> -->
        <!-- 左侧菜单结束 --> 
        