<!DOCTYPE html>
<html lang="en">
<head>
    @include('public/head')
</head>
<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body class="">
<!--<![endif]-->
<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav pull-right">

        </ul>
        <a class="brand" href="{{url('index')}}"><span class="first">基于php的考试成绩查询和评教系统</span></a>
    </div>
</div>
<div class="row-fluid">
    <div class="dialog">
        <div class="block">
            <p class="block-heading">登陆</p>
              <div class="block-body">
                <!--@if (!empty($errors))
                    <div>
                    @if(is_object($errors))
                        @foreach ($errors->all() as $error)
                            <script>alert('{{$error}}')</script>
                        @endforeach
                    @else
                    <script>alert('{{$errors}}')</script>
                @endif   
                     </div>
                @endif-->
                @include('public/messages')
                <form name="myForm" action="{{url('getlogin')}}" onsubmit="return validateForm()" method="post">
                    {{csrf_field()}}
                    <label>用户名</label>
                    <input type="text" class="span12" name="uname"  />
                    <label>密码</label>
                    <input type="password" class="span12" name="pwd" /> 
                    <button type="submit" class="btn btn-primary pull-right">提交</button>
					<label class="remember-me"><input type="checkbox" value="1"> 记住我</label>
                    
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <p class="pull-right" style=""><a href="#" target="blank">基于php的考试成绩查询和评教系统</a></p>
    </div>
</div>
<script src="{{asset('lib/bootstrap/js/bootstrap.js')}}"></script>
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
    $(function() {
        $('.demo-cancel-click').click(function(){return false;});
    });
</script>
<script>
function validateForm()
{
	var x=document.forms["myForm"]["uname"].value;
	if(x==null||x=="")
	{
	 alert("用户名不能为空！！");
	 return false;
	}
	var y=document.forms["myForm"]["pwd"].value;
	if(y==null||y=="")
	{
	 alert("密码不能为空！！");
	 return false;
	}
}
</script>
</body>
</html>


