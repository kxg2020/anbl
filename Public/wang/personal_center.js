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
		$('#cancel_div').hide();
	})
	$('#password').click(function(){
		$('.body_right>ul').hide();
		$('.password').show();
	})
	$('#recharge').click(function(){
		$('.money_content>ul').eq(0).show();
		$('.money_content>ul').eq(1).hide();
		$('.body_right>ul').hide();
		$('.body_right>div').hide();
		$('.money_operat').show();
		$('.money_content>ul>li').removeClass('choice');
		$('.money_content>ul>li').eq(0).addClass('choice');
		$('.put_money').show();
		$('.get_money').hide();
		$('.money_record').hide();
		$('.money_deal').hide();
		$('.zhuanzhang').hide();
	})
	$('#post_cash').click(function(){
		$('.money_content>ul').eq(0).show();
		$('.money_content>ul').eq(1).hide();
		$('.body_right>ul').hide();
		$('.body_right>div').hide();
		$('.money_operat').show();
		$('.money_content>ul>li').removeClass('choice');
		$('.money_content>ul>li').eq(1).addClass('choice');
		$('.put_money').hide();
		$('.get_money').show();
		$('.money_record').hide();
		$('.money_deal').hide();
		$('.zhuanzhang').hide();
	})
	$('#zhuanzhang').click(function(){
		$('.money_content>ul').eq(0).show();
		$('.money_content>ul').eq(1).hide();
		$('.body_right>ul').hide();
		$('.body_right>div').hide();
		$('.money_operat').show();
		$('.money_content>ul>li').removeClass('choice');
		$('.money_content>ul>li').eq(2).addClass('choice');
		$('.put_money').hide();
		$('.get_money').hide();
		$('.money_record').hide();
		$('.zhuanzhang').show();
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
		//console.log(txt)
		if(txt=='充值'){
			$('.money_content>ul>li').removeClass('choice');
			$('.money_content>ul>li').eq(0).addClass('choice');
			$('.put_money').show();
			$('.get_money').hide();
			$('.money_record').hide();
			$('.zhuanzhang').hide();
		}
		if(txt=='提现'){
			$('.money_content>ul>li').removeClass('choice');
			$('.money_content>ul>li').eq(1).addClass('choice');
			$('.put_money').hide();
			$('.get_money').show();
			$('.money_record').hide();
			$('.zhuanzhang').hide();
		}

		if(txt=='转账'){
			$('.money_content>ul>li').removeClass('choice');
			$('.money_content>ul>li').eq(2).addClass('choice');
			$('.put_money').hide();
			$('.get_money').hide();
			$('.money_record').hide();
			$('.zhuanzhang').show();
		}

		if(txt=='充值记录'){
			$('.money_content>ul:nth-child(2)>li').removeClass('choice');
			$('.money_content>ul:nth-child(2)>li').eq(0).addClass('choice');
			$('.put_money').hide();
			$('.get_money').hide();
			$('.money_record').show();
			$('.zhuanzhang').hide();

		}
		


	})
	$('.put_record').click(function(){
		$('.money_content>ul:nth-child(2)>li').eq(0).addClass('choice');      //x新增
		$('.money_content>ul').eq(0).hide();
		$('.money_content>ul').eq(1).show();
		$('.put_money').hide();
		$('.get_money').hide();
		$('.money_record').show();
		$('.zhuanzhang').hide();
	});


	$('.now_put').click(function(){
		$('.money_content>ul').eq(1).hide();
		$('.money_content>ul').eq(0).show();
		$('.put_money').show();
		$('.get_money').hide();
		$('.money_record').hide();
		$('.money_content>ul>li').removeClass('choice');
		$('.money_content>ul>li').eq(0).addClass('choice');
		$('.zhuanzhang').hide();
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
		$('.safe_center').show();
		$('.people_data').hide();
		$('.identity_content>ul>li').removeClass('choice');
		$('.identity_content>ul>li').eq(1).addClass('choice');
	});

//>> 验证表单
	$('#save').click(function(){

		var bank = $('#bind_bank').val();
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

					if(bank_card_name != realname){
						layer.tips('开户名必须和真实姓名一致','input[name = bank_card_name]',{
							tips:4
						});
						return false;
					}
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
								var url_ = location.protocol+'//'+window.location.host+'/Home/Personal/safeInfo';
								$.ajax({
									'type':'post',
									'dataType':'json',
									'url':url_,
									'data':{
										'realname':realname,
										'id_card':id_card,
										'bank_card_name':bank_card_name,
										'bank_card':bank_card,
										'city':city,
										'address':address,
										'bank_name':bank
									},
									success:function(result){
										if(result.status == 1){
											layer.msg('保存成功!',function(){
												location.reload();
											});

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
					layer.msg('保存成功！',{
						time:3,
					},function(){
						location.reload();
					});

				}else{
					layer.msg('保存失败!');
				}
			}
		});
	});


	$('.rechargeOk').click(function(){
		var money = $('input[name = rechargeMoney]').val();
		var path = $('#images').val();
		var type = $('.apply_style_choice').attr('data-id');
		if(path.length == 0){
			layer.msg('请上传凭证!');
			return false;
		}
		if(money == ''){

			layer.tips('充值阿纳豆不能为空!','input[name = rechargeMoney]');
		}else{
			//>> 判断是否是数字
			var isNum = /^[0-9]*$/;
			if(!isNum.test(money)){

				layer.tips('请输入正确的数字!','input[name = rechargeMoney]');
			}else{
				var chargeUrl = location.protocol+'//'+window.location.host+'/Home/Recharge/recharge';
				$.ajax({
					'type':'post',
					'dataType':'json',
					'url':chargeUrl,
					'data':{
						'money':money,
						'image_url':path,
						'type':type
					},
					success:function(result){
						if(result.status == 1){
							$('#images').val('');
							layer.msg('充值成功!,请等待工作人员与您联系',function(){
								$('input[name = rechargeMoney]').val('');
							});
						}else{
							layer.msg(result.msg,function(){
								$('input[name = rechargeMoney]').val('');
							});
						}
					}
				});

			}
		}
	});



	$('.ex').click(function(){
		var money = $('input[name = exMoney]').val();

		if(money == ''){

			 layer.tips('请输入提现金额','input[name = exMoney]');
		}else{

			//>> 检测是否为0
			if(money == 0){
				layer.tips('金额不能为0','input[name = exMoney]');
				return;
			}
			//>> 检测金额是否是数字
			var reg = /^[0-9]+.?[0-9]*$/;
			if(!reg.test(money)){

				layer.tips('请输入正确的金额','input[name = exMoney]');
			}else{

				var url =  location.protocol +'//'+ window.location.host+'/Home/Personal/cash';
				$.ajax({
					'type':'post',
					'dataType':'json',
					'url':url,
					'data':{
						'money':money
					},
					success:function(result){
						if(result.status == 1){
							$('input[name = exMoney]').val('0');
							layer.msg('提现申请成功,请等待审核',function(){
								$('input[name = exMoney]').val('');
							});
						}else{
							layer.msg(result.msg,function(){
								$('input[name = exMoney]').val('');
							});
						}
					}
				});
			}
		}
	});
	//屏幕宽度高度调节
	if($(window).height()>=768){
		$('.body').css({
			height:$(window).height()-120
		})
	}

	//平台质询的相关操作
	$('.close_ask').click(function(){
		$('.ask').hide();
		$('.body_right>ul').show();
	})
	$('#ask').click(function(){
		$('.body_right>ul').hide();
		$('.body_right>div').hide();
		$('.ask').show();
		$('.ask_content').show();
		$('.ask_answer').hide();
	})
	$('.ask_content>p').click(function(){
		$('.ask_content').hide();
		$('.ask_answer').show();
		$('.answer_div').show();
		$('.answer_form').hide();
	})
	$('.ask_answer>p>span').click(function(){
		$('.ask_content').show();
		$('.ask_answer').hide();
	})
	$('.answer_div>p').click(function(){
		$('.answer_div').hide();
		$('.answer_form').show();
	})
	$('.back_title').click(function(){
		$('.answer_div').show();
		$('.answer_form').hide();
	})

	//我的团队相关操作

	$('.close_team').click(function(){
		$('.team').hide();
		$('.body_right>ul').show();
	})
	$('#team').click(function(){
		$('.body_right>ul').hide();
		$('.body_right>div').hide();
		$('.close_modal').hide();
		$('.team>.bg').show();
		$('.money_modal').hide()
		$('.team').show();
	})

	//点击替换背景
	var bgArry=['/Public/wang/img/bg.jpg','/Public/wang/img/bg1.jpg','/Public/wang/img/bg2.jpg','/Public/wang/img/bg3.jpg'];
	var imgNumber=1;
	$('#repeat_bg').click(function(){
		$('.body_left').css({
			'backgroundImage':'url('+bgArry[imgNumber]+')'
		})
		imgNumber++;
		if(imgNumber==bgArry.length){
			imgNumber=0;
		}
	})

	//我要当演员相关操作
	$('.close_actor').click(function(){
		$('.actor').hide();
		$('.body_right>ul').show();
	})
	$('#actor').click(function(){

		$('.body_right>ul').hide();
		$('.body_right>div').hide();
		$('.actor').show();
		$('.movie_list').show();
		$('.movie_intr').hide();
		$('.apply_role').hide();
	})
	//我要当演员 面包屑操作
	$('.backTo2').click(function(){
		$('.movie_list').hide();
		$('.movie_intr').show();
		$('.apply_role').hide();
	})
	$('.backTo1').click(function(){
		$('.movie_list').show();
		$('.movie_intr').hide();
		$('.apply_role').hide();
	})
	// 申请流程顺序点击
	$('.goTodetail').click(function(){
		$('.movie_list').hide();
		$('.movie_intr').show();
		$('.apply_role').hide();
	})
	$('.goToform').click(function(){
		//>> 获取当前余额
		integral = parseInt($('input[name = jifen]').val());
		//>> 获取所需余额
		needintegral = $('.needand').text();

		if(integral < needintegral){
			layer.tips('需要'+needintegral+'阿纳豆才能申请该角色', '.goToform', {
				tips: [3, 'black'],
				time: 4000
			});
			return false;
		}
		$('.movie_list').hide();
		$('.movie_intr').hide();
		$('.apply_role').show();
	})

	//消费明细模态框操作

	$('.join').click(function(){
		
		$('.close_modal').show();
		$('.money_modal').show();
		$('.team>.bg').hide()
	})
	$('.close_modal>input').click(function(){
		$('.close_modal').hide();
		$('.money_modal').hide();
		$('.team>.bg').show();
	})

	//取消支持 

	$('body').on('click','.cancel_suport',function(){
		$('#cancel_div').fadeIn('slow')
	});
	$('body').on('click','.cancek_input',function(){
		$('#cancel_div').fadeOut('slow')
	})

	//选择支付方式
	$('.apply_style').click(function(){
		$('.apply_style').removeClass('apply_style_choice');
		if($(this).html()=='微信'){
			$(this).addClass('apply_style_choice');
			$('#weixing').show();
			$('#zhifubao').hide();
			$('#feiyinglian').show();
			$('#yinglian').hide();
		}if($(this).html()=='支付宝'){
			$(this).addClass('apply_style_choice');
			$('#weixing').hide();
			$('#zhifubao').show();
			$('#feiyinglian').show();
			$('#yinglian').hide();
		}if($(this).html()=='个人银联'){
			$(this).addClass('apply_style_choice');
			$('#weixing').hide();
			$('#zhifubao').hide();
			$('#feiyinglian').hide();
			$('#yinglian').show();
		}
	})

	//支付方式说明
	$('.get_money>p:nth-child(2)>img').on('mouseenter',function(){
		$('.get_money>p:nth-child(2)>span').show();
	}).on('mouseleave',function(){
		$('.get_money>p:nth-child(2)>span').css({display:'none'})
	})


	$('.phone01').on('keyup',function(){
		if(/^1(3|4|5|7|8)\d{9}$/.test($('.phone01').val())){
			$(".yanzhen").attr("disabled", false);
		}else{
			$(".yanzhen").attr("disabled", true);
		}
	})	
	$(".yanzhen").click(function(){
		$(".yanzhen").attr("disabled", true);
		var time=60;
		var timer=setInterval(function(){
				time--;
			$(".yanzhen").val(time+'S');	
			if(time==0){
				clearInterval(timer);
				$(".yanzhen").val('重新发送');	
				$(".yanzhen").attr("disabled", false);
			}
		},1000)
	})

	

});