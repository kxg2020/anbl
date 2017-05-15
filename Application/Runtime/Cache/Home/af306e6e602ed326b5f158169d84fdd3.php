<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/wang/common_css/reset.css">
	<link rel="stylesheet" href="/Public/wang/details/details.css">
		<!--layer-->
	<link href="/Public/css/layui.css" rel="stylesheet">
	<style>
		*{ margin:0; padding:0; list-style:none;}
		a{ text-decoration:none;}
		a:hover{ text-decoration:none;}
		.tcdPageCode{padding: 15px 20px;text-align: left;color: #ccc;}
		.tcdPageCode a{display: inline-block;color: #428bca;display: inline-block;height: 25px;	line-height: 25px;	padding: 0 10px;border: 1px solid #ddd;	margin: 0 2px;border-radius: 4px;vertical-align: middle;}
		.tcdPageCode a:hover{text-decoration: none;border: 1px solid #428bca;}
		.tcdPageCode span.current{display: inline-block;height: 25px;line-height: 25px;padding: 0 10px;margin: 0 2px;color: #fff;background-color: #428bca;	border: 1px solid #428bca;border-radius: 4px;vertical-align: middle;}
		.tcdPageCode span.disabled{	display: inline-block;height: 25px;line-height: 25px;padding: 0 10px;margin: 0 2px;	color: #bfbfbf;background: #f2f2f2;border: 1px solid #bfbfbf;border-radius: 4px;vertical-align: middle;}
	</style>
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

	<div class="content">
		<div class="content_left">
			<img id='title_img' src="<?php echo ($info["image_url"]); ?>" alt="moive_img">
			<input type="hidden" value="<?php echo ($info['id']); ?>" name="movie_id">
			<input type="hidden" value="<?php echo ($userInfo['id']); ?>" name="user_id">
			<div id="title"><?php echo ($info["name"]); ?></div>
			<div class="movie_introduce">
				<p id="back"><span>-</span>剧情简介</p>
				<div class="expect back" style="display: block;">
					<?php echo htmlspecialchars_decode($info['story']);?>
				</div>
				<p id="framework"><span>+</span>演艺阵容</p>
				<div class="expect framework" >
					<?php echo htmlspecialchars_decode($info['analysis']);?>
				</div>
				<p id="analyse"><span>+</span>受众定位</p>
				<div class="expect analyse">
					<?php echo htmlspecialchars_decode($info['film_critic']);?>
				</div>
					<p id="comment_film"><span>+</span>预期回报</p>
					<div class="expect comment_film">
						<?php echo htmlspecialchars_decode($info['expected_return']);?>
				</div>
			</div>
		</div>
		<div class="content_right">
			<div class="collect">
				<p>#<?php echo ($info['title']); ?></p>
				<p><?php echo date('Y-m-d',$info['start_time']);?> 至 <?php echo date('Y-m-d',$info['end_time']);?></p>
				<p><span id="skl"><?php echo ($info["collection_number"]); ?></span>人收藏 <input id="fast_collect" type="button" data-id="<?php echo ($info['id']); ?>" onclick="collect()" value="立即收藏"></p>
			</div>
			<div class="suport">
				<p>已支持阿纳豆</p>
				<p> <span><?php echo floor($info['money']);?></span><span style="color: black;margin-top: 21px; width: auto;height: 30px;float: right;font-size: 25px;line-height: 30px;"><?php echo getProjectSpeed($info['speed']);?></span></p>
				<p>该项目在<?php echo date('Y/m/d',$info['end_time']);?>募集到<?php echo floor($info['target_amount']);?>阿纳豆视为成功！</p>
				<div class='view_suport'><p style="color: #e50909;margin-top: 15px;">项目支持进展</p><p class='progress_bar'><span style="width: <?php echo ($info['money']/$info['target_amount'])*100;?>%"></span></p></div>
				<ul class="suport_inform">
					<li><p>目标阿纳豆</p>
					<p><span ><?php echo floor($info['target_amount']);?></span></p>
				</li>
				<li>
					<p>支持人数</p>
					<p><?php echo ($info['support_number']); ?>人</p>
				</li>
					<?php if($info['target_amount'] > $info['money']): ?><input  style="border: none"  type="button"  class="now_suport" id="fast_suport" value="立即支持">
						<?php else: ?>
						<input  style="border: none"  type="button" disabled  class="now_suport"  value="筹集成功"><?php endif; ?>

				</ul>
				
			</div>
			<div class="comment">
				<ul class="switch">
					<li id="schedule" class="choice">项目进度</li>
					<li id="forecast">收益预测</li>
					<li id="commentLi">评论</li>
				</ul>
				<div class="commentLi" style="display: none;">

					<!--<ul class="comment_ul">
						<li class="comment_choice chk" _type="1">导演</li>
						<li _type="2" class="chk">演员</li>
						<li _type="3" class="chk">故事</li>
						<li _type="4" class="chk">后期</li>
					</ul>-->
					<div class="loginorreg"><?php if($isLogin == 0): ?><a href="<?php echo U('Home/Login/index');?>"><span>登录</span></a> | <a href="<?php echo U('Home/Register/index');?>"><span>注册</span></a><?php endif; ?></div>
					<input type="hidden" value="<?php echo ($count); ?>" id="count">
					<textarea name="name" rows="8" cols="80" placeholder="输入我的想法" id="mainContent"></textarea>
					<div class="publish now_suport" id="ok">发表</div>
					<div class="publish_area">
						<?php if(is_array($comment)): $i = 0; $__LIST__ = $comment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><p><img src="/Public/wang/img/1.jpg" style="width: 30px;height: 30px"><span><?php echo ($c['username']); ?></span>:<?php echo ($c['content']); ?></p><?php endforeach; endif; else: echo "" ;endif; ?>

					</div>
					<div class="tcdPageCode"></div>
				</div>
				<div class="schedule">
					<?php if(is_array($dynamic)): $i = 0; $__LIST__ = $dynamic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><li><time><?php echo date('Y-m-d',$info['create_time']);?><img src="/Public/wang/details/img/sound.png" ></time><div><?php echo htmlspecialchars_decode($info['content']);?></div></li><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<div class="forecast" style="display: none">

				</div>
			</div>
		</div>
		<div class="suport_bg" style="display: none;">
			<div  id="suport">
				<p>回报类型:</p>
				<p class="fenghong"><input type="radio" name="fenhong" value="1" checked><span style="margin-right: 100px;">月酬</span><input type="radio" name="fenhong" value="2"><span>票房</span></p>
				<p>输入支持阿纳豆:</p>
				<p class="jifeng">
					<input type="number" name="money" placeholder="支持100-70000且需为100整数" style="width: 230px"  />
				</p>
				<p><input type="checkbox" id="is_true"><span>我同意<a id="anbl_argement" style="color: #666;cursor: pointer;">《阿纳巴里用户协议》</a></span></p>
				<div><span id="sure_suport">确定支持</span><span id="cancel">取消</span></div>
			</div>
			<div class="argement"  style="display: none;">
				<h3>一.收益制度</h3>
				<p>1.月酬：10%</p>
				<p>(1) 按照作品的拍摄周期最高拿3个月，作品上映后本金全额返回支持者账户，每部作品从拍摄到上映不超过6个月。</p>
				<p>(2) 每周可提总积分的2.5%，但需账户满350积分。</p>
				<p>(3) 作品筹备开放之日起满1个月未达到指定目标，则全额返还支持者账户。</p>
				<p>2.票房：-100%-300%</p>
				<p>(1) 每份投资的收益比例按作品的真实票房确定。</p>
				<p>(2) 普通作品封闭三个月后出票房数据后开放提现。</p>
				<p>(3) 院线作品封闭期根据拍摄周期确定。</p>
				<h3>二.动态制度</h3>
				<p>1.等级划分</p>
				<p>(1) 支持者：投资700积分</p>
				<p>(2) 经纪人：推荐5名支持者</p>
				<p>(3) 制片人：个人支持35000积分以上，推荐10名支持者，至少培养1名经纪人，团队100人</p>
				<p>(4) 出品人：个人投资70000积分以上，推荐30名支持者，至少培养1名制片人，团队500人</p>
				<p>2.佣金收益</p>
				<p>(1) 支持者：拿一代投资额的5%及一代票房收益的5%</p>
				<p>(2) 经纪人：拿二代投资额的5%，3%及二代票房收益的5%，3%</p>
				<p>(3) 制片人：拿三代投资额的5%，3%，1%及二代票房收益的5%，3%，1%，享受三代以外每月新增业绩的2%</p>
				<p>(4) 出品人：拿三代投资额的5%，3%，1%及三代票房收益的5%，3%，1%，享受三代以外每月新增业绩的4%</p>
				<h3>三.提现制度</h3>
				<p>1.周提现：每周五可提现，每次手续费10%</p>
				<p>2.月提现：每月的最后一天可提现，免手续费</p>
				<h3>四.退本制度</h3>
				<p>1.余额退本：扣除10%手续费，7-15个工作日到账</p>
				<p>2.投资退本：扣除所有收益和10%的手续费，7-15个工作日到账</p>
				<p>2.投资退本：截止日期前的一周内，不在受理退款请求</p>
				<div class="close_btn">关闭</div>
			</div>
		</div>
		<input type="hidden" value="<?php echo ($count_1); ?>" name="pages_1">
	</div>

	<script src='/Public/wang/common_js/jquery-1.12.4.min.js'></script>
	<script src='/Public/wang/common_js/common.js'></script>
	<script src='/Public/wang/details/details.js'></script>
	<script src="/Public/js/layer/layui.js"></script>
	<script src="/Public/js/layer/laypage.js"></script>
	<script src="/Public/layer/layer.js"></script>
	<script src="/Public/js/page.js"></script>
	<script>
		$(function(){
			$(".tcdPageCode").createPage({
				pageCount:$('#count').val(),
				current:1,
				backFn:function(pgNum){

					id = $('input[name = movie_id]').val();
					// 获取评论的类型
					type = $('.comment_choice').attr('_type');
					console.log(type);
					$.ajax({
						'type':'post',
						'dataType':'json',
						'url':"<?php echo U('Home/Index/pageSelect');?>",
						'data':{
							'movie_id':id,
							'type':type,
							'pgNum':pgNum,
						},
						success:function(result){
							$('div[class = publish_area]').html('');
							if(result.status == 1){
								$.each(result.directorArr,function(k,v){
									$('div[class = publish_area]').append(
											'<p><img src="/Public/wang/img/1.jpg" style="width: 30px;height: 30px"><span>'+ v.username+'</span>:'+ v.content+'</p>'

									);
								});
								$(".tcdPageCode").createPage({
									pageCount:result.pages,
									current:result.crrpage,
									backFn:function(p){

									}
								});
							}
						}
					});
				}
			});
			//>> 发表主评论
			$('#ok').click(function(){
				//>> 判断是否登录
				var userInfo = $('input[name = user_id]').val();
				if(userInfo == ''){
					layer.msg('请先登录再评论');
					return ;
				}

				//>> 获取评论内容
				var content = $('#mainContent').val();
				var id = $('input[name = movie_id]').val();

				// 获取评论的类型
				var type = $('.comment_choice').attr('_type');

				//>> 判断是否为空
				if(content.length == 0){
					layer.tips('请输入您的评论', '#mainContent');
				}else{
					$.ajax({
						'type':'post',
						'dataType':'json',
						'url':"<?php echo U('Home/Comment/add');?>",
						'data':{
							'content':content,
							'movie_id':id,
							'type':type
						},
						success:function(result){
							if(result.status == 1){
								layer.msg('评论成功!');
								$('div[class = publish_area]').append(
										'<p><img src="/Public/wang/img/1.jpg" style="width: 30px;height: 30px"><span>'+ result.data.username+'</span>:'+ result.data.list+'</p>'

								);
							}else{
								layer.msg('评论失败!');
							}
						}
					});
				}
			});
			$('.chk').click(function(){
				$('div[class = publish_area]').html('');
				id = $('input[name = movie_id]').val();
				// 获取评论的类型
				type = $('.comment_choice').attr('_type');
				$.ajax({
					'type':'post',
					'dataType':'json',
					'url':"<?php echo U('Home/Index/pageSelect');?>",
					'data':{
						'movie_id':id,
						'type':type,
						'pgNum':1
					},
					success:function(result){

						if(result.status == 1){

							$.each(result.directorArr,function(k,v){
								$('div[class = publish_area]').append(
										'<p><img src="/Public/wang/img/1.jpg" style="width: 30px;height: 30px"><span>'+ v.username+'</span>:'+ v.content+'</p>'

								);
							});
							$(".tcdPageCode").createPage({
								pageCount:result.pages,
								current:result.crrpage,
								backFn:function(p){

								}
							});
						}else{
							$("div[class = tcdPageCode]").empty();
						}
					}
				});
			})
		});
	</script>
     <script type="application/javascript">
		 $('#fast_suport').on('click', function () {
			 var  isLogin = "<?php echo ($isLogin); ?>";
			 console.log(isLogin);
			 if(isLogin == 0){
				 layer.confirm('您还没有登录', {
					 btn: ['登录','取消'] //按钮
				 }, function(){
					 window.location.href = "<?php echo U('Home/Login/index');?>"
				 }, function(){
				 });
				 return false;
			 }else{
				 $('.suport_bg').fadeIn('slow');
				 $('.argement').hide();
			 }
		 });
		 $('#sure_suport').on('click',function(){

			 // 判断用户是否同意协议
			 if(!$("#is_true").is(':checked')){
				 layer.msg('请同意服务协议');
				 return false
			 }
			 // 选择分红方式
			 var fh = $(".fenghong>input[type='radio']:checked").val();

			 // 选择积分多少
			 var money = $(".jifeng>input[type='number']").val();
			 if(money<100 || money>70000){
				 layer.msg('阿纳豆不能少于100或者大于70000');
				 return false
			 }
			 if(money%100 != 0){
				 layer.msg('阿纳豆必须是100的倍数');
				 return false
			 }

			 var project_id="<?php echo ($info['id']); ?>";
			 var _data = {
				 money : money,
				 project_id : project_id,
				 type : fh
			 };
			 $.post("<?php echo U('home/index/support');?>",_data,function (data) {
				 if (data.status == 0) {
					 layer.alert(data.msg);
				 } else {
					 layer.msg(data.msg,function(){
						 location.reload();
					 });
					 $('.suport_bg').hide();
				 }
			 });
		 })

		 function collect(){
			 var _id = $('#fast_collect').attr('data-id');
			 $.post("<?php echo U('home/index/collect');?>",{project_id:_id},function (data) {
				 if (data.status == 0) {
					 layer.confirm('您还没有登录', {
						 btn: ['登录','取消'] //按钮
					 }, function(){
						 window.location.href = "<?php echo U('Home/Login/index');?>"
					 }, function(){
					 });
				 } else if(data.status == 2) {
					 layer.msg(data.msg);
				 }else{
					 $('#skl').text(data.info);
					 layer.msg(data.msg);
				 }
			 });
		 }

	 </script>
</body>
</html>