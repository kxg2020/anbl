<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>Login</title>

    <link href="/Public/css/style.css" rel="stylesheet">
    <link href="/Public/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/Public/js/html5shiv.js"></script>
    <script src="/Public/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-body">

<div class="container">

    <form class="form-signin">
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">阿纳巴里后台登录</h1>
            <img src="/Public/images/login-logo.png" alt=""/>
        </div>
        <div class="login-wrap">
            <input type="text" class="form-control" placeholder="用户名" autofocus name="username">
            <input type="password" class="form-control" placeholder="密码" name="password">
            <input type="text" style="height: 38px;outline: none;margin-right: 33px" placeholder="验证码" name="captcha"><img style="cursor: pointer" src="<?php echo U('admin/Login/captcha');?>" id="captcha">


            <button class="btn btn-lg btn-login btn-block" type="button" id="submit">
                <i class="fa fa-check"></i>
            </button>
            <label class="checkbox">
                <input type="checkbox" value="1" name="remember"> 记住我的登录信息
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> 忘记密码?</a>

                </span>
            </label>

        </div>

        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">忘记密码 ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>请输入你的邮箱.</p>
                        <input type="text"  placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
                        <button class="btn btn-primary" type="button">提交</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

    </form>

</div>



<!-- Placed js at the end of the document so the pages load faster -->

<!-- Placed js at the end of the document so the pages load faster -->
<script src="/Public/js/jquery-1.10.2.min.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>
<script src="/Public/js/modernizr.min.js"></script>
<script src='/Public/layer/layer.js'></script>
<script>
    $(function () {
        $('#captcha').click(function () {
            $(this).attr({'src':location.protocol+'//'+window.location.host+'/admin/Login/captcha/id/'+Math.random(0,999)});
        });
        $('#submit').click(function () {
            username = $('input[name = username]').val();
            password = $('input[name = password]').val();
            captcha = $('input[name = captcha]').val();
            if(username == ''){

                layer.tips('用户名不能为空','input[name = username]');
                return false;
            }
            if(password == ''){

                layer.tips('密码不能为空','input[name = password]');
                return false;
            }
            if(captcha == ''){

                layer.tips('验证码不能为空','input[name = captcha]',{tips:4});
                return false;
            }
            $.ajax({
                'type':'post',
                'dataType':'json',
                'url':location.protocol+'//'+window.location.host+'/admin/Login/login',
                'data':{'username':username,'password':password,'captcha':captcha},
                success:function (e) {
                    if(e.status == 1){
                        window.location.href = location.protocol+'//'+window.location.host+'/admin/Index/index'
                    }else {
                        layer.msg(e.msg);
                    }
                }
            });
        });
    });
</script>

</body>
</html>