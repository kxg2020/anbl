<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <title>PHP原生支付宝在线支付源码</title>
        <meta name="keywords" content="PHP支付宝DEMO,PHP支付宝wap演示" /> 
        <meta name="description" content="PHP原生开发的支付宝电脑pc演示源码加支付宝wap演示源码，PHP支付宝pc+wap在线支付源码下载,PHP支付成功后正确返回支付信息" /> 
    </head> 
    <body> 

        <form action="pay_post.php" method="post" id="form_pay" style="margin:150px 0 0 400px">

            <input type="text" name="money" id="money" value="0.01" style="width:150px" class="form_input" autocomplete="off"/> 元
            <label><input type="radio" name="paytype" value="alipay" checked /> 支付宝pc</label>
            <label><input type="radio" name="paytype" value="alipay_wap"  /> 支付宝wap</label>
           
            <button class="btn" style="height: 36px;line-height: 36px;font-size:16px;width:140px" type="submit"  id='btn_submit'>提 交</button>
        </form>
    </body>
</html>
