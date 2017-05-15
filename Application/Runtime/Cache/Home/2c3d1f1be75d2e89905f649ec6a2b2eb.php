<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/wang/common_css/reset.css">
	<link rel="stylesheet" href="/Public/wang/common_css/home.css">
	<link rel="stylesheet" type="text/css" href="/Public/wang/common_css/jq22.css">
	<script type="text/javascript" src="/Public/wang/common_js/slider.js"></script>
	<style>
		.bg{
			width: 100%;
			height: 100%;
			position: absolute;
			top: 0;
			left: 0;
			background: rgba(0,0,0,.6);
		}
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
		<div id="center">
			<div id="slider">
				<?php if(is_array($lunbos)): $i = 0; $__LIST__ = $lunbos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lunbo): $mod = ($i % 2 );++$i;?><!--<?php $i =0;?>
					<?php $j +=$i+1;?>-->
				<div class="slide" style="border-left: none; left: 0px;"><a href="<?php echo U('home/index/detail',['id'=>$lunbo['id']]);?>"><img class="diapo" border="0" src="<?php echo ($lunbo["image_url"]); ?>" style="opacity: 0.7; visibility: visible;"></a>
				<div class="backgroundText" style="top: 402px;"></div><div class="text" style="top: 402px;">百叶窗</div>
				<div class="bg">
					<a href="<?php echo U('home/index/detail',['id'=>$lunbo['id']]);?>" class="content">
						<div class="dragon">
							<div class="top"><img src="/Public/wang/home_img/dragon00_03.png" alt=""></div>
						</div>
						<div class="complate_point"><?php echo sprintf("%.2f",(($lunbo['money'])/$lunbo['target_amount']*100));?>%</div>
						<div class="rank">
							<!--0<?php echo ($j); ?>-->
						</div>
						<p class="move_title"><?php echo ($lunbo["name"]); ?></p>
						<p>导演：<?php echo ($lunbo["director"]); ?></p>
						<p>主演：<?php echo ($lunbo["star"]); ?></p>
						<p>出品单位：<?php echo ($lunbo["company"]); ?></p>
						<p>剩余时间：<span><?php echo dataNum(time(),$lunbo['end_time']);?></span> 天</p>
						<p>评星 <?php $__FOR_START_444__=0;$__FOR_END_444__=$lunbo['star_num'];for($i=$__FOR_START_444__;$i < $__FOR_END_444__;$i+=1){ ?><i class="star"></i><?php } ?></p>
						<p>阿纳豆：<span><?php echo floor($lunbo['target_amount']);?></span></p>
					</a>

				</div>

				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			<div class="hot_news"><i class="suona"></i>最新消息：
				<div class="news_carousel">
					<div>
					<?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$new): $mod = ($i % 2 );++$i;?><a href="<?php echo U('home/index/news',['id'=>$new['id']]);?>"><?php echo ($new["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>

					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="body">	
	<div class="move_list">
		<p class="choice">星级</p>
		<p>院线</p>
		<p>网路IP</p>
	</div>	
		<div class="main movie_star">
			<?php if(is_array($projectInfo)): $i = 0; $__LIST__ = $projectInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><section class="page1 tps-section tps-inview">
        <div class="page_container">
          <h1>
          		<a href="<?php echo U('home/index/detail',['id'=>$info['id']]);?>">
					                    <img src="<?php echo ($info['image_url']); ?>" style="position:absolute; top: 0;left: 0; width: 100%;height: 100%" alt="">
          								<div class="move_content content">
          									<p><?php echo ($info['name']); ?></p>
          									<p>导演：<?php echo ($info['director']); ?></p>
											<p>主演：<?php echo ($info['star']); ?></p>
          									<p>出品单位：<?php echo ($info["company"]); ?></p>
          									<p>评星 <?php $__FOR_START_13637__=0;$__FOR_END_13637__=$info['star_num'];for($i=$__FOR_START_13637__;$i < $__FOR_END_13637__;$i+=1){ ?><i class="star"></i><?php } ?></p>
          									<p>阿纳豆：<span><?php echo floor($info['target_amount']);?></span></p>
          								</div>
          		</a>
          	</h1>
        </div>
      </section><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
		<div class="main cname" style="display:none;">
			<?php if(is_array($projectInfo)): $i = 0; $__LIST__ = $projectInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; if($info['type_id'] == 2): ?><section class="page1 tps-section tps-inview">
				<div class="page_container">
					<h1>
						<a href="<?php echo U('home/index/detail',['id'=>$info['id']]);?>">
							<img src="<?php echo ($info['image_url']); ?>" style="position:absolute; top: 0;left: 0; width: 100%;height: 100%" alt="">
							<div class="move_content content">
								<p><?php echo ($info['name']); ?></p>
								<p>导演：<?php echo ($info['director']); ?></p>
								<p>主演：<?php echo ($info['star']); ?></p>
								<p>出品单位：<?php echo ($info["company"]); ?></p>
								<p>评星 <?php $__FOR_START_25754__=0;$__FOR_END_25754__=$info['star_num'];for($i=$__FOR_START_25754__;$i < $__FOR_END_25754__;$i+=1){ ?><i class="star"></i><?php } ?></p>
								<p>阿纳豆：<span><?php echo floor($info['target_amount']);?></span></p>
							</div>
						</a>
					</h1>
				</div>
			</section><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="main webip" style="display: none">
			<?php if(is_array($projectInfo)): $i = 0; $__LIST__ = $projectInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i; if($info['type_id'] == 3): ?><section class="page1 tps-section tps-inview">
				<div class="page_container">
					<h1>
						<a href="<?php echo U('home/index/detail',['id'=>$info['id']]);?>">
							<img src="<?php echo ($info['image_url']); ?>" style="position:absolute; top: 0;left: 0; width: 100%;height: 100%" alt="">
							<div class="move_content content">
								<p><?php echo ($info['name']); ?></p>
								<p>导演：<?php echo ($info['director']); ?></p>
								<p>主演：<?php echo ($info['star']); ?></p>
								<p>出品单位：<?php echo ($info["company"]); ?></p>
								<p>评星 <?php $__FOR_START_29131__=0;$__FOR_END_29131__=$info['star_num'];for($i=$__FOR_START_29131__;$i < $__FOR_END_29131__;$i+=1){ ?><i class="star"></i><?php } ?></p>
								<p>阿纳豆：<span><?php echo floor($info['target_amount']);?></span></p>
							</div>
						</a>
					</h1>
				</div>
			</section><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
	<footer>
		Copyright 2017 阿纳巴里国际影业
	</footer>
	<script src='/Public/wang/common_js/jquery-1.12.4.min.js'></script>
	<script type="text/javascript" src="/Public/wang/common_js/jquery.tiltedpage-scroll.js"></script>
	<script src='/Public/wang/common_js/home.js'></script>
	<script src='/Public/wang/common_js/common.js'></script>
	<script type="text/javascript">
	/* ==== start script ==== */
	slider.init();


	function init(){
		$('#slider>div').eq(1).css({
			left:'20%'
		})
		$('#slider>div').eq(2).css({
			left:'38.5%'
		})
		$('#slider>div:nth-child(1)>a>img').css({
			opacity:1
		})
		$('#slider>div:nth-child(2)>a>img').css({
			opacity:1
		})

	}

	init();

	var timer;
	$('#center').on('mouseleave',function(){
	 timer = setTimeout('init()',2000)
		
	})
	$('#center').on('mouseenter',function(){
		clearTimeout(timer)		
	})

	  $(document).ready(function(){
	      $(".main").tiltedpage_scroll({
	        angle: 20
	      });
		});
	</script>
</body>
</html>