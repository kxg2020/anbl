$(function(){
	
	$('#login').click(function(){

		//>> 获取用户名
		username = $('input[name = username]').val();
		password = $('input[name = password]').val();
		if(username == '' || password == ''){
			layer.open({
				content: '用户名和密码不能为空',
				style: 'color:black;'
				,btn: '我知道了'
			});
			return false;
		}
		//>> 请求后台
		$.ajax({
			'type':'post',
			'dataType':'json',
			'url':location.protocol+'//'+window.location.host+'/Login/checkLogin',
			'data':{'username':username,'password':password},
			success:function(e){
				if(e.status == 1){

					//>> 登录成功,跳转
					
				}else{
					layer.open({
						content: e.msg,
						style: 'color:black;'
						,time:2
					});
				}
			}
		});

	});
	$('#reg').click(function(){
		alert('fuck you')
	})

	//切换
		$('.loginorreg>p').click(function(){
			$('.loginorreg>p').removeClass('choice')
			if($(this).text()=='登录'){
				$('.loginorreg>p').eq(0).addClass('choice');
				$('.login').show();
				$('.reg').hide();
			}
			if($(this).text()=='注册'){
				$('.loginorreg>p').eq(1).addClass('choice');
				$('.login').hide();
				$('.reg').show();
			}
		})

	// 短信验证码蒙板
	$('.song').click(function(){
		if(/^1(3|4|5|7|8)\d{9}$/.test($('.phoneinput').val())){
			console.log(1)
				 var time=60;
				 $('.mengban').show();
				 var timer = setInterval(function(){
					      time--;
					      $('.song').html(time+"s");
					      if(time===0){
					         $('.mengban').hide();
					         $('.song').html("重新获取");
					        clearInterval(timer);
					      }
					 },1000);
		}else{
			alert('请输入正确的手机号')
		}
	})	


	//判断进来的是否是注册用户
	var url=window.location.href;
	//console.log(url.indexOf('?url='))
	var txt=url.slice(url.indexOf('?url=')+5);
	if(txt=='reg'){
		$('.loginorreg>p').removeClass('choice')
		$('.loginorreg>p').eq(1).addClass('choice');
		$('.login').hide();
		$('.reg').show();
	}
	
})