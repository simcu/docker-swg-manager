<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>修改密码 | 和创未来</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic"
          rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/assets/css/animate.min.css" rel="stylesheet"/>
    <link href="/assets/css/style.min.css" rel="stylesheet"/>
    <link href="/assets/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="/assets/css/theme/default.css" rel="stylesheet" id="theme"/>
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top">
<!-- begin #page-loader -->
<div id="page-loader">
    <div class="material-loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
        </svg>
        <div class="message">Loading...</div>
    </div>
</div>
<!-- end #page-loader -->

<div class="login-cover">
    <div class="login-cover-image"><img src="/assets/img/login-bg/bg-{{rand(1,7)}}.jpg" data-id="login-cover-image"
                                        alt=""/></div>
    <div class="login-cover-bg"></div>
</div>
<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin login -->
    <div class="login login-v2" data-pageload-addclass="animated fadeIn">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                <span class="logo"></span> 和创未来
                <small>内部系统统一认证中心 - 修改密码</small>
            </div>
            <div class="icon">
                <i class="material-icons">lock</i>
            </div>
        </div>
        <!-- end brand -->
        <div class="login-content">
            <form method="POST" class="margin-bottom-0">
                @if($errors->has('oldpass')) <p style="color: red">{{$errors->first('oldpass')}}</p>  @endif
                <div class="form-group m-b-20">
                    <input type="password" class="form-control input-lg" name="oldpass" placeholder="旧密码"/>
                </div>
                @if($errors->has('password')) <p style="color: red">{{$errors->first('password')}}</p>  @endif
                <div class="form-group m-b-20">
                    <input type="password" class="form-control input-lg has-error" name="password" placeholder="新密码"/>
                </div>
                <div class="form-group m-b-20">
                    <input type="password" class="form-control input-lg" name="password_confirmation" placeholder="再输一次"/>
                </div>
                {{ csrf_field() }}
                <div class="login-buttons">
                    <button type="submit" class="btn btn-info btn-block btn-lg">修改密码</button>
                </div>
                <br>
                <a href="/"><< 返回首页</a>
            </form>
        </div>
    </div>
    <!-- end login -->
</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="/assets/crossbrowserjs/html5shiv.js"></script>
<script src="/assets/crossbrowserjs/respond.min.js"></script>
<script src="/assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="/assets/js/login-v2.demo.min.js"></script>
<script src="/assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    @if (session('msg'))
           alert("{{ session('msg') }}")
    @endif
    $(document).ready(function () {
        App.init();
        LoginV2.init();
    });
</script>
</body>
</html>
