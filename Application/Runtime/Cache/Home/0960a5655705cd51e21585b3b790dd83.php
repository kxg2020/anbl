<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/wang/common_css/reset.css">
	<link rel="stylesheet" href="/Public/wang/common_css/common.css">
	<link rel="stylesheet" href="/Public/wang/factory/demo.css">
	<link rel="stylesheet" href="/Public/wang/factory/style5.css">
	<link rel="stylesheet" href="/Public/wang/factory/star_factory.css">
	<link href="/Public/css/layui.css" rel="stylesheet">
	<title>星工场</title>
</head>
<body>
	<header>
		<a class="logo" href="/home/index/index.html"><img src="/Public/wang/img/logo.png"></a>
		<div class="star_factory">
			
		</div>
		    <div class="menu_logo">
				<div class="burger2 menu">
				      <div class="icon"></div>
				</div>
			</div>
			<div class="menu_content">
				<p>A</p>
				<p>R</p>
				<p>B</p>
				<div class="hide_menu">
					<ul class="login_reg">
						<?php if($userInfo['username'] == ''): ?><li ><a href="<?php echo U('Home/Register/index');?>">注册</a></li>
							<li ><a id="login" href="<?php echo U('Home/Login/index');?>">登录 |</a></li>
							<?php else: ?>
							<li class="login_out"><a href="<?php echo U('Home/Login/logout');?>">退出登录</a></li>
							<li class="user_img" style="color: white"><?php echo telephoneNumber($userInfo['username']);?></li><?php endif; ?>
						<li class='search_li' style="position: relative;"><input id="search_cont" type="text"><i id="search_btn"></i></li>
					</ul>
					<p><a href="<?php echo U('home/index/index');?>">首页</a></p>
					<p style="margin-bottom: 22px;"><a href="">公司介绍</a></p>
					<div><span></span><a href="<?php echo U('home/company/about');?>">关于我们</a></div>
					<div style="margin-bottom:43px;"><span></span><a href="<?php echo U('home/company/index');?>">公司文化</a></div>
					<p><a href="<?php echo U('home/market/index');?>">电影超市</a></p>
					<p><a href="<?php echo U('home/factory/index');?>">星工场</a></p>
					<p><a href="<?php echo U('Home/Personal/index');?>">个人中心</a></p>
					<div class="declar">Copyright 2017 阿纳巴里国际影业</div>
				</div>
			</div>
	</header>
	<div class="body">
	    <div class="choice_role">
			 <section class="main">

				<div id="sb-container3" class="sb-container">
				<?php if(is_array($starInfo)): $i = 0; $__LIST__ = $starInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; $o =60;?>
					<?php $p +=$o+1;?>
					<div id="<?php echo ($p); ?>">
						<span class="sb-icon icon-cog"></span>
						<h4><a ><?php echo ($info["name"]); ?></a></h4>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
					<div class="last_title">
						<h4><span>araberri</span></h4>
						<h5><span> &hearts; </span><img src="/Public/wang/factory/img/WE_MOVIES.png" alt=""></h5>
					</div>
				</div><!-- sb-container -->
				<div class='page'><?php echo ($pages); ?></div>
			</section>
			<div class="star_content" id="star_content3">
				<?php if(is_array($starInfo)): $i = 0; $__LIST__ = $starInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; $x =60;?>
					<?php $z +=$x+1;?>
				<div class="<?php echo ($z); ?>">
					<div class="toupiao1"><p class="toupiao">已有<span><?php echo ($info["vote_number"]); ?></span>人投票</p></div>
					<div class="role_img"><img src="<?php echo ($info["image_url"]); ?>" alt=""></div>
					<div class="name">
						<p><?php echo ($info["name"]); ?></p>
					</div>
					<div class="works">
						<p>申请参演作品： <span><?php echo ($info["project_name"]); ?></span></p>
						<p>申请参演角色：<span><?php echo ($info["role_name"]); ?></span></p>
					</div>
					<div class='myself'>
						<p>身高：<?php echo ($info["height"]); ?>CM</p>
						<p>出身年月：<?php echo ($info["birthday"]); ?></p>
						<p>自我评价：<?php echo ($info["skill"]); ?></p>
						<p>我的特长：<?php echo ($info["expirence"]); ?></p>
					</div>
					<div style="margin-top: 15px;" class="vote_btn">投票</div>
					<div class='warn' style="display: none;" ><p>投票需要消耗1个阿纳豆</p><input _id="<?php echo ($info['id']); ?>" _type="4" name="sure" type="button" value="确定"><input name="cancel" type="button" value="取消">	 </div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
				
			</div>
		</div>
		<div class="nice_actor" style="display: none;">
			 <section class="main">

				<div id="sb-container" class="sb-container">
				<?php if(is_array($performerInfos)): $i = 0; $__LIST__ = $performerInfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; $i =1;?>
					<?php $j +=$i+1;?>
					<div id="<?php echo ($j); ?>">
						<span class="sb-icon icon-cog"></span>
						<h4><a ><?php echo ($info["name"]); ?></a></h4>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
					<div class="last_title">
						<h4><span>araberri</span></h4>
						<h5><span> &hearts; </span><img src="/Public/wang/factory/img/WE_MOVIES.png" alt=""></h5>
					</div>
					
				</div><!-- sb-container -->

			</section>
			<div class="star_content" id="star_content">
				<?php if(is_array($performerInfos)): $i = 0; $__LIST__ = $performerInfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; $m =1;?>
					<?php $n +=$m+1;?>
				<div class="<?php echo ($n); ?>">
					<div class="toupiao1"><p class="toupiao"><span><?php echo ($info["fans_number"]); ?></span>粉丝</p></div>
					<div class="role_img"><img src="<?php echo ($info["image_url"]); ?>" alt=""></div>
					<div class="name">
						<p><?php echo ($info["name"]); ?></p>
						<span><?php echo ($info["type"]); ?></span>
					</div>
					<div class="works">
						<p>代表作品</p>
						<span><?php echo ($info["works"]); ?></span>
					</div>
					<div class="vote_btn">投票</div>
					<div class='warn' style="display: none;" ><p>投票需要消耗1个阿纳豆</p><input _id="<?php echo ($info['id']); ?>" _type="1" name="sure" type="button" value="确定"><input name="cancel" type="button" value="取消">	 </div>

				</div><?php endforeach; endif; else: echo "" ;endif; ?>
				
			</div>
		</div>
		<div class="nice_director" style="display: none;" >
			 <section class="main">
			
				<div id="sb-container1" class="sb-container">
				<?php if(is_array($directorInfos)): $i = 0; $__LIST__ = $directorInfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; $x =15;?>
					<?php $y +=$x+1;?>
					<div id="<?php echo ($y); ?>">
						<span class="sb-icon icon-cog"></span>
						<h4><a ><?php echo ($info["name"]); ?></a></h4>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
					<div class="last_title">
						<h4><span>araberri</span></h4>
						<h5><span> &hearts; </span><img src="/Public/wang/factory/img/WE_MOVIES.png" alt=""></h5>
					</div>
					
				</div><!-- sb-container -->

			</section>
			<div class="star_content" id="star_content1">
				<?php if(is_array($directorInfos)): $i = 0; $__LIST__ = $directorInfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; $h =15;?>
					<?php $k +=$h+1;?>
				<div class="<?php echo ($k); ?>">
					<div class="toupiao1"><p class="toupiao"><span>13546</span>粉丝</p></div>
					<div class="role_img"><img src="<?php echo ($info["image_url"]); ?>" alt=""></div>
					<div class="name">
						<p><?php echo ($info["name"]); ?></p>
						<span><?php echo ($info["address"]); ?></span>
					</div>
					<div class="works">
						<p>代表作品</p>
						<span><?php echo ($info["intro"]); ?></span>
					</div>
					<div class="vote_btn">投票</div>
					<div class='warn' style="display: none;" ><p>投票需要消耗1个阿纳豆</p><input _id="<?php echo ($info['id']); ?>" _type="2" name="sure" type="button" value="确定"><input name="cancel" type="button" value="取消">	 </div>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
				
			</div>
		</div> 
		<div class="nice_work" style="display: none;">
			 <section class="main">
			
				<div id="sb-container2" class="sb-container">
					<?php if(is_array($worksInfos)): $i = 0; $__LIST__ = $worksInfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; $b =30;?>
						<?php $a +=$b+1;?>
					<div id="<?php echo ($a); ?>">
						<span class="sb-icon icon-cog"></span>
						<h4><a ><?php echo ($info["name"]); ?></a></h4>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
					<div class="last_title">
						<h4><span>araberri</span></h4>
						<h5><span> &hearts; </span><img src="/Public/wang/factory/img/WE_MOVIES.png" alt=""></h5>
					</div>

				</div><!-- sb-container -->

			</section>
			<div class="star_content" id="star_content2">
				<?php if(is_array($worksInfos)): $i = 0; $__LIST__ = $worksInfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; $c =30;?>
					<?php $d +=$c+1;?>
				<div class="<?php echo ($d); ?>">
					<div class="toupiao1"><p class="toupiao"><span><?php echo ($info["fans_number"]); ?></span>粉丝</p></div>
					<div class="role_img"><img src="<?php echo ($info["img_url"]); ?>" alt=""></div>
					<div class="name">
						<p><?php echo ($info["name"]); ?></p>
						<span><?php echo ($info["type"]); ?></span>
					</div>
					<div class="works">
						<p>故事梗概</p>
						<span><?php echo ($info["intro"]); ?></span>
					</div>
					<div class="vote_btn">投票</div>
					<div class='warn' style="display: none;" ><p>投票需要消耗1个阿纳豆</p><input name="sure" type="button" _id="<?php echo ($info['id']); ?>" _type="3" value="确定"><input name="cancel" type="button" value="取消">	 </div>

				</div><?php endforeach; endif; else: echo "" ;endif; ?>
				
			</div>
		</div>  
			<div class="classify">
				<p class="choice">评选角色</p>
				<p >优秀演员</p>
				<p>优秀导演</p>
				<p>优秀作品</p>
			</div>
	</div>
	    <script src='/Public/wang/common_js/jquery-1.12.4.min.js'></script>
		<script src='/Public/wang/common_js/common.js'></script>
		<script src='/Public/wang/factory/modernizr.custom.79639.js'></script>
		<script src='/Public/wang/factory/jquery.swatchbook.js'></script>
		<script src='/Public/wang/factory/star_factory.js'></script>
	<!--layer.js-->
	    <script src="/Public/layer/layer.js"></script>
		<script>	
			$(function() {
			
				$( '#sb-container3' ).swatchbook( {
					openAt : 0
				} );
			
			});
			$('.vote_btn').click(function(){
				//console.log(1)
				$(this).next().show();
			})
			$('.warn>input[name=cancel]').click(function(){
				$(this).parent().hide();
			})

			$(".warn>input[name=sure]").on('click',function(){
				var _id = $(this).attr('_id');
				var _type = $(this).attr('_type');
				var _data = {
					id : _id,
					type : _type
				};
				$.post("<?php echo U('home/factory/vote');?>",_data,function (data) {
					if (data.status == 0) {
						layer.confirm('您还没有登录', {
							btn: ['登录','取消'] //按钮
						}, function(){
							window.location.href = "<?php echo U('Home/Login/index');?>"
						}, function(){
						});
					} else {
						layer.msg(data.msg,{
							time:2
						},function(){
							location.reload();
						});
						$('.vote_btn').next().hide();
					}
				});
			})

		</script>
</body>
</html>