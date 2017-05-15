<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/wang/reset.css">
	<link rel="stylesheet" href="/Public/wang/login_reg.css">
	<title>登录-阿纳巴里</title>
</head>
<body>
	<div class="bg">
		<div class="content">
			<div class="logo"><a class="logo" href="<?php echo U('home/index/index');?>"><img src="/Public/wang/img/logimg.png" alt=""></a></div>
			<p class="title">用户登录</p>
			<div class="user"><input type="text" name="username"><i></i></div>
			<div class="pwd"><input type="password" name="password"><i></i></div>
			<div class="login">立即登录</div>
			<div class="reg_forget"><p class="fast_reg"><a href="<?php echo U('home/register/index');?>">快速注册</a></p><p class="forget_pwd"><a href="<?php echo U('home/login/forget');?>">忘记密码?</a></p></div>
		</div>
	</div>
	<script src='/Public/wang/jquery-1.12.4.min.js'></script>
	<script src='/Public/layer/layer.js'></script>
	<script>
		$(function(){
			function login(){
			
				//>> 获取用户名
				var username = $("input[name = username]").val();
				var password = $("input[name = password]").val();
				if(username == ''){
					layer.tips('用户名不能为空!','input[name = username]');
				}else{
					//>> 判断用户名的格式是否正确
					var _reg = /^0?(13|14|15|17|18)[0-9]{9}$/;
					if(!_reg.test(username)){
						layer.tips('用户名的格式不正确!','input[name = username]');
						return ;
					}
					//>> 判断密码是否为空
					if(password == ''){
						layer.tips('密码不能为空!','input[name = password]');
					}else{
						//>> 判断密码格式是否正确
						//var reg_ = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/;
						if(password.length < 6){
							layer.tips('密码长度至少6位!','input[name = password]');
						}else{
							//>> 提交表单
							$.ajax({
								'type':'post',
								'dataType':'json',
								'url':"<?php echo U('home/login/login');?>",
								'data':{
									'username':username,
									'password':password
								},
								success:function(result){
									if(result.status == 1){
										window.location.href = "<?php echo U('home/index/index');?>";
									}else{
										layer.msg(result.msg);
									}
								}

							});
						}
					}
				}
			
			}
			$('.login').click(function(){
					login();
						});
			$('body').on('keyup',function(e){
				if(e.keyCode==13){
					login();
				}
			})
		});
	</script>
</body>
</html>