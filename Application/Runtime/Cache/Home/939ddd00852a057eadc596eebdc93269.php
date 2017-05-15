<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/wang/common_css/reset.css">
	<link rel="stylesheet" href="/Public/wang/company/company.css">
	<title>关于我们</title>
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
	<div class="about_content">
		<div class='body'>
			<div class="box1">
				<i></i>
				<i></i>
				<div class="box1_left">
					<p>中文名：阿纳巴里</p>
					<p>英文名：Arne Barry</p>
					<p>公司地址：美国加尼福尼亚州</p>
					<p>代办点：（待定）</p>
					<p>运营范围：影视文化产业，艺术金融投资</p>
					<p>主要合作企业：美国运通公司（AXP）、黑鹰网络控股（HAWK）、费埃哲公司（FICO）、派拉蒙影业、环球影视。</p>
				</div>
				<div class="box1_right">
					<img src="/Public/wang/company/img/img01.png" alt="">
				</div>
			</div>
			<div class="box2">
			 <i></i>
				<div class="box2_left">
					<img src="/Public/wang/company/img/img02.png" alt="">
				</div>
				<div class="box2_right">
					<p><b>阿</b>纳巴里影业投资公司【英文AL】简称【阿纳巴里影业】，以艺术金融投资原创加深文化生态附加值为核心产业发展，结合资本投资运营塑造文化产业环态经济平台，并融合国内外资深艺术领域资源，全面的开发主题文化旅游、电影小镇、影视基地、生态娱乐园及8D动态剧场，以好莱坞环球电影娱乐文化为导向，凸显文化产业新格局全面打开原创生态经济产业链条的重要的核心目标。</p>
					<p>阿纳巴里影业投资公司结合国内外知名电影制作机构，推崇以文化引导经济，以创新研发塑造产业品牌，以【艺术+金融+互联网业态+新模式】为战略思路，融入大投行经济形成纽带，实现‘’以文化金融虚拟数据结合产业形成环态经济发展。以潮流时尚文化引领业态升级，逐步凸显全球文化经济 环态的强大影响力。阿纳巴里影业集聚全球精英，以诚信务实、创新高效的团队精神进行专注品牌产业化运营，携手共赢未来，铸造【AL】环态影业原创商业品牌。</p>
				</div>
			</div>
			<div class="box3">
				<div class="box3_left">
					<div class="box_border"></div>
					<div class='div'>
						<h3>阿纳巴里影业思维创作核心元素</h3>
					    <p>创作元素来源于DI的创造力，什么是DI？DI®是英文“DestinationImagiNation®”的缩写，原意是“目的地想象”，寓意无限的想像力和创造力。DI协会是世界上最大的、历史最悠久的关于创意和团队合作以及创意问题解决能力的机构，成立于1983年，总部设在美国的新泽西州的樱桃山，在美国的大多数州都有其分部，并在全球的其它国家开设了DI国家级区域组委，以此形成最有效的新思维科普影视创作，有效的融合科技+影视的创作思路，开发成年人及青少年的智力及建构人性文化全世界最好的教材。</p>
					    <p>阿纳巴里影业CEO结合美国科普DI元素研发，融入金融资本实力，形成了艺术金融创作的核心源泉，聚合全球精英人才分为【思路创作】【技术开发】【金融运营】【电影制片】【投资分析】【影业发行】等元素，多次访问各个国家优秀的电影制作人，并达成友好的战略合作意向，一致认为中国将是未来电影最大的市场，目前国内影业还处于传统的运营和资本在协商阶段，并没有形成影业生态链，影业金融超市移动体验店更是荒芜空白，科普教育还在迟缓的来到，对于文化产业创造也是复制捏造，为了完成票房往往导演经常和财务在做交流，这是中国文化产业目前的困局。</p>
					    <p>阿纳巴里影业CEO创新突破，致力于统一共赢，以系统研发艺术金融管道，提升创作价值，结合国内知名电影机构，联合制片运营，形成战略常态经济涌动国内市场，推翻传统电影模式，使家户选投，人人乐选，把电影产业结合生活化情操培养，共享娱乐精神，共留人生记忆。有了【AL】，生活将会携手快乐，有【AL】财富将伴随身后，一起用心感受【AL】全球影业繁荣。</p> 
					</div>	
				</div>
				<div class="box3_right">
					<div id="div1"><span>+</span><b>前身背景</b></div>
					<div class="div1" style="display: none;">
					<h3>前身背景</h3>
					<p>阿纳巴里（Arne Barry），总部坐落于美国加利福利亚州（State of California）圣克拉拉（Santa Clara）的首府圣何塞（San Jose），前身为一家定位小众，专项提供私人快捷金融服务的金融公司。主要服务对象为北美、南亚、欧洲上层精英人士，主要业务分布于私人财产管理、投资咨询、证券经济、金融律师、创业资本投资等项目，下设零售银行、保险和投资、业务银行、企业银行和金库等部门。</p>
					<p>阿纳巴里通过将大数据云计算等新兴前端技术服务于金融，使得财务顾问能够通过桌面和移动设备，分析并管理客户的所有资产，包括对冲基金和私募股权，从而有效改善客户服务便捷程度，提升客户数据私密性与安全性。</p>
					<p>阿纳巴里自成立以来，拥有五年以上资深行业资历，积累了大量优质人脉资源，始终将目标群体精准定位于小众城市上层精英，秉承低调、务实、高效的企业作风，为广大客户提供全方位、个性化的融资与信用增值服务。</p>
					</div>
					<div id="div2"><span>+</span><b>转型原因</b></div>
					<div class="div2" style="display: none;">
					<h3>转型原因</h3>
					<p>数据显示，近年来，艺术投资开始超越房市、股市，跻身成为投资领域的新贵，更因其艺术附加值不可估量，且以人脉优势为导向的独特属性，同金融投资企业合作具有天然优势。并且通过影视DI可以有效传播开发附加产业，有效的结合环球经济产业化发展，因此，阿纳巴里凭借本身雄厚的资本实力与优质客户群体优势，在投资领域开始整合相关资源，优化组织结构，进行投资转型。</p>
					<p>转型后的阿纳巴里影视投资公司，致力于塑造融合市场产业链条开发，以电影制作基地、文化创业园、旅游文化地产开发、8D动态剧场、环球好莱坞教育基地、动漫生态娱乐园、动漫机器人生活服务系统的实体战略研发管理，结合金融资本开启包装上市挂牌，以上市融资为渠道，加快企业发展速度的同时，开启国际文化交流中心，对接国内外旅游文化市场，以多元素并列的核心以电影开渠，资本填充，文化产业原创研发推进、地区资本相融，全方位在国内外塑造大文化品牌实战业态，带动资本占领美国艺术金融盘，以虚拟数据经济拉动内需，推进好莱坞市场战略形成全球艺术金融新型文化商业品牌企业。</p>
					<p>阿纳巴里影业成功转型核心以【艺术金融】的原创品牌塑造融合市场产业链条开发，以大金融、大资管、大投行为企业发展战略目标，以文化产业背景推进社会圈层，加深文化产业政策指导思想背景，全方位凸显环球附加值业态的根本，塑造【创新+环态+新模式+文化漂移】=【阿纳巴里】代表着时代赋予了新生代的经济高潮，同时以潮流时尚文化引领业态升级，逐步凸显全球文化经济 环态的强大影响力。</p>
					<p>阿纳巴里影业投资公司，前身为美国阿纳巴里金融有限公司，于2010年成立，主要经营私人快捷金融服务等业务，主要服务对象为北美、南亚、欧洲上层精英人士。在业界积累下良好的信用口碑和社会人脉。</p>
					<p>2016年初，公司首次接触艺术金融与影视文化投资行业，发现中国影视电影与文化艺术品有着不可估量的投资价值和发展空间，加之高端客户人脉资源的推动，公司决定成立影视投资有限公司。并开创了【艺术+金融+互联网+业态】的创新运营模式，从而更好地实现“以金融发展艺术，以艺术反哺金融”的文化艺术投资创新理念。</p>
					</div>
				</div>
			</div>
			<div class="box4">
				
			</div>
			
		</div>	    
	</div>
	<div class="footer">
		Copyright 2017 阿纳巴里国际影业
			</div>
	<script src='/Public/wang/common_js/jquery-1.12.4.min.js'></script>
	<script src='/Public/wang/common_js/common.js'></script>
	<script src='/Public/wang/company/company.js'></script>
</body>
</html>