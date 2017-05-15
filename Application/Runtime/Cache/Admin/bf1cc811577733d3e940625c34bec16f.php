<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">
  <title>阿纳巴里</title>
    

    
  <link href="/Public/css/bootstrap.min.css" rel="stylesheet">
  <!--common-->
  <link href="/Public/css/style.css" rel="stylesheet">
  <link href="/Public/css/style-responsive.css" rel="stylesheet">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="/Public/js/html5shiv.js"></script>
  <script src="/Public/js/respond.min.js"></script>
  <![endif]-->
    <style>
        .li_choice{         
            background: #2a323f;
            }
           .custom-nav .sub-menu-list  .li_choice>a{
                   color: #65cea7;
             }
    </style>
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <a href="<?php echo U('admin/Index/index');?>"><img src="/Public/images/logo.png" alt=""></a>
        </div>

        <div class="logo-icon text-center">
            <a href="index.html"><img src="/Public/images/logo_icon.png" alt=""></a>
        </div>
        <!--logo and iconic logo end-->

        <div class="left-side-inner">

            <!-- visible to small devices only -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media logged-user">
                    <img alt="" src="/Public/images/images/photos/user-avatar.png" class="media-object">
                    <div class="media-body">
                        <h4><a href="#">John Doe</a></h4>
                        <span>"Hello There..."</span>
                    </div>
                </div>

                <h5 class="left-nav-title">Account Information</h5>
                <ul class="nav nav-pills nav-stacked custom-nav">
                  <li><a href="#"><i class="fa fa-user"></i> <span>个人中心</span></a></li>
                  <li><a href="#"><i class="fa fa-cog"></i> <span>设置</span></a></li>
                  <li><a href="#"><i class="fa fa-sign-out"></i> <span>退出登录</span></a></li>
                </ul>
            </div>

            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li class="active"><a href="<?php echo U('admin/Index/index');?>"><i class="fa fa-home"></i> <span>首页</span></a></li>
                <li class="menu-list"><a href=""><i class="fa fa-user"></i> <span>用户管理</span></a>
                    <ul class="sub-menu-list" id="0">
                        <li><a href="<?php echo U('admin/User/index?sh=0-0');?>">用户列表</a></li>
                        <li><a href="<?php echo U('admin/User/add?sh=0-1');?>">用户添加</a></li>
                    </ul>
                </li>
                <!--权限管理功能完整，需要时打开注释
                <li class="menu-list"><a href=""><i class="fa fa-user"></i> <span>权限管理</span></a>
                    <ul class="sub-menu-list" >
                        <li><a href="<?php echo U('admin/Permission/index?sh=0-0');?>">权限列表</a></li>
                        <li><a href="<?php echo U('admin/Permission/add?sh=0-1');?>">权限添加</a></li>
                    </ul>
                </li>
                -->
                <li class="menu-list"><a href=""><i class="fa fa-user"></i> <span>会员管理</span></a>
                    <ul class="sub-menu-list" id="1">
                        <li><a href="<?php echo U('admin/Member/select?sh=1-0');?>">会员列表</a></li>
                        <li><a href="<?php echo U('admin/Member/addMember?sh=1-1');?>">会员添加</a></li>
                        <li><a href="<?php echo U('admin/Member/getProfit?sh=1-2');?>">会员收益</a></li>
                        <li><a href="<?php echo U('admin/Member/integral?sh=1-3');?>">升级规则</a></li>
                        <li><a href="<?php echo U('admin/Member/question?sh=1-4');?>">会员问答</a></li>
                        <li><a href="<?php echo U('admin/Member/comment?sh=1-5');?>">会员评论</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href=""><i class="fa fa-folder-o"></i> <span>电影管理</span></a>
                    <ul class="sub-menu-list" id="2">
                        <li><a href="<?php echo U('admin/Project/index?sh=2-0');?>">电影列表</a></li>
                        <li><a href="<?php echo U('admin/Project/add?sh=2-1');?>">电影添加</a></li>
                        <li><a href="<?php echo U('admin/ProjectCategory/index?sh=2-2');?>">电影分类</a></li>
                        <li><a href="<?php echo U('admin/Dynamic/index?sh=2-3');?>">电影动态</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href=""><i class="fa fa-gear"></i> <span>明星管理</span></a>
                    <ul class="sub-menu-list" id="3">
                        <li><a href="<?php echo U('admin/PageConfig/select?sh=3-0');?>">优秀作品</a></li>

                       
                        <li><a href="<?php echo U('admin/Works/index?sh=3-1');?>">优秀演员</a></li>

                        <li><a href="<?php echo U('admin/PageConfig/director?sh=3-2');?>">优秀导演</a></li>
                        

                    </ul>
                </li>
                <li class="menu-list"><a href=""><i class="fa fa-building-o"></i> <span>订单管理</span></a>
                    <ul class="sub-menu-list" id="4">

                        <li><a href="<?php echo U('admin/order/orderRecharge?sh=4-0');?>">充值订单</a></li>
                        <li><a href="<?php echo U('admin/order/cash?sh=4-1');?>">提现订单</a></li>
                        <!--<li><a href="<?php echo U('admin/order/downloadOrder');?>">下载订单</a></li>-->
                        <li><a href="<?php echo U('admin/order/supportOrder?sh=4-2');?>">支持订单</a></li>


                    </ul>
                </li>

                <li class="menu-list"><a href=""><i class="fa fa-envelope"></i> <span>数据管理</span></a>
                    <ul class="sub-menu-list" id="5">
                        <li><a href="<?php echo U('admin/Count/memberCount?sh=5-0');?>">会员数据</a></li>
                        <li><a href="<?php echo U('admin/Count/projectCount?sh=5-1');?>">电影数据</a></li>
                        <li><a href="<?php echo U('admin/Count/payCount?sh=5-2');?>">销售数据</a></li>
                        <li><a href="<?php echo U('admin/Count/financeCount?sh=5-3');?>">财务数据</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href=""><i class="fa fa-envelope"></i> <span>明星招募</span></a>
                    <ul class="sub-menu-list" id="6">
                        <li><a href="<?php echo U('admin/Role/add?sh=6-0');?>">添加角色</a></li>
                        <li><a href="<?php echo U('admin/Role/index?sh=6-1');?>">招募列表</a></li>
                        <li><a href="<?php echo U('admin/Role/film?sh=6-2');?>">添加招募</a></li>
                        <li><a href="<?php echo U('admin/Member/memberStar?sh=6-3');?>">申请列表</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href=""><i class="fa fa-gears"></i> <span>后台系统</span></a>
                    <ul class="sub-menu-list" id="7">
                        <li><a href="<?php echo U('admin/System/index?sh=7-0');?>">网站基本设置</a></li>
                        <li><a href="<?php echo U('admin/System/cooperation?sh=7-1');?>">合作机构设置</a></li>
                    </ul>
                </li>

                <li class="menu-list"><a href=""><i class="fa fa-rss"></i> <span>信息发布</span></a>
                    <ul class="sub-menu-list" id="8">
                        <li><a href="<?php echo U('admin/Category/index?sh=8-0');?>">分类管理</a></li>
                        <li><a href="<?php echo U('admin/Article/index?sh=8-1');?>">信息列表</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href=""><i class="fa fa-gears"></i> <span>支付管理</span></a>
                    <ul class="sub-menu-list" id="9">
                        <li><a href="<?php echo U('admin/Pay/index?sh=9-0');?>">支付列表</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo U('admin/Login/logout');?>"><i class="fa fa-sign-in"></i> <span>退出</span></a></li>

            </ul>
            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->
    
    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-bars"></i></a>
            <!--toggle button end-->

            <!--search start-->
            <!--<form class="searchform" action="index.html" method="post">
                <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
            </form>-->
            <!--search end-->

            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu">
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <?php if(count($untreated_list) > 0): ?><span class="badge" id="transNum"><?php echo count($untreated_list)>=99?'99+':count($untreated_list);?></span><?php endif; ?>

                        </a>
                        <div class="dropdown-menu dropdown-menu-head pull-right">
                            <h5 class="title">未处理事务</h5>
                            <ul class="dropdown-list normal-list" id="untreatedList" style="overflow: auto;max-height: 265px;">
                                <?php if(count($untreated_list) > 0): if(is_array($untreated_list)): $i = 0; $__LIST__ = $untreated_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$untreated_info): $mod = ($i % 2 );++$i;?><li class="new">
                                            <a href="<?php echo ($untreated_info["url"]); ?>" title="点我立即处理">
                                                <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                                <span class="name">[<?php echo ($untreated_info["type"]); ?>]<?php echo ($untreated_info["content"]); ?></span>
                                                <em class="small"></em>
                                            </a>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>

                                    <?php else: ?>
                                    <li class="new">
                                        <a href="javascript:;">
                                            <span class="name">暂无事务</span>
                                        </a>
                                    </li><?php endif; ?>

                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo ($userInfo['image_url']); ?>" alt="" />
                            <?php echo ($userInfo['username']); ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <!--<li><a href="#"><i class="fa fa-user"></i>个人中心</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i></a></li>-->
                            <li><a href="<?php echo U('admin/login/logout');?>"><i class="fa fa-sign-out"></i> 退出</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->
        
    <div class="page-heading">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo U('admin/index/index');?>">后台首页</a>
            </li>
            <li class="active">
                <a href="<?php echo U('admin/user/index');?>">用户管理</a>
            </li>
            <li class="active"> 用户列表 </li>
        </ul>
    </div>
    <!-- page heading end-->

    <div class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        用户列表
                            <span class="tools pull-right">
                                <a href="<?php echo U('admin/user/add');?>" class="btn btn-success btn-link">新增用户</a>
                            </span>
                    </header>
                    <div class="panel-body">

                        <!--搜索开始-->
                        <form class="form-inline" action="<?php echo U('admin/user/index');?>" method="get">
                            <div class="form-group">
                                <label>用户姓名</label>
                                <input type="text" class="form-control" name="name" value="<?php echo I('get.name');?>" placeholder="请输入用户姓名">
                            </div>
                            <button type="submit" class="btn btn-primary">搜索</button>
                        </form>

                        <!--搜索结束-->
                        <hr/>
                        <div class="adv-table text-center">
                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                <tr>
                                    <th class="text-center">编号</th>
                                    <th class="text-center">用户名</th>
                                    <th class="text-center">用户头像</th>
                                    <th class="text-center">电话</th>
                                    <th class="text-center">加入时间</th>
                                    <th class="text-center">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(empty($userInfos)): ?><tr>
                                        <td colspan="9">暂无数据</td>
                                    </tr><?php endif; ?>
                                <?php if(is_array($userInfos)): $i = 0; $__LIST__ = $userInfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tag): $mod = ($i % 2 );++$i;?><tr class="gradeX">
                                    <td style="vertical-align: middle"><?php echo ($tag["id"]); ?></td>
                                    <td style="vertical-align: middle"><?php echo ($tag["username"]); ?></td>
                                    <td style="vertical-align: middle"><image src="<?php echo ($tag['image_url']); ?>" style="width: 50px;height: 50px"></image></td>
                                    <td style="vertical-align: middle"><?php echo ($tag["phone"]); ?></td>
                                    <td style="vertical-align: middle"><?php echo date('Y-m-d',$tag['create_time']);?></td>
                                    <td style="vertical-align: middle">
                                        <a href="<?php echo U('admin/user/edit', array('id' => $tag['id']));?>" class="btn btn-xs btn-success">编辑</a>
                                        <a data-href="<?php echo U('admin/user/remove', array('id' => $tag['id']));?>" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-xs deleteBtn">删除</a>
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                            <?php echo ($pages); ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">提示：Notice!</h4>
                </div>
                <div class="modal-body">
                    你确认要删除吗？
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <a href="" id="deleteTrue" class="btn btn-primary">确定</a>
                </div>
            </div>
        </div>
    </div>
    <script src="/Public/js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="/Public/layer/layer.js" type="text/javascript"></script>
    <script>
        $(function(){
            $('.deleteBtn').click(function(){
                var _link = $(this).attr('data-href');
                $('#deleteTrue').attr('href', _link);
            })


        });
    </script>

        <!--footer section start-->
        <footer>
            2017 &copy; AdminEx by ThemeBucket
        </footer>
        <!--footer section end-->
    </div>

    <!-- main content end-->
</section>
<!-- Placed js at the end of the document so the pages load faster -->
<script src="/Public/js/jquery-1.10.2.min.js"></script>
<script src="/Public/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="/Public/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>
<script src="/Public/js/modernizr.min.js"></script>
<script src="/Public/js/jquery.nicescroll.js"></script>

<!--Sparkline Chart-->
<script src="/Public/js/sparkline/jquery.sparkline.js"></script>
<script src="/Public/js/sparkline/sparkline-init.js"></script>

<!--icheck -->
<script src="/Public/js/iCheck/jquery.icheck.js"></script>
<script src="/Public/js/icheck-init.js"></script>

<!-- jQuery Flot Chart-->
<script src="/Public/js/flot-chart/jquery.flot.js"></script>
<script src="/Public/js/flot-chart/jquery.flot.tooltip.js"></script>
<script src="/Public/js/flot-chart/jquery.flot.resize.js"></script>

<!--common scripts for all pages-->
<script src="/Public/js/scripts.js"></script>









<script type="text/javascript">
    setInterval("getTrans()",10000);//1000为1秒钟
    function getTrans()
    {
        $.get('<?php echo U("admin/Common/getTrans");?>',function (data) {
            $('#untreatedList').html(data.content);
            if(data.num > 0){
                $('#transNum').removeClass('badge');
                $('#transNum').addClass('badge');
                if(data.num > 99){
                    data.num = '99+';
                }
                $('#transNum').text(data.num)
            }else{
                $('#transNum').removeClass('badge');

            }
        });
    }   

    var  url= window.location.href;
    var number = url.slice(url.indexOf('/sh/')+4,url.indexOf('/sh/')+7);
    var choiceArry=number.split('-');
   // console.log(choiceArry)
    if(number!='p'){
          $('.menu-list').eq(choiceArry[0]).addClass('nav-active')
          $('.menu-list').eq(choiceArry[0]).children('.sub-menu-list').children().eq(choiceArry[1]).addClass('li_choice')
    }
    

</script>
</body>
</html>