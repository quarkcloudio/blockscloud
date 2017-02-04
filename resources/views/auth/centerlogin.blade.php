<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>wanpiao</title>
  <!-- Bootstrap 核心 CSS 文件 -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    body{
      background-image:url({{asset('images/wallpapers/Lake.jpg')}});
      padding-top: 0px;
      padding-bottom: 0px;
    }
    .blur {
        filter: url(blur.svg#blur); /* FireFox, Chrome, Opera */
        -webkit-filter: blur(10px); /* Chrome, Opera */
        -moz-filter: blur(10px);
        -ms-filter: blur(10px);    
        filter: blur(10px);
        filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=10, MakeShadow=false); /* IE6~IE9 */
    }
    .login-container {
      position: relative;
    }
    .login-wallpaper{
	    position: absolute;
      z-index: 8;
    }
    .login-box{
	    position: absolute;
      width: 185px;
      left:35%;
      top:180px;
      z-index: 10;
    }
    .login-box input{
      height: 30px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-wallpaper">
      <img src="{{asset('images/wallpapers/Lake.jpg')}}" width="100%" class="blur" />
    </div>
    <div class="login-box">
      <form class="form-horizontal" id='form'>
        <div style="width:100%; text-align: center; margin-bottom:60px;"><img src="{{asset('images/icons/logo.png')}}" width="73"></div>
        <div class="form-group">
          <label class="sr-only">用户名</label>
          <input type="text" name='username' class="form-control" style="background:rgba(0,0,0,0.50);filter: alpha(opacity=50);color:#fff;" placeholder="输入用户名">
        </div>
        <div class="form-group">
          <label class="sr-only">密码</label>
          <input type="password" name='password' class="form-control" style="background:rgba(0,0,0,0.50);filter: alpha(opacity=50);color:#fff;" placeholder="输入密码">
        </div>
        <div class="form-group">
          <span style="color:#fff; font-size:24px;">按enter键登录</span>
        </div>
        {!! csrf_field() !!}
      </form>
    </div>
  </div><!-- /.container -->
  <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
  <script src="{{asset('js/vendor/jquery/1.11.3/jquery.min.js')}}"></script>
  <script>
    $(document).ready(function(){  
        //初始化高度  
        $(".blur").height($(window).height()).width($(window).width());
        $(".login-box").css('left',($(window).width()-185)/2);
        //当文档窗口发生改变时 触发  
        $(window).resize(function(){  
          $(".blur").height($(window).height()).width($(window).width());
        })
        $("body").keydown(function(event) {
          if (event.keyCode =="13"){
            $.ajax({
              cache: true,
              type: "POST",
              url : '{{ url('center/login') }}',
              data: $('#form').serialize(),
              async: false,
                success: function(data) {
                  if (data.code == 1) {
                    // alert(data.msg);
                    setTimeout(function () {
                      location.href = data.url;
                    }, 1000);
                  } else {
                      alert(data.msg);
                  }
                },
                error: function(request) {
                  alert("页面错误");
                }
            });
          }
        })
    });
  </script>
</body>
</html>