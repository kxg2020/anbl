<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/css/style.css" rel="stylesheet">
<link href="/Public/css/style-responsive.css" rel="stylesheet">

    <style>
        .loadfile {
            display: block;
            width: 100px;
            height: 100px;
            border: 1px dashed silver;
            cursor: pointer;
            color: #838383;
            font-size: 44px;
            line-height: calc(100px - 9px);
            text-align: center;
        }
        .imgInput {
            float: left;
            margin-right: 20px;
            border: 1px dashed silver;
        }

        .imgInput:hover {
            cursor: pointer;
            border: 3px dashed silver;
        }
    </style>

<body style="background-color: white">
<div class="panel-body">
    <form class="form-horizontal adminex-form" method="post" action="<?php echo U('admin/pageConfig/save');?>" id="form">
        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">充值账号</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="<?php echo ($detail["username"]); ?>" name="name">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">充值金额</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="<?php echo ($detail["money"]); ?>" name="remoney">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">充值时间</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="<?php echo date('Y-m-d',$detail['create_time']);?>" name="fans_number">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">订单单号</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="<?php echo ($detail['order_number']); ?>" name="vote_number">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label">交易凭证</label>
            <div class="col-sm-10">
                <img src="<?php echo ($detail['image_url']); ?>" id="img_url" style="height: auto;width: 800px">
            </div>
        </div>
        <?php if($detail['image_url'] != '' ): ?><div class="form-group">
                <div class="col-sm-10" style="float: right;">
                    <input type="hidden" value="<?php echo ($detail["id"]); ?>" name="member">
                    <?php if($detail['is_pass'] == 0): ?><input type="submit" class="btn btn-success" value="充值" id="save">

                        <?php else: ?>
                        <input type="button" class="btn btn-success" value="已审核" disabled><?php endif; ?>
                </div>
            </div><?php endif; ?>
    </form>
</div>

    <script src="/Public/js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="/Public/layer/layer.js" type="text/javascript"></script>
    <script src="/Public/code/js/jquery.html5upload.js"></script>
    <script>
        $(function(){
            $('#save').click(function(){
                var id = $('input[name = member]').val();
                var url = location.protocol +'//'+ window.location.host+'/admin/Order/pass';
                $.ajax({
                    'type':'post',
                    'dataType':'json',
                    'url':url,
                    'data':{
                        'id':id,
                        'money':$('input[name = remoney]').val()
                    },
                    success:function(result){
                           if(result){
                               var index = parent.layer.getFrameIndex(window.name); //获取当前窗体索引
                               parent.layer.close(index); //执行关闭
                           }

                    }
                });
            });

        });
    </script>

</body>