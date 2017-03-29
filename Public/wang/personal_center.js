$(function(){
	//关闭回到主界面
	$('.close_identity').click(function(){
		$('.identity').hide();
		$('.body_right>ul').show();
	})
    $('.close_attend').click(function(){
		$('.attend').hide();
		$('.body_right>ul').show();
	})
	$('.close_money').click(function(){
	$('.money_operat').hide();
	$('.body_right>ul').show();
})
$('.close_password').click(function(){
$('.password').hide();
$('.body_right>ul').show();
})
	//进入某一个界面
	$('#identity').click(function(){
		$('.body_right>ul').hide();
		$('.identity').show();
	})
	$('#attend').click(function(){
		$('.body_right>ul').hide();
		$('.attend').show();
	})
	$('#password').click(function(){
		$('.body_right>ul').hide();
		$('.password').show();
	})
	$('#recharge').click(function(){
		$('.body_right>ul').hide();
		$('.body_right>div').hide();
		$('.money_operat').show();
		$('.money_content>ul>li').removeClass('choice');
		$('.money_content>ul>li').eq(0).addClass('choice');
		$('.put_money').show();
		$('.get_money').hide();
		$('.money_record').hide();
	})
	$('#post_cash').click(function(){
		$('.body_right>ul').hide();
		$('.body_right>div').hide();
		$('.money_operat').show();
		$('.money_content>ul>li').removeClass('choice');
		$('.money_content>ul>li').eq(1).addClass('choice');
		$('.put_money').hide();
		$('.get_money').show();
		$('.money_record').hide();
	})
	// 不同头部的li之间的div切换
	$('.identity_content>ul>li').click(function(){
		var txt=$(this)[0].innerHTML;
		$('.identity_content>ul>li').removeClass('choice');
		if(txt=='个人资料'){
				$('.identity_content>ul>li').eq(0).addClass('choice');
				$('.people_data').show();
				$('.safe_center').hide();
		}
		if(txt=='安全中心'){
				$('.identity_content>ul>li').eq(1).addClass('choice');
				$('.people_data').hide();
				$('.safe_center').show();
		}
	})
	$('.attend_content>ul>li').click(function(){
		var txt=$(this)[0].innerHTML;
		$('.attend_content>ul>li').removeClass('choice');
		if(txt=='我的支持'){
				$('.attend_content>ul>li').eq(0).addClass('choice');
				$('.my_suport').show();
				$('.my_collect').hide();
		}
		if(txt=='我的收藏'){
				$('.attend_content>ul>li').eq(1).addClass('choice');
				$('.my_suport').hide();
				$('.my_collect').show();
		}
	})
	$('.money_content>ul>li').click(function(){
		var txt=$(this)[0].innerHTML;

		if(txt=='充值'){
			$('.money_content>ul>li').removeClass('choice');
				$('.money_content>ul>li').eq(0).addClass('choice');
				$('.put_money').show();
				$('.get_money').hide();
				$('.money_record').hide();
		}
		if(txt=='提现'){
			$('.money_content>ul>li').removeClass('choice');
				$('.money_content>ul>li').eq(1).addClass('choice');
				$('.put_money').hide();
				$('.get_money').show();
				$('.money_record').hide();
		}
	})
	$('.put_record').click(function(){
		$('.money_content>ul').eq(0).hide();
		$('.money_content>ul').eq(1).show();
		$('.put_money').hide();
		$('.get_money').hide();
		$('.money_record').show();
	});
	$('.now_put').click(function(){
		$('.money_content>ul').eq(1).hide();
		$('.money_content>ul').eq(0).show();
		$('.put_money').show();
		$('.get_money').hide();
		$('.money_record').hide();
		$('.money_content>ul>li').removeClass('choice');
		$('.money_content>ul>li').eq(0).addClass('choice');
	});
	//性别选择
	$('.sex>span>p').click(function(){
		var id=$(this)[0].id;
		$('.sex>span').removeClass('sex_choice');
		if(id=='man'){
			$('.sex>span').eq(1).addClass('sex_choice');
			$('#man>i').show();
			$('#woman>i').hide();
		}
		if(id=='woman'){
			$('.sex>span').eq(2).addClass('sex_choice');
			$('#man>i').hide();
			$('#woman>i').show();
		}
	});
		//填写绑定手机 邮箱
	$('#bind_phone').click(function(){
		$('.bind_phone>span').eq(1).hide();
		$('.bind_phone>span').eq(2).show();
	})
	$('#bind_email').click(function(){
		$('.bind_email>span').eq(1).hide();
		$('.bind_email>span').eq(2).show();
	})
	//点击提升出现的界面
	$('.up_btn').click(function(){
		$('.body_right>ul').hide();
		$('.body_right>div').hide();
		$('.identity').show();
		$('.safe_center').hide();
	});

//>> 验证表单
	$('#save').click(function(){

		var phone = $('input[name = phone]').val();
		var email = $('input[name = email]').val();
		var realname = $('input[name = realname]').val();
		var id_card = $('input[name = id_card]').val();
		var bank_card_name = $('input[name = bank_card_name]').val();
		var bank_card = $('input[name = bank_card]').val();
		var city = $('input[name = city]').val();
		var address = $('input[name = address]').val();
		if(realname == ''){
			layer.tips('请输入真实姓名','input[name = realname]',{
				tips:4
			});
		}else{
			if(id_card == ''){
				layer.tips('请输入身份证','input[name = id_card]',{
					tips:4
				});
			}else{
				//>> 验证身份证格式
				var reg = /\d{14}(\d{4}|(\d{3}[xX])|\d{1})/;
				if(!reg.test(id_card)){
					layer.tips('身份证格式不正确','input[name = id_card]',{
						tips:4
					});
					return ;
				}
				if(bank_card_name == ''){
					layer.tips('请输入开户名','input[name = bank_card_name]',{
						tips:4
					});
				}else{
					if(bank_card == ''){
						layer.tips('请输入银行卡号','input[name = bank_card]',{
							tips:4
						});
					}else{
						//>> 验证银行卡
						var reg_ = /^\d{19}$/g;
						if(!reg_.test(bank_card)){
							layer.tips('银行卡格式不正确','input[name = bank_card]',{
								tips:4
							});
							return ;
						}
						if(city == ''){
							layer.tips('请输入开户城市','input[name = city]',{
								tips:4
							});
						}else{
							if(address == ''){
								layer.tips('请输入支行地址','input[name = address]',{
									tips:4
								});
							}else{
								var url_ = location.protocol+'//'+window.location.host+'/Home/Personal/saveInfo';
								$.ajax({
									'type':'post',
									'dataType':'json',
									'url':url_,
									'data':{
										'phone':phone ? phone : '',
										'email':email? email : '',
										'realname':realname,
										'id_card':id_card,
										'bank_card_name':bank_card_name,
										'bank_card':bank_card,
										'city':city,
										'address':address
									},
									success:function(result){
										if(result.status == 1){
											layer.msg('保存成功!');
										}else{
											layer.msg(result.msg);
										}
									}
								});
							}
						}
					}
				}
			}
		}
	});
	var safeLevel = $('input[name = safeLevel]').val();
	$('#safe').css('width',safeLevel);

	//>> 获取性别
	$('#sex').click(function(){
		var url = location.protocol+'//'+window.location.host+'/Home/Personal/save';

		var sex = $('input[type = radio]:checked').attr('data-sex');

		$.ajax({
			'type':'post',
			'dataType':'json',
			'url':url,
			'data':{
				'sex':sex
			},
			success:function(result){
				if(result.status == 1){
					layer.msg('保存成功！');
				}else{
					layer.msg('保存失败!');
				}
			}
		});
	});
});
