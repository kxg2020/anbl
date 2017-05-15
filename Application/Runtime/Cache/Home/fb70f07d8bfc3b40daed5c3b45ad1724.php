<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="format-detection" content="telephone=no"/>
	<link rel="stylesheet" href="/Public/wang/common_css/reset.css">
	<link rel="stylesheet" href="/Public/wang/personal_center.css">
	<link href="/Public/css/layui.css" rel="stylesheet">
	<title>阿纳巴里</title>
</head>
<body>
	<header>
		<div class="nav">
    <div>
        <a class="logo" href="<?php echo U('home/index/index');?>"><img src="/Public/wang/img/logo.png" alt=""></a>
        <ul class="top_nav">
            <li><a href="<?php echo U('home/index/index');?>"><p>首页</p><p>Home</p></a></li>
            <li style="position: relative;"><a href="#"><p>公司介绍</p><p>Company</p></a>
                <dl>
                    <dd><a href="<?php echo U('home/company/about');?>">关于我们</a></dd>
                    <dd><a href="<?php echo U('home/company/index');?>">公司文化</a></dd>
                </dl>
            </li>
            <li><a href="<?php echo U('home/market/index');?>"><p>电影超市</p><p>Movie store</p></a></li>
            <li><a href="<?php echo U('home/factory/index');?>"><p>星工场</p><p>Star Factory</p></a></li>
            <li><a href="<?php echo U('Home/Personal/index');?>"><p>个人中心</p><p>Personal Center</p></a></li>
        </ul>
        <ul class="login_reg">
            <li  class="search_li" style="position: relative;"><input id="search_cont" type="text"><i id="search_btn"></i></li>
            <?php if($userInfo['username'] == ''): ?><li ><a id="login" href="<?php echo U('Home/Login/index');?>">登录 |</a></li>
                <li ><a href="<?php echo U('Home/Register/index');?>">注册</a></li><?php else: ?>
                <li class="user_img"><span><?php echo telephoneNumber($userInfo['username']);?></span></li>
                <li class="login_out"><a href="<?php echo U('Home/Login/logout');?>">退出登录</a></li><?php endif; ?>

        </ul>
    </div>
</div>
<script src='/Public/wang/common_js/jquery-1.12.4.min.js'></script>
<script type="application/javascript"></script>
	</header>
	<div class="body">
		<div class="body_left">
		<div>
		 <div>
			 <p class="username"><span style="margin-left: 17px;"><?php if($personal['is_true'] == 1): echo ($personal['realname']); else: echo telephoneNumber($personal['username']); endif; ?></span>   <span id="user_lv"  ><?php echo getUserLevelsName($personal['role']);?></span></p>
<!--
			<div class="leval"><?php if($allInfo['status'] == 1): ?>还差<?php echo ($allInfo['integral']); ?>个阿纳豆，您就升到Lv<?php echo ($allInfo['level']); ?>啦<?php else: ?>
			Lv<?php echo ($personal['level']); ?>:<?php echo ($personal['money']); ?>阿纳豆<?php endif; ?></div>
			-->

			 <input type="hidden" name="safeLevel" value="<?php echo ($safeLevel); ?>">

			<div class="money"><p>已支持阿纳豆: <span><?php echo ($supportMoney); ?></span></p><p>剩余阿纳豆: <span><?php echo ($personal['money']); ?></span></p></div>
			<div class="money"><p>收益阿纳豆: <span><?php echo ($personal['profit']); ?></span></p><p>佣金阿纳豆: <span><?php echo ($personal['commission']); ?></span></p></div>
			<div class="safe">账户安全等级<span><i style="" id="safe"></i></span>
				<?php if($personal['safe_level'] == 1): ?><span>低</span><?php endif; ?>
				<?php if($personal['safe_level'] == 2): ?><span>中</span><?php endif; ?>
				<?php if($personal['safe_level'] == 3): ?><span>高</span><?php endif; ?>
				<?php if(($personal['safe_level'] == 1 ) or ($personal['safe_level'] == 2 )): ?><span class="up_btn">点击提升</span><?php endif; ?></div>
			<div class="user_inform" id="phone"><?php echo ($secretPhone); ?></div>
			<div class="user_inform" id="name"><?php if($personal['is_true'] == 0): ?>未实名<?php else: ?><span style="color: forestgreen">已实名</span><?php endif; ?></div>
			<div><span id="recharge">充值</span><span id="post_cash">提现</span><span id="zhuanzhang">转账</span></div>
		 </div>
			<p id="repeat_bg">点击替换背景</p>
			<p class="footer">Copyright 2017 阿纳巴里国际影业</p>
		</div>
		</div>
		<div class="body_right">
			<ul style='display: block;'>
				<li id="identity"><div>实名信息</div></li>
				<li id="team"><div>账户明细</div></li>
				<li id="password"><div>我的团队</div></li>
				<li id="ask"><div>问题留言</div></li>
				<li id="actor"><div>演艺申请</div></li>
				<li id="attend"><div>我的参与</div></li>
			</ul>
			<div class="identity" style="display: none;">
				<div class="bg">
				<div class="close_identity"></div>
					<div class="identity_content">
						<ul>
							<li class="choice">个人资料</li>
							<li>安全中心</li>
							<li>密码管理</li>
						</ul>
						<div class="people_data">
							<div class="user"><input type="text" value="<?php echo ($personal['username']); ?>" disabled></div>
							<div style="margin-bottom: 38px;"><span style="margin-right: 23px;">邀请码:</span><span style="color: green;"><?php echo ($personal['invite_key']); ?></span></div>
							<div style="margin-bottom: 38px;"><span style="margin-right: 23px;width: 80px;display: inline-block;">推广链接:</span><input type="button" value="点击复制" class="copy" data-clipboard-target="#copy_content">
								<br>
								<input type="text" id="copy_content" readonly value="http://www.araberrimovie.com/home/register/index/invite_key/<?php echo ($personal['invite_key']); ?>">	</div>


							<div class="real_name"><span>实名:</span><?php if($personal['is_true'] == 0): ?><span>未实名</span><?php else: ?><span style="color: forestgreen">已实名</span><?php endif; ?></div>
							<div class="sex">
								<span>性别:</span>
								<span><input type="radio" name="sex" value="" data-sex="1" <?php if($userInfo['sex'] == 1): ?>checked="checked"<?php endif; ?>>男</span>
</span>
								<span><input type="radio" name="sex" value="" data-sex="2" <?php if($userInfo['sex'] == 2): ?>checked="checked"<?php endif; ?>>女</span>
							</div>
							<input type="hidden" value="<?php echo ($personal['level']); ?>" id="dengji">
							<div class="user_leval"><span >用户等级:</span><p><i id="bg_1"></i><span id="d" style="border-radius: 10px">

							</span></p></div>
							<script>
								var arr = ['0%','10%','30%','50%','70%','90%'];
								var brr = ['Lv0','Lv1','Lv2','Lv3','Lv4','Lv5'];
								var lv = $('#dengji').val();
								var lvR = $('#dengji').val();
								$('#d').css('left',arr[lv]);
								$('#d').text(brr[lv]);
								$('#bg_1').css({'background':'url('+'/Public/wang/img/level'+lvR+'.png)','left':arr[lv]});
								
								//console.log(lvR)
							</script>
							<div class="save_update" id="sex">保存更新</div>
						</div>
						<div class="safe_center"  style="display: none;" >
							<div class="bind_username"><span><i></i><?php if($userInfo['realname'] == ''): ?><input type="text" placeholder="请输入您的姓名" name="realname" value="<?php echo ($userInfo['realname']); ?>"><?php else: ?><input type="text" placeholder="请输入您的姓名" name="realname" value="<?php echo ($userInfo['realname']); ?>" disabled><?php endif; ?></span><label>*注意：必须是真实姓名</label></div>
							<div class="bind_idcard"><span><i></i><?php if($userInfo['id_card'] == ''): ?><input type="text" placeholder="请输入您的身份证号" value="510722199112171554" name="id_card"><?php else: ?><input type="text" placeholder="请输入您的身份证号" name="id_card" disabled value="<?php echo ($userInfo['id_card']); ?>"><?php endif; ?></span><label>*身份证号必须正确</label></div>

							<div id="line"></div>
							<div class="bankcard1"> <i></i><select  id="bind_bank">
										<option value="中国银行"   <?php if($userInfo['bank_name'] == '中国银行'): ?>selected<?php endif; ?>>中国银行</option>
										<option value="工商银行"  <?php if($userInfo['bank_name'] == '工商银行'): ?>selected<?php endif; ?>>工商银行</option>
										<option value="农业银行"  <?php if($userInfo['bank_name'] == '农业银行'): ?>selected<?php endif; ?>>农业银行</option>
										<option value="建设银行"  <?php if($userInfo['bank_name'] == '建设银行'): ?>selected<?php endif; ?>>建设银行</option>
										<option value="中国邮政储蓄银行"  <?php if($userInfo['bank_name'] == '中国邮政储蓄银行'): ?>selected<?php endif; ?>>中国邮政储蓄银行</option>
										<option value="招商银行"  <?php if($userInfo['bank_name'] == '招商银行'): ?>selected<?php endif; ?>>招商银行</option>
									</select>
									<label>*开户银行</label>
							</div>
							<div class="bind_bankname"><span><i></i><input type="text" placeholder="请输入开户名"  name="bank_card_name" value="<?php echo ($userInfo['bank_card_name']); ?>"></span><label>*开户姓名</label></div>
							<div class="bind_bankcard"><span><i></i><input type="text" placeholder="请输入开户卡号"  name="bank_card" value="<?php echo ($userInfo['bank_card']); ?>"></span><label>*银行卡号</label></div>

							<div style="display: none"><span><input type="hidden"  placeholder="如:香港" name="city" value="<?php echo ($userInfo['city']); ?>"></span><label></label></div>

							<div class="bind_otherbank">

								<?php if(!empty($userInfo['city'])): ?><i></i><input type="text" value="<?php echo ($userInfo['city']); ?>" disabled><lable style="color: #ccc; margin-left: 50px;">*开户地址</lable><?php else: ?>

									<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 23px;" id="city_choice">

										<tr>

											<td>

												<select class="" id="province" name="province" onchange="doProvAndCityRelation();">
													　　　　　　　　<option id="choosePro" value="-1" data-area="-1">请选择省份</option>　　　　　　</select>
											</td>
											<td>
												<select id="citys" name="city" onchange="doCityAndCountyRelation();">
													　　　　　　　　<option id='chooseCity' value='-1' data-area="-1">请选择城市</option>
													　　　　　　</select>
											</td>
											<td>
												<select id="county" name="county">
													　　　　　　　　<option id='chooseCounty' value='-1' data-area="-1">请选择区/县</option>
													　　　　　　</select>
											</td>
											<td>
												<label>*开户地址</label>
											</td>
										</tr>

									</table><?php endif; ?>
							</div>




							<div class="bind_otherbank"><i></i><span><input type="text"  name="address" value="<?php echo ($userInfo['address']); ?>"></span><label>*开户支行</label></div>


							<div class="save_update" id="save">保存更新</div>
						</div>
						<div class="update_password" style="display: none;">
									<p><i></i><input style='padding-left:37px;width:174px;' placeholder="请输入当前密码" name="password" type="password"><label>输入当前的登录密码</label></p>
									<p><i></i><input type="password" placeholder="请输入新密码" name="newpassword"><label>新密码</label></p>
									<p><i></i><input type="password" placeholder="请再次输入" name="repassword"><label>确认新密码</label></p>
									<div class="save_update" id="editPassword">保存更新</div>
						</div>

					</div>
				</div>
				<p>A</p>
				<p>R</p>
				<p>B</p>
		    </div>
		    <div class="attend" style="display: none;">
				<div class="bg">
				<div class="close_attend"></div>
					<div class="attend_content">
						<ul>
							<li class="choice">我的支持</li>
							<li>我的收藏</li>
						</ul>
						<div class="my_suport" >
								<?php if(is_array($supportSituation)): $i = 0; $__LIST__ = $supportSituation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><div>
										<img src="<?php echo ($s['image_url']); ?>" alt="" style="height: 180px;width: 420px">
										<div class="movie_content">
											<p>片名:<?php echo ($s['name']); ?></p>
											<p><?php echo ($s['englishname']); ?></p>
											<p><?php echo ($s['director']); ?>/导演</p>
											<p><span><?php echo ($s['support_number']); ?></span>人支持</p>
											<p>类型:<span><?php if($s['atype'] == 1): ?>月酬<?php else: ?>票房<?php endif; ?></span>&nbsp;&nbsp;收益:<span><?php if($s['atype'] == 1): echo ($s['fixed']); else: echo ($s['float']); endif; ?></span></p>
											<p>已支持<span><?php echo ($s['support_money']); ?></span>阿纳豆</p>
											<p><input type="button" class="cancel_suport" value="取消支持" data-id="<?php echo ($s['aid']); ?>"></p>
											<a href="<?php echo U('home/index/detail',['id'=>$s['project_id']]);?>" class="detail_search">查看详情</a>
										</div>
									</div><?php endforeach; endif; else: echo "" ;endif; ?>

							<input type="hidden" name="page_1" value="<?php echo ($count_1); ?>">
							<p id="demo8" style="position: absolute;left:5%;top: 450px;"></p>
						</div>
						<div id="cancel_div" style="display: none;">
							<h3>亲爱的用户:</h3>
							<p>根据我们的用户协议规定:退出影片的支持</p>
							<p>将扣除所有收益和10%的手续费，所支持阿纳豆将立即返回您的账户。</p>
							<p><input type="button" class="sure_input" value="确定"><input type="button" class="cancek_input" value="取消"></p>
						</div>
						<div class="my_collect" style="display: none;">
							<?php if(is_array($collection)): $i = 0; $__LIST__ = $collection;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><div><img src="<?php echo ($c['image_url']); ?>" style="height: 100%;width: 100%;" alt="">
									<div class="movie_content">
										<p>片名:<?php echo ($c['name']); ?></p>
										<p><?php echo ($c['englishname']); ?></p>
										<p><?php echo ($c['country']); ?>/<?php echo ($c['duration']); ?>分钟</p>
										<p><?php echo ($c['date']); ?>/<?php echo ($c['showaddress']); ?></p>
										<p style="color: #e50909; float: right;"><i></i>已收藏</p>
										<p style="text-align: right;"><input style="float: right;" type="button" data-id="<?php echo ($c['cid']); ?>" class="cancel_collect" value="取消收藏"></p>
									</div>
								</div><?php endforeach; endif; else: echo "" ;endif; ?>
							<input type="hidden" name="page_2" value="<?php echo ($collectionCount); ?>">
							<p id="demo9" style="position: absolute;left:5%;top: 450px;"></p>
						</div>
					</div>
				</div>
				<p>A</p>
				<p>R</p>
				<p>B</p>
		    </div>
		    <div class="money_operat" style="display:none;">
				<div class="bg">
				<div class="close_money"></div>
					<div class="money_content">
						<ul>
							<li class="choice">充值</li>
							<li>提现</li>
							<li>转账</li>
							<!-- <li class="put_record">充值记录<span>>></span></li> -->
						</ul>
						<ul style="display: none;">
							<li>充值记录</li>
							<li class="now_put">立即充值<span>>></span></li>
						</ul>
							<div class="put_money" style="display: none;">
								<p>选择充值方式: <!--<span class="apply_style apply_style_choice" data-id="<?php echo ($weixin['id']); ?>">微信</span>--><span class="apply_style apply_style_choice" data-id="<?php echo ($ali['id']); ?>">支付宝</span><span class="apply_style" data-id="3">公司银联</span></p>
								<div id="zhifubaoDiv" style="display: block;">
									<div class="apply11">
									<div id="feiyinglian">
										<!--<img id="weixing" src="<?php echo ($weixin['image_url']); ?>" alt="">-->
										<img id="zhifubao" style="display: block;" src="<?php echo ($ali['image_url']); ?>" alt="">
								    </div>
								    <p class="apply01">充值阿纳豆: <input type="text" name="rechargeMoney" placeholder="0.00"></p>
									<div class="recharge001" style="position:relative;">交易凭证:<span style="margin-left: 20px;"><span style="height: 50px;width: 50px; text-align:center; line-height:50px;color:#e05959;cursor: pointer;display: inline-block;border: 1px dashed red" >+</span><input id="file_upload" style="cursor: pointer; width: 160px; height: 50px;"  class="money_file" type="file"></span>
									<div id="container1"></div>
									</div>
									
									</div>	
									<div id="put_btn" class="rechargeOk">确定</div>
								</div>
								<div id="yinlianDiv" style="display: none;">
									 <div class="apply11">
										 <?php if(is_array($yinlian)): $i = 0; $__LIST__ = $yinlian;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$yin): $mod = ($i % 2 );++$i;?><div class="yinglian"><p>户主:<?php echo ($yin['username']); ?></p>
												<p>卡号:<?php echo ($yin['account']); ?></p>
												<p>开户支行:<?php echo ($yin['bank']); ?></p>
											</div><?php endforeach; endif; else: echo "" ;endif; ?>
										<p class="apply01" style="margin-top: 30px;">充值阿纳豆: <input type="text" name="rechargeMoney1" placeholder="0.00"></p>
									    <div class="recharge001">交易凭证:<span style="margin-left: 20px;"><span style="height: 50px;width: 50px; text-align:center; line-height:50px;color:#e05959;cursor: pointer;display: inline-block;border: 1px dashed red" >+</span><input id="file_upload2" style="cursor: pointer; width: 160px; height: 50px;"  class="money_file" type="file"></span> 
										<div id="container2"></div>
									    </div>
									    <div id="put_btn" class="rechargeOk1">确定</div>
									   
									</div>	

								</div>
							</div>

						<div class="get_money" style="display: none; padding-top: 20px;">
							<input id="apply_yuer" class="apply_choice" type="button" value="提现余额">
							<input id="apply_shouyi" type="button" value="提现收益">
							<input id="apply_yongjing" type="button" value="提现佣金">
							<div class="apply_yuer">
								<p>余额阿纳豆: <input type="text" name="exMoney" placeholder="0.00"></p>
								<p>可提余额阿纳豆:<?php echo ($userInfo['money']); ?> <img src="/Public/wang/img/question.png" alt=""><span>每周五才可以提现，手续费为10%，但是每月月底可以免费提现一次哦！</span></p>
								<div class="question_div"></div>
								<input type="button" value="确定" id="get_btn" class="ex" >
							</div>
							<div class="apply_shouyi" style="display: none">
								<p>收益阿纳豆: <input type="text" name="exMoney" placeholder="0.00"></p>
								<p>可提收益阿纳豆:<?php echo ($userInfo['money']); ?> <img src="/Public/wang/img/question.png" alt=""><span>每周五才可以提现，手续费为10%，但是每月月底可以免费提现一次哦！</span></p>
								<div class="question_div"></div>
								<input type="button" value="确定" id="get_btn1" class="ex" >
							</div>
							<div class="apply_yongjing" style="display: none;">
								<p>佣金阿纳豆: <input type="text" name="exMoney" placeholder="0.00"></p>
								<p>可提佣金阿纳豆:<?php echo ($userInfo['money']); ?> <img src="/Public/wang/img/question.png" alt=""><span>每周五才可以提现，免手续费。</span></p>
								<div class="question_div"></div>
								<input type="button" value="确定" id="get_btn2" class="ex" >
							</div>

						</div>
						<div class="money_record" style="display: none;">
							<p><span>充值时间</span>
							<span>充值方式</span>
							<span style="color: white;">交易号</span>
							<span style="color: white;">充值阿纳豆</span>
							<span>交易状态</span>
							<span>备注</span>

							</p>
							<div id="ls">
							<?php if(is_array($orderList)): $i = 0; $__LIST__ = $orderList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$o): $mod = ($i % 2 );++$i;?><p>
									<span><?php echo date('Y-m-d H:i:s',$o['create_time']);?></span>
									<span><?php echo ($o["payname"]); ?></span>
									<span><?php echo ($o["order_number"]); ?></span>
									<span><?php echo ($o["money"]); ?></span>
									<span><img src="/Public/images/status/<?php echo ($o["is_pass"]); ?>.png"  style="height: auto;width: 40px"></span>
									<span><?php echo mb_substr($o['remark'],0,12,'utf-8');?></span>
								</p><?php endforeach; endif; else: echo "" ;endif; ?>
						 </div>
							<div id="demo60" style="margin-left: 42px;"></div>
					</div>

						<div class="zhuanzhang" style="display: none;">
							<div class="div1">
								<label ><span style="color:red;">*</span>请输入转入帐号</label>	<input type="text" placeholder="请输入转入帐号" class="username01" style="margin-left: 15px;"> <input type="button" value="验证" id="check_1">
								<br><br>
							</div>
							<div class="div2">
									<label ><span style="color:red;">*</span>请输入转入阿纳豆</label><input class="money01" type="text" value="" placeholder="请输入转入阿纳豆">
								<br><br>
							</div>
							<div class="div3">
									<label><span style="color:red;">*</span>请输入手机验证码</label><input class="phone01" type="text" value="" placeholder="请输入验证码">
								<input class="yanzhen" type="button"   value="获取验证码" >
							</div>
							<div class="div4">
									<input type="button" value="确定" id="queding">
							</div>
						</div>

					</div>
				</div>
				<p>A</p>
				<p>R</p>
				<p>B</p>
		    </div>
				<div class="password" style="display: none;">
					<div class="bg">
					<div class="close_password"></div>
						<div class="password_content">
							<div class='money_modal'>
								<span style="color: white;margin: 0 auto">直推:<?php echo ($follower); ?>人<span style="margin-left: 55px;">未实名:<?php echo ($notTrue); ?>人</span><span style="margin-left: 55px;">团队:<?php echo ($group); ?>人</span><input class="search_xiaji" type="text" placeholder="请输入成员的手机号" value=""><input id="search_xiaji" type="button" value="搜索"></span>
								<div class="team_total">
									<div>
										<div class="people_top" style="border-radius: 3px;" data-id="<?php echo ($personal['id']); ?>"><?php if($personal['is_true'] == 1): echo ($personal['realname']); else: echo ($personal['username']); endif; ?></div>
									</div>
								</div>
								<div class="search_div" style="display: none;">
									<h3>搜索结果</h3>
									<div class="sh"><p>账户:<span class="realname">老王</span></p><p>支持:<span class="all_support_money">3000000.00</span></p><p>角色:<span class="role">10000000.00</span></p><p>团队: <span class="group">200人</span></p></div>
									<div style="font-size: 20px;color: red;width: 100%;text-align: center; margin-top:15px;" id="notFound">没有匹配的成员</div>
									<input type="button" value="关闭" id="close_search">
								</div>
							</div>
						</div>

						<input type="hidden" value="" id="images">
						<input type="hidden" value="<?php echo ($count); ?>" id="count">
					</div>
					<p>A</p>
					<p>R</p>
					<p>B</p>
			    </div>
			<div class="ask" style="display: none;">
				<div class="bg">
					<div class="close_ask"></div>
					<div class="ask_content">
						<p>查看信箱<span>>></span></p>
						<form class="ask_form">
							<div> <label >问题标题</label><input style="width: 262px; height: 34px;" type="text" name="question"></div>
							<div style="height: 40px;"> <label style="line-height: 40px;">上传问题图片</label><input type="file" id="upload"><div class="choice_file">选取文件</div></div>
							<div> <label >问题详情</label><textarea style="resize: none; padding: 5px;" cols="30" rows="10" name="content"></textarea></div>
							<div><input type="button" id="ask_btn" value='提交'></div>
						</form>
					</div>
					<div class="ask_answer" style="display: none;">
						<p><span>我要提问<b>>></b></span></p>
						<div class="answer_div" >
						    <p style="font-size: 17px;" class="ask_p"><span>提问标题</span><span>时间</span><span>状态</span></p>
							<?php if(is_array($question)): $i = 0; $__LIST__ = $question;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$q): $mod = ($i % 2 );++$i;?><p class="qdetail" data-id="<?php echo ($q['id']); ?>"><span><?php echo ($q['title']); ?></span><span><?php echo date('Y-m-d',$q['create_time']);?></span><?php if($q['status'] == 0): ?><span style="color: red">未回复</span><?php else: ?><span style="color: forestgreen">已回复</span><?php endif; ?></p>
							<p style="display: none" id="<?php echo ($q['id']); ?>"><?php echo ($q['content']); ?></p>
							<p style="display: none" class="r<?php echo ($q['id']); ?>"><?php echo ($q['reply']); ?></p><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
						<form class="answer_form" style="display: none;">
							<div><label >问题标题</label><input type="text" name="rtitle" style="height: 30px"></div>
							<div><label >详细内容</label><textarea style="resize: none; padding: 5px;" cols="30" rows="10" name="rcontent"></textarea></div>
							<div><label >回复内容</label><textarea style="resize: none; padding: 5px;" cols="30" rows="10" name="rdcontent"></textarea></div>
							<input class="back_title" type="button" value="返回到标题">
							<input type="hidden" value="" id="question" name="question">
							<input type="hidden" value="<?php echo ($personal['username']); ?>"  name="wode">
							<input type="hidden" value="<?php echo ($personal['money']); ?>"  name="crrMoney">
						</form>
					</div>
				</div>

				<p>A</p>
				<p>R</p>
				<p>B</p>
				<script>
					$(function(){
						$('.qdetail').click(function(){
							id = $(this).attr('data-id');
							title = $(this).children('span').eq(0).text();
							content = $('#'+id).text();
							reply = $('.r'+id).text();
							$('input[name  = rtitle]').val(title);
							$('textarea[name  = rcontent]').val(content);
							$('textarea[name  = rdcontent]').val(reply);
						});

						//>> 转账
						$('#check_1').click(function(){
							username = $('.username01').val();
							crrnam = $('input[name = wode]').val();
							reg = /^0?(13|14|15|17|18)[0-9]{9}$/;
							if(!reg.test(username)){
								layer.tips('请填写正确的手机号', '.username01',{
									tips:[3,'orange'],
									time:2000,
									end:function(){
										$('.username01').val('').focus();
									}
								});
								return false;
							}

							if(username == crrnam){
								layer.tips('不能填写自己的账号', '.username01',{
									tips:[3,'orange'],
									time:2000,
									end:function(){
										$('.username01').val('').focus();
									}
								});
								return false;
							}

							$.ajax({
								'type':'post',
								'dataType':'json',
								'url':location.protocol+'//'+window.location.host+'/Home/Personal/checkAccount',
								'data':{'username':username},
								success:function(e){
									if(e.status == 1){
										layer.tips('通过验证', '.username01',{
											tips:[3,'green'],
											time:5000,
										});
									}else{
										layer.tips('账号不存在', '.username01',{
											tips:[3,'red'],
											time:3000,
											end:function(){
												$('.username01').val('').focus();
											}
										});
									}
								}
							});
						});

						//>> 点击验证
						$('.yanzhen').click(function(){
							$.ajax({
								'type':'post',
								'dataType':'json',
								'url':location.protocol+'//'+window.location.host+'/Home/Personal/sendMessage',
							});

						});
						//>> 点击确定
						$('#queding').click(function(){
						    crrMoney = parseInt($('input[name = crrMoney]').val());
							username = $('.username01').val();
							wodeusername = $('input[name = wode]').val();
							_money = $('.money01').val();
							_phone = $('.phone01').val();
							reg = /^0?(13|14|15|17|18)[0-9]{9}$/;
							if(!reg.test(username) || username == ''){
								layer.tips('请填写正确的手机号', '.username01',{
									tips:[3,'orange'],
									time:2000,
									end:function(){
										$('.username01').val('').focus();
									}
								});
								return false;
							}
							//>> 判断当前的账号是否是自己的
							if(username === wodeusername){
								layer.tips('不能填写自己的账号', '.username01',{
									tips:[3,'orange'],
									time:2000,
									end:function(){
										$('.username01').val('').focus();
									}
								});
								return false;
							}
							if(_money == '' || isNaN(_money) || _money <= 0){
								layer.tips('请填写正确阿纳豆数额', '.money01',{
									tips:[3,'orange'],
									time:2000,
									end:function(){
										$('.money01').val('').focus();
									}
								});
								return false;
							}
                            if(_money > crrMoney){
                                layer.tips('转账阿纳豆不能大于当前余额', '.money01',{
                                    tips:[3,'orange'],
                                    time:2000,
                                    end:function(){
                                        $('.money01').val('').focus();
                                    }
                                });
                                return false;
                            }

							if(_phone == '' || _phone.length > 6){
								layer.tips('请填写正确的验证码', '.phone01',{
									tips:[3,'orange'],
									time:2000,
									end:function(){
										$('.phone01').val('').focus();
									}
								});
								return false;
							}

							$.ajax({
								'type':'post',
								'dataType':'json',
								'url':location.protocol+'//'+window.location.host+'/Home/Personal/changeMoney',
								'data':{'username':username,'money':_money,'captcha':_phone},
								success:function(e){
									if(e.status == 1){
											layer.msg('操作成功', {
												time: 0, //20s后自动关闭
												btn: ['确定'],
												yes:function(){
													location.reload();
												}
											});
									}else{
										layer.msg(e.msg);
									}
								}
							});
						});
					});
				</script>
			</div>

			<div class="team" style="display: none;">
				<div class="bg">
					<div class="close_team"></div>
					<ul id="team_nav">
						<li class="teamChoice">收益</li>
						<li>投票</li>
						<li>转账</li>
						<li>支持</li>
						<li>演员申请</li>
						<li>充值</li>
						<li>提现</li>
					</ul>
					<div class="team_content apply_1">

						<table>

							<thead>
								<tr>
									<th>时间</th>
									<th>阿纳豆</th>
									<th>类型</th>
									<th>状态</th>
									<th>备注</th>
								</tr>
							</thead>
							<tbody id="tbody_1">
							<?php if(is_array($allget)): $i = 0; $__LIST__ = $allget;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$al): $mod = ($i % 2 );++$i;?><tr>

									<td><?php echo date('Y-m-d H:i:s',$al['create_time']);?></td>
									<td <?php if($al['is_ok'] == 1): ?>style="color: forestgreen"<?php else: ?>style="color: red"<?php endif; ?>><?php if($al['is_ok'] == 1): ?>+<?php else: ?>-<?php endif; echo ($al["money"]); ?></td>

									<td ><?php echo mb_substr($al['remark'],0,12,'utf-8');?></td>
									<td <?php if($al['is_ok'] == 1): ?>style="color: forestgreen"<?php else: ?>style="color: red"<?php endif; ?>><?php if($al['is_ok'] == 1): ?>正常<?php else: ?>失效<?php endif; ?></td>
									<td style="color: red"><?php if($al['type'] == 4): ?>转入账户 :<?php echo ($al["from_username"]); else: echo ($al["intro"]); endif; ?></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table>
						<div id="demo1"></div>
					</div>

					<div class="team_content apply_2" style="display: none;">

						<table>

							<thead>
								<tr>
									<th>时间</th>
									<th>阿纳豆</th>
									<th>类型</th>
								</tr>
							</thead>
							<tbody id="tbody_2">
							<?php if(is_array($consume_3)): $i = 0; $__LIST__ = $consume_3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$al): $mod = ($i % 2 );++$i;?><tr>
									<td><?php echo date('Y-m-d H:i:s',$al['create_time']);?></td>
									<td style="color: red">-<?php echo ($al["money"]); ?></td>
									<td ><?php echo mb_substr($al['type'],0,12,'utf-8');?></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>

							</tbody>
						</table>
						<div id="demo2"></div>
					</div>
					<div class="team_content apply_3" style="display: none;">

						<table>

							<thead>
								<tr>
									<th>时间</th>
									<th>阿纳豆</th>
									<th>类型</th>
									<th>转出账户</th>
								</tr>
							</thead>
							<tbody id="tbody_3">
							<?php if(is_array($allConsume)): $i = 0; $__LIST__ = $allConsume;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$al): $mod = ($i % 2 );++$i;?><tr>
									<td><?php echo date('Y-m-d H:i:s',$al['create_time']);?></td>
									<td >-<?php echo ($al["money"]); ?></td>
									<td ><?php echo mb_substr($al['type'],0,12,'utf-8');?></td>
									<td ><?php echo ($al['to_username']); ?></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table>
						<div id="demo3"></div>
					</div>
					<div class="team_content apply_4" style="display: none;">

						<table>

							<thead>
								<tr>
									<th>时间</th>
									<th>阿纳豆</th>
									<th>类型</th>
									<th>支持影片</th>
								</tr>
							</thead>
							<tbody id="tbody_4">


							<?php if(is_array($consume_1)): $i = 0; $__LIST__ = $consume_1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><tr>
									<td><?php echo date('Y-m-d H:i:s',$c['create_time']);?></td>
									<td>-<?php echo ($c["money"]); ?></td>
									<td><?php echo ($c["type"]); ?></td>
									<td><?php echo ($c["cname"]); ?></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>

							</tbody>
						</table>
						<div id="demo4"></div>
					</div>
					<div class="team_content apply_5" style="display: none;">

						<table>

							<thead>
								<tr>
									<th>时间</th>
									<th>阿纳豆</th>
									<th>类型</th>
									<th>申请影片</th>
								</tr>
							</thead>
							<tbody id="tbody_5">
							<?php if(is_array($consume_2)): $i = 0; $__LIST__ = $consume_2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><tr>
									<td><?php echo date('Y-m-d H:i:s',$c['create_time']);?></td>
									<td>-<?php echo ($c["money"]); ?></td>
									<td><?php echo ($c["type"]); ?></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table>
						<div id="demo5"></div>
					</div>
					<div class="team_content apply_6" style="display: none;">

						<table>

							<thead>
								<tr>
									<th>时间</th>
									<th>方式</th>
									<th>交易号</th>
									<th>阿纳豆</th>
									<th>状态</th>
									<th>备注</th>
								</tr>
							</thead>
							<tbody id="tbody_6">
							<?php if(is_array($orderList)): $i = 0; $__LIST__ = $orderList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$o): $mod = ($i % 2 );++$i;?><tr>
									<td><?php echo date('Y-m-d H:i:s',$o['create_time']);?></td>
									<td><?php echo ($o["payname"]); ?></td>
									<td><?php echo ($o["order_number"]); ?></td>
									<td><?php echo ($o["money"]); ?></td>
									<td><img src="/Public/images/status/<?php echo ($o["is_pass"]); ?>.png"  style="height: auto;width: 40px"></td>
									<td><?php echo mb_substr($o['remark'],0,12,'utf-8');?></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table>
						<div id="demo6"></div>
					</div>
					<div class="team_content apply_7" style="display: none;">

						<table>

							<thead>
								<tr>
									<th>时间</th>
									<th>阿纳豆</th>
									<th>类型</th>
									<th>申请影片</th>
								</tr>
							</thead>
							<tbody id="tbody_7">
							<?php if(is_array($consume_2)): $i = 0; $__LIST__ = $consume_2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><tr>
									<td><?php echo date('Y-m-d H:i:s',$c['create_time']);?></td>
									<td>-<?php echo ($c["money"]); ?></td>
									<td><?php echo ($c["type"]); ?></td>
								</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table>
						<div id="demo7"></div>
					</div>

				</div>
				
				<p>A</p>
				<p>R</p>
				<p>B</p>
				
			</div>


<input type="hidden" value="<?php echo ($personal['money']); ?>" name="jifen">
			<div class="actor" style="display: none;">
				<div class="bg">
					<div class="close_actor"></div>
					<div class="actor_content">
						<div class='movie_list' style="display: block;">
							<?php if(is_array($films)): $i = 0; $__LIST__ = $films;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fi): $mod = ($i % 2 );++$i;?><div>
								<div><img src="<?php echo ($fi['image_url']); ?>" alt=""><p> &nbsp;<?php echo ($fi['name']); ?></p></div>
								<p >需消耗阿纳豆<span id="needand"></span></p>
								<input class="goTodetail" type="button" value="立即申请" data-id="<?php echo ($fi['id']); ?>">
							</div><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
						<div class='movie_intr' style="display: none;">
							<p class='mianbao'><span class="backTo1">电影列表</span><b>></b><span class="backTo2 mianbaoChoice">电影详情</span></p>
							<div class="movie_details">
								<div class="movie_topleft"><img src="/Public/wang/home_img/homeimg03.jpg" alt=""></div>
								<div class="movie_topright">
									<p>电影名称: <span class="filmname"></span></p>

									<p>申请阿纳豆: <span class="needand">70000</span></p>
									<label style="font-size: 16px;">选择申请角色:</label><select name="role">
									</select>
									<p><input class="goToform" type="button" value="点击申请"></p>				
								</div>
								<div class="movie_body">
									<h3>角色性格</h3>
									<p class="intro"></p>
									<h3>角色特征</h3>
									<p class="feature"></p>
									<h3>形象风格</h3>
									<p class="figure"></p>
								</div>
							</div>	
						</div>
						<form class="apply_role" style='display:none;'>
							<p class='mianbao' style="margin-bottom: 20px;"><span class="backTo1">电影列表</span><b>></b><span class="backTo2">电影详情</span><b>></b><span class="backTo3 mianbaoChoice">申请表</span></p>
							<h3 >申请表</h3>
							<div class='movie1'>
							 <label ><span style="color: red">*</span>&nbsp;电影名:</label><a href="#"  class="recruit"></a> </div>
							<div><label><span style="color: red">*</span>&nbsp;姓名:</label><input type="text" name="name"><span>输入真实姓名</span>
							</div>
							<div><label><span style="color: red">*</span>&nbsp;性别:</label><input type="radio" name="sex01" id="man01" value="1" checked><label for="man01">男</label><input type="radio" name="sex01" id="woman01" value="0"><label for="woman01">女</label></div>
							<div><label><span style="color: red">*</span>&nbsp;民族:</label><input style='width: 80px;' type="text" name="volk"></div>
							<div><label><span style="color: red">*</span>&nbsp;生日:</label><input placeholder="例如:1990-01-01" type="date" name="birthday"></div>
							<div><label><span style="color: red">*</span>&nbsp;身高:</label><input type="number" name="realheight"><span>单位:cm</span></div>
							<div><label><span style="color: red">*</span>&nbsp;身份证号:</label><input type="text" name="id_card_"></div>
							<div><label><span style="color: red">*</span>&nbsp;联系电话:</label><input type="text" name="phone1"></div>
							<div><label><span style="color: red">*</span>&nbsp;电子邮箱:</label><input type="text" name="email1"><span>申请的结果将发送至此邮箱</span></div>
							<div><label><span style="color: red">*</span>&nbsp;现居住地:</label><input type="text" name="crraddress"></div>
							<div class="up_photo"><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;生活照:</label><input type="file" id="uploadStar"><input type="button"  value="点击上传"></div>
							<input type="hidden" value="" name="im">
							<div><label style='float: left;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;自我评价:</label><textarea  cols="30" rows="10" name="skill"></textarea></div>
							<div><label style='float: left;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我的特长:</label><textarea  cols="30" rows="10" name="ex"></textarea></div>

<input type="hidden" value="<?php echo ($allc); ?>" name="allc">
<input type="hidden" value="<?php echo ($allcon); ?>" name="allcon">
<input type="hidden" value="<?php echo ($consume_count); ?>" name="consume_count">
<input type="hidden" value="<?php echo ($consume_count_1); ?>" name="consume_count_1">
<input type="hidden" value="<?php echo ($consume_count_2); ?>" name="consume_count_2">
							<input type="button" value="确定申请" id="sure_apply">
							<script src="/Public/js/layer/layui.js"></script>
							<script src="/Public/js/layer/laypage.js"></script>
							<script>


							</script>
							<script>
								//>> 分页
								$(function(){
									layui.use(['laypage', 'layer'], function(){
										var laypage = layui.laypage,layer = layui.layer;
										laypage({
											cont: 'demo1'
											,pages: $('input[name = allc]').val()
											,skip: true
											,jump: function(obj, first){
												if(!first){
													$.ajax({
														'type':'post',
														'dataType':'json',
														'url':"<?php echo U('Home/Personal/personalCenterPaginationA');?>",
														'data':{
															'pgNum':obj.curr,
															'pgSize':17,
														},
														success:function(result){
															$('#tbody_1').html('');
															$.each(result,function(k,v){
                                                                if(v.is_ok==0){
                                                                    $('#tbody_1').append('<tr>'+
                                                                        '<td>'+ v.create_time+'</td>'+'<td  style="color: red">-'+ v.money+'</td>'+
                                                                        '<td >'+ v.remark+'</td>'+ '<td style="color: red">失效</td>'+
                                                                        '<td style="color: red">'+ v.intro+'</td>'+

                                                                        '</tr>');
                                                                }else{
                                                                    $('#tbody_1').append('<tr>'+
                                                                        '<td>'+ v.create_time+'</td>'+'<td  style="color: forestgreen">+'+ v.money+'</td>'+
                                                                        '<td >'+ v.remark+'</td>'+ '<td style="color: forestgreen">正常</td>'+

                                                                        '</tr>');
                                                                }

                                                            });
														}
													});
												}
											}
										});
									});
									layui.use(['laypage', 'layer'], function(){
										var laypage = layui.laypage,layer = layui.layer;
										laypage({
											cont: 'demo2'
											,pages: $('input[name = consume_count]').val()
											,skip: true
											,jump: function(obj, first){
												if(!first){
													$.ajax({
														'type':'post',
														'dataType':'json',
														'url':"<?php echo U('Home/Personal/personalCenterPaginationB');?>",
														'data':{
															'pgNum':obj.curr,
															'pgSize':17,
														},
														success:function(result){
															$('#tbody_2').html('');
															$.each(result,function(k,v){
																$('#tbody_2').append('<tr>'+
																		'<td>'+ v.create_time+'</td>'+
																		'<td style="color: red">-'+ v.money+'</td>'+
																		'<td >'+ v.type+'</td>'+
																		'</tr>');
															});
														}
													});
												}
											}
										});
									});
									layui.use(['laypage', 'layer'], function(){
										var laypage = layui.laypage,layer = layui.layer;
										laypage({
											cont: 'demo3'
											,pages: $('input[name = allcon]').val()
											,skip: true
											,jump: function(obj, first){
												if(!first){
													$.ajax({
														'type':'post',
														'dataType':'json',
														'url':"<?php echo U('Home/Personal/personalCenterPaginationC');?>",
														'data':{
															'pgNum':obj.curr,
															'pgSize':17,
														},
														success:function(result){
															$('#tbody_3').html('');
															$.each(result,function(k,v){
																$('#tbody_3').append('<tr>'+
																		'<td>'+ v.create_time+'</td>'+
																		'<td style="color: red">-'+ v.money+'</td>'+
																		'<td >'+ v.type+'</td>'+
																		'</tr>');
															});
														}
													});
												}
											}
										});
									});
									layui.use(['laypage', 'layer'], function(){
										var laypage = layui.laypage,layer = layui.layer;
										laypage({
											cont: 'demo4'
											,pages: $('input[name = consume_count_1]').val()
											,skip: true
											,jump: function(obj, first){
												if(!first){
													$.ajax({
														'type':'post',
														'dataType':'json',
														'url':"<?php echo U('Home/Personal/personalCenterPaginationD');?>",
														'data':{
															'pgNum':obj.curr,
															'pgSize':17,
														},
														success:function(result){
															$('#tbody_4').html('');
															$.each(result,function(k,v){
																$('#tbody_4').append('<tr>'+
																		'<td>'+ v.create_time+'</td>'+
																		'<td style="color: red">-'+ v.money+'</td>'+
																		'<td >'+ v.type+'</td>'+
																		'</tr>');
															});
														}
													});
												}
											}
										});
									});
									layui.use(['laypage', 'layer'], function(){
										var laypage = layui.laypage,layer = layui.layer;
										laypage({
											cont: 'demo5'
											,pages: $('input[name = consume_count_2]').val()
											,skip: true
											,jump: function(obj, first){
												if(!first){
													$.ajax({
														'type':'post',
														'dataType':'json',
														'url':"<?php echo U('Home/Personal/personalCenterPaginationE');?>",
														'data':{
															'pgNum':obj.curr,
															'pgSize':17,
														},
														success:function(result){
															$('#tbody_5').html('');
															$.each(result,function(k,v){
																$('#tbody_5').append('<tr>'+
																		'<td>'+ v.create_time+'</td>'+
																		'<td style="color: red">-'+ v.money+'</td>'+
																		'<td >'+ v.type+'</td>'+
																		'</tr>');
															});
														}
													});
												}
											}
										});
									});
									layui.use(['laypage', 'layer'], function(){
					var laypage = layui.laypage,layer = layui.layer;
					laypage({
						cont: 'demo6'
						,pages: $('#count').val()
						,groups: 0
						,first: false
						,last: false
						,jump: function(obj, first){
							if(!first){
								$.ajax({
									'type':'post',
									'dataType':'json',
									'url':'',
									'data':{
										'pgNum':obj.curr,
										'pgSize':12
									},
									success:function(result){
										$('#tbody_6').html('');
															$.each(result.orderList,function(k,v){
																$('#tbody_6').append('<tr>'+
																		'<td>'+ v.create_time+'</td>'+
																		'<td style="color: red">-'+ '银行转账'+'</td>'+
																		'<td >'+  v.order_number+'</td>'+
																		'<td >'+   v.money+'</td>'+
																		'<td >'+   '<img style="height:18px;width:18px;border-radius:50%" src="/Public/images/status/'+ v.is_pass+'.png">'+'</td>'+
																		'<td >'+   ''+'</td>'+
																		'</tr>');
															});
									}
								});
							}
						}
					});
				});
								});


								//>> 提现输入框失去焦点事件
								$('input[name = exMoney]').blur(function(){
									//>> 获取值
									e = $(this).val();
									//>> 判断金额
									if(e != '' && !isNaN(e)){
										if(e <= 700){
											layer.open({
												btn:['确定'],
												btn1:function(){
													$.ajax({
														'type':'post',
														'dataType':'json',
														'url':location.protocol+'//'+window.location.host+'/Home/Personal/exportAgree',
														'data':{
															'export':$('input[type = checkbox]:checked').val()
														},
														complete:function(){
															layer.closeAll('page');
														}
													});

												},
												btnAlign: 'c',
												type: 1 //Page层类型
												,area: ['500px', '700px']
												,title: '阿纳巴里用户协议'
												,shade: 0.6 //遮罩透明度
												,anim: 1 //0-6的动画形式，-1不开启
												,content: '<div style="padding:50px;overflow: auto"><?php echo htmlspecialchars_decode($systemInfo['tixian']);?><div style=";margin-top: 30px"><input type="checkbox" id="agree" value="1"><span>我同意<a id="anbl_argement" style="color: #666;cursor: pointer;">《阿纳巴里用户协议》</a></span></div>'
											});
										}
									}else{
										layer.tips('请输入提现阿纳豆数额','input[name = exMoney]');
										return false;
									}
								});
								/**
								 * 充值验证
								 */
								$('input[name = rechargeMoney]').blur(function(){
									//>> 获取内容
									data = $(this).val();

									if(data == ''){
										layer.tips('请输入充值阿纳豆数额','input[name = rechargeMoney]');
										return false;
									}
									if(!isNaN(data)){
										//>> 判断当前的数字值
										if(data <= 700 ){
											//在这里面输入任何合法的js语句
											layer.open({
												btn:['确定'],
												btn1:function(){
													$.ajax({
														'type':'post',
														'dataType':'json',
														'url':location.protocol+'//'+window.location.host+'/Home/Personal/agree',
														'data':{
															'agree':$('input[type = checkbox]:checked').val()
														},
														complete:function(){
															layer.closeAll('page');
														}
													});

												},
												btnAlign: 'c',
												type: 1 //Page层类型
												,area: ['500px', '700px']
												,title: '阿纳巴里用户协议'
												,shade: 0.6 //遮罩透明度
												,anim: 1 //0-6的动画形式，-1不开启
												,content: '<div style="padding:50px;overflow: auto"><?php echo htmlspecialchars_decode($systemInfo['chonzhi']);?><div style=";margin-top: 30px"><input type="checkbox" id="agree" value="1"><span>我同意<a id="anbl_argement" style="color: #666;cursor: pointer;">《阿纳巴里用户协议》</a></span></div>'
											});
										}
									}else{
										layer.tips('请输入正确的数字','input[name = rechargeMoney]');
									}
								});

								//这里弹出层显示的内容你 来写快一点 就是下面的字
								$(function(){

									$('#sure_apply').click(function(){
										var needintegral = $('.needand').text();
										var name = $('input[name = name]').val();
										var sex = $('input[name = sex01]').val();
										var volk = $('input[name = volk]').val();
										var birthday = $('input[name = birthday]').val();
										var height_ = $('input[name = realheight]').val();
										var id_card_ = $('input[name = id_card_]').val();
										var phone = $('input[name = phone1]').val();
										var email = $('input[name = email1]').val();
										var crraddress = $('input[name = crraddress]').val();
										var skill = $('textarea[name = skill]').val();
										var ex = $('textarea[name = ex]').val();
										var image_url = $('input[name = im]').val();

										if(name == ''){
											layer.tips('姓名不能为空','input[name = name]');
											return;
										}else{
											if(sex == ''){
												layer.tips('性别不能为空','input[name = sex01]');
												return;
											}else{
												if(volk == ''){
													layer.tips('民族不能为空','input[name = volk]');
													return;
												}else{

													if(birthday == ''){
														layer.tips('生日不能为空','input[name = birthday]');
														return;
													}else{
														if(height_== ''){
															layer.tips('身高不能为空','input[name = realheight]');
															return;
														}else{
															if(id_card_ == ''){
																layer.tips('身份证号不能为空','input[name = id_card_]');
																return;
															}else{
																var reg = /\d{14}(\d{4}|(\d{3}[xX])|\d{1})/;
																if(!reg.test(id_card_)){
																	layer.tips('身份证号格式不正确','input[name = id_card_]');
																	return;
																}

																if(phone == ''){
																	layer.tips('手机号不能为空','input[name = phone1]');
																	return;
																}else{

																	if(email == ''){
																		layer.tips('邮箱不能为空','input[name = email1]');
																		return;
																	}else{
																		reg_ = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
																		if(!reg_.test(email)){
																			layer.tips('邮箱格式不正确','input[name = email1]');
																			return;
																		}else{
																			if(crraddress == ''){
																				layer.tips('居住不能为空','input[name = crraddress]');
																				return;
																		}
																	}
																}
															}
														}
													}
												}
											}
										}}
										 url = location.protocol+'//'+window.location.host+'/Home/Personal/star';
										$.ajax({
											'type':'post',
											'dataType':'json',
											'url':url,
											'data':{
												'name':name,
												'sex':sex,
												'volk':volk,
												'birthday':birthday,
												'height':height_,
												'id_card':id_card_,
												'phone':phone,
												'email':email,
												'address':crraddress,
												'skill':skill,
												'ex':ex,
												'image_url':image_url,
												'money':needintegral ? needintegral : 0,
											},
											success:function(result){
												if(result.status == 1){
													layer.open({
														type: 2,
														title: '提示',
														btn: ['确定'],
														shadeClose: true,
														shade: 0.8,
														area: ['380px', '30%'],
														content: "<?php echo U('Home/Personal/tips');?>", //iframe的url
														btn1:function(){
															location.reload();
														}
													});
												}else{
													layer.msg(result.msg);
												}
											}
										});
									});
								});
							</script>
						</form>
					</div>
				</div>
				<p>A</p>
				<p>R</p>
				<p>B</p>
			</div>
			<input type="hidden"  value="" name="film_id">
		</div>
	</div>
	<script src='/Public/wang/common_js/jquery-1.12.4.min.js'></script>
	<script src='/Public/area/area.js'></script>
	<script src='/Public/wang/common_js/common.js'></script>
	<script src='/Public/wang/personal_center.js'></script>
	<script src="/Public/code/js/jquery.html5upload.js"></script>
	<!--layer.js-->
	<script src="/Public/layer/layer.js" type="text/javascript"></script>
	<script src="/Public/js/layer/layui.js"></script>
	<script src="/Public/js/layer/laypage.js"></script>
	<script src="/Public/js/clipboard.min.js"></script>
	<script type="text/javascript">
		$(function () {

            $('.copy').click(function(){
                var clipboard = new Clipboard('.copy');
                //优雅降级:safari 版本号>=10,提示复制成功;否则提示需在文字选中后，手动选择“拷贝”进行复制
                clipboard.on('success', function(e) {
                    layer.msg('复制成功');
                    e.clearSelection();
                });
                clipboard.on('error', function(e) {
                   layer.msg('复制失败');
                });
            });



			var cancel_id = '';
			$('body').on('click','.cancel_suport',function(){
				cancel_id = $(this).attr('data-id');
			});
			//>> 点击"取消支持"
			$('.sure_input').click(function(){
				$.ajax({
					'type':'post',
					'dataType':'json',
					'url':location.protocol+'//'+window.location.host+'/Home/Personal/feedBack',
					'data':{
						'orderId':cancel_id,
					},
					success:function(e){
						if(e.status == 1){

							layer.msg('退款成功',function(){
								location.reload();
							});
						}else{
							layer.msg(e.msg,function(){
								location.reload();
							});
						}
					}
				});
			});
			//>> 点击进入电影详情页
			$('.goTodetail').click(function(){

				var film_id = $(this).attr('data-id');
				$('input[name = film_id]').val(film_id);
				$.ajax({
					'type':'post',
					'dataType':'json',
					'url':location.protocol+'//'+window.location.host+'/Home/Personal/filmDetail',
					'data':{'id':film_id},
					success:function(e){
						$('.filmname').text(e.film.name);
						$('select[name = role]').html('');
						$.each(e.role,function(k,v){
							$('select[name = role]').append('<option value="'+ v.id+'">'+ v.name+'</option>');
						});
						$('.intro').text(e.roleDetail.intro);
						$('.feature').text(e.roleDetail.feature);
						$('.figure').text(e.roleDetail.figure);
						$('.needand').text(e.roleDetail.money);
					}
				});

			});

			//>> 点击切换角色
			$('select[name = role]').change(function(){
				$.ajax({
					'type':'post',
					'dataType':'json',
					'url':location.protocol+'//'+window.location.host+'/Home/Personal/getFilm',
					'data':{
						'film_id':$('input[name = film_id]').val(),
						'role_id':$(this).val(),
					},
					success:function(e){
						if(e.data != ''){
							$('.intro').text(e.data.intro);
							$('.feature').text(e.data.feature);
							$('.figure').text(e.data.figure);
							$('.needand').text(e.data.money);
						}else{
							$('.intro').text('');
							$('.feature').text('');
							$('.figure').text('');
							$('.needand').text('');
						}
					}
				});
			});

			//>> 点击申请
			$('.goToform').click(function(){
				rid = $('select[name = role]').val();
				$.ajax({
					'type':'post',
					'dataType':'json',
					'url':location.protocol+'//'+window.location.host+'/Home/Personal/saveId',
					'data':{'roleId':rid},
					success:function(e){

					}
				});

				//>> 获取当前的电影名
				fname = $('.filmname').text();
				$('.recruit').text(fname);

			});

			$("#file_upload").h5upload({
				url: "<?php echo U('Home/Personal/upload');?>",
				fileObjName: 'image',
				fileTypeExts: 'jpg,png,gif,bmp,jpeg',
				multi: true,
				accept: '*/*',
				fileSizeLimit: 1024 * 1024 * 1024 * 1024,
				formData: {
					type: 'card_positive'
				},
				onUploadProgress: function (file, uploaded, total) {

				},
				onUploadSuccess: function (file, data) {
					data = $.parseJSON(data);
					if (data.status == 0) {
						layer.alert(data.msg, {time: 1000})
					} else {
						var _isMax = false;
						var path = data.url;
						// 获取图片列表
						$('#images').val(path);
						$('#container1').html('');
						$('#container1').html('<div style=" width: 100%;height: 200px;"><img src="'+path+'" alt=""></div>');
						if (_isMax == false) {
							layer.msg('上传成功', {time: 1000})

						}
					}
				},
				onUploadError: function (file) {
					layer.alert('上传失败');
				}
			});
			$("#file_upload2").h5upload({
				url: "<?php echo U('Home/Personal/upload');?>",
				fileObjName: 'image',
				fileTypeExts: 'jpg,png,gif,bmp,jpeg',
				multi: true,
				accept: '*/*',
				fileSizeLimit: 1024 * 1024 * 1024 * 1024,
				formData: {
					type: 'card_positive'
				},
				onUploadProgress: function (file, uploaded, total) {

				},
				onUploadSuccess: function (file, data) {
					data = $.parseJSON(data);
					if (data.status == 0) {
						layer.alert(data.msg, {time: 1000})
					} else {
						var _isMax = false;
						var path = data.url;
						// 获取图片列表
						$('#images').val(path);
						$('#container2').html('');
						$('#container2').html('<div style=" width: 100%;height: 200px;"><img src="'+path+'" alt=""></div>');
						if (_isMax == false) {
							layer.msg('上传成功', {time: 1000})

						}
					}
				},
				onUploadError: function (file) {
					layer.alert('上传失败');
				}
			});
			$("#upload").h5upload({
				url: "<?php echo U('Home/Personal/upload');?>",
				fileObjName: 'image',
				fileTypeExts: 'jpg,png,gif,bmp,jpeg',
				multi: true,
				accept: '*/*',
				fileSizeLimit: 1024 * 1024 * 1024 * 1024,
				formData: {
					type: 'card_positive'
				},
				onUploadProgress: function (file, uploaded, total) {

				},
				onUploadSuccess: function (file, data) {
					data = $.parseJSON(data);
					if (data.status == 0) {
						layer.alert(data.msg, {time: 1000})
					} else {
						var _isMax = false;
						var path = data.url;
						// 获取图片列表
						$('#question').val(path);
						if (_isMax == false) {
							layer.msg('上传成功', {time: 1000})

						}
					}
				},
				onUploadError: function (file) {
					layer.alert('上传失败');
				}
			});
			var  path = [];
			$("#uploadStar").h5upload({
				url: "<?php echo U('Home/Personal/upload');?>",
				fileObjName: 'image',
				fileTypeExts: 'jpg,png,gif,bmp,jpeg',
				multi: true,
				accept: '*/*',
				fileSizeLimit: 1024 * 1024 * 1024 * 1024,
				formData: {
					type: 'card_positive'
				},
				onUploadProgress: function (file, uploaded, total) {

				},
				onUploadSuccess: function (file, data) {
					data = $.parseJSON(data);
					if (data.status == 0) {
						layer.alert(data.msg, {time: 1000})
					} else {
						var _isMax = false;
						path.push(data.url);
						// 获取图片列表
						$('input[name = im]').val(path);
						if (_isMax == false) {
							layer.msg('上传成功', {time: 1000})

						}
					}
				},
				onUploadError: function (file) {
					layer.alert('上传失败');
				}
			});
				
			$('#ask_btn').click(function(){
				title = $('input[name = question]').val();
				content = $('textarea[name = content]').val();
				url = location.protocol+'//'+window.location.host+'/Home/Consult/add';
				if(title == ''){
					layer.msg('提问标题不能为空');
					return false;
				}
				if(content == ''){

					layer.msg('问题内容不能为空');
					return false;
				}
				
				//>> 正则过滤js
				reg = /^[^\|"'<>/]*$/;
				if(reg.test(content) || reg.test(title)){
				layer.msg('含非法字符,请重新输入');
					return false;
				}
				$.ajax({
					'type':'post',
					'dataType':'json',
					'url':url,
					'data':{
						'title':title,
						'content':content,
						'image_url':$('#question').val(),
					},
					success:function(result){
						if(result.status == 1){
							layer.msg('您的问题已保存,请等待管理员回复',function(){
								location.reload();
							});
						}
					}
				});
			});
			layui.use(['laypage', 'layer'], function(){
				var laypage = layui.laypage,layer = layui.layer;
				laypage({
					cont: 'demo8'
					,pages: $('input[name = page_1]').val()
					,groups: 0
					,first: false
					,last: false
					,jump: function(obj, first){
						if(!first){
							$.ajax({
								'type':'post',
								'dataType':'json',
								'url':"<?php echo U('Home/Personal/mySupport');?>",
								'data':{
									'pgNum':obj.curr,
									'pgSize':4
								},
								success:function(result){

									$('div[class = my_suport] > div').remove();
									$.each(result.rows,function(k,v){
										$('div[class = my_suport]').append('<div>'+
												'<img src="'+ v.image_url+'" alt="" style="height: 180px;width: 420px">'+
												'<div class="movie_content">'+
												'<p>片名:'+ v.name+'</p>'+
										'<p>'+ v.englishname+'</p>'+
										'<p>'+ v.director+'</p>'+
										'<p><span>'+ v.support_number+'</span>人支持</p>'+
														'<p>类型:<span><?php if('+ v.atype+' == 1): ?>月酬<?php else: ?>票房<?php endif; ?></span>&nbsp;&nbsp;收益:<span><?php if('+ v.atype+' == 1): ?>'+ v.fixed+'<?php else: ?>'+ v.float+'<?php endif; ?></span></p>'+
												'<p>已支持<span>'+ v.support_money+'</span>阿纳豆</p>'+												'<p><input type="button" class="cancel_suport" value="取消支持" data-id="'+ v.aid+'"></p>'+
										        "<a class='detail_search' href='<?php echo U('home/index/detail');?>?id="+ v.id+"'> 查看详情</a>"+
										'</div>');
									});

								}
							});
						}
					}
				});
			});
			layui.use(['laypage', 'layer'], function(){
				var laypage = layui.laypage,layer = layui.layer;
				laypage({
					cont: 'demo9'
					,pages: $('input[name = page_2]').val()
					,groups: 0
					,first: false
					,last: false
					,jump: function(obj, first){
						if(!first){
							$.ajax({
								'type':'post',
								'dataType':'json',
								'url':"<?php echo U('Home/Personal/myCollection');?>",
								'data':{
									'pgNum':obj.curr,
									'pgSize':4
								},
								success:function(result){

									$('div[class = my_collect] > div').remove();
									$.each(result.rows,function(k,v){
										$('div[class = my_collect]').append('<div><img src="'+ v.image_url+'" style="height: 180px;width: 420px" alt="">'+
										'<div class="movie_content">'+
												'<p>片名:'+ v.name+'</p>'+
										'<p>'+ v.englishname+'</p>'+
										'<p>'+ v.country+'/'+ v.duration+'分钟</p>'+
										'<p>'+ v.date+'/'+ v.showaddress+'</p>'+
										'<p style="color: #e50909;"><i></i>'+ '已收藏'+'</p>'+
											'<p style="text-align: right;"><input style="float: right;" type="button" data-id="'+v.cid+'" class="cancel_collect" value="取消收藏"></p>'+
										'</div>'+
										'</div>');
									});
								}
							});
						}
					}
				});
			});

			$('#editPassword').click(function(){

				password = $('input[name = password]').val();
				newpassword = $('input[name = newpassword]').val();
				repassword = $('input[name = repassword]').val();
				//var reg = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/;
				if(password == ''){
					layer.tips('当前密码不能为空','input[name = password]');return;
				}
				if(newpassword == ''){
					layer.tips('新密码不能为空','input[name= newpassword]');return;
				}
				if(repassword == ''){
					layer.tips('确认密码不能为空','input[name= repassword]');return;
				}
				if(repassword != newpassword){

					layer.msg('两次输入的密码不一致');return;
				}
				if(password.length < 6 || newpassword.length < 6 || repassword.length < 6){
					layer.msg('密码长度至少6位');return;
				}
				$.ajax({
					'type':'post',
					'dataType':'json',
					'url':"<?php echo U('Home/Personal/editPassword');?>",
					'data':{
						'password':password,
						'newpassword':newpassword,
						'repassword':repassword
					},
					success:function(result){
						if(result.status == 1){
							$(this).css('display','none');
							layer.msg(result.msg,function(){
								location.reload();
							});
						}else{
							layer.msg(result.msg);
						}
					}
				});

			});


				//>> 点击"取消收藏"
            $('body').on('click','.cancel_collect',function(){
					$.ajax({
						'type':'post',
						'dataType':'json',
						'url':location.protocol+'//'+window.location.host+'/Home/Personal/cancel',
						'data':{
							'id':$(this).attr('data-id'),
						},
						success:function(e){
							if(e.status == 1){

								layer.msg('取消成功',function(){
									location.reload();
								});
							}else{
								layer.msg(e.msg,{time:3},function(){
									location.reload();
								});
							}
						}
					});
				});

		});
	</script>
</body>
</html>