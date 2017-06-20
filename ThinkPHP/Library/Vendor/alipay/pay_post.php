<?php

header("Content-type: text/html; charset=utf-8");

$type = isset($_POST['paytype']) ? $_POST['paytype'] : 'alipay';

if($type == 'alipay'){
    $service = 'create_direct_pay_by_user';//pc
}else{
    $service = 'alipay.wap.create.direct.pay.by.user';//手机站
}

$alipay_config = array(

    // 收款账号邮箱
    'email' => 'yangtao@ecshy.com',

    // 加密key，开通支付宝账户后给予
    'key' => 'wcgf9kam5w2iwsnmk15w26stvr8ya24h',

    //账户后给予
    'partner' => '2088221781617250',

    //收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
    'seller_id' => '2088221781617250',

    //签名方式
    'sign_type' => strtoupper('MD5'),

    //字符编码格式 目前支持utf-8
    'input_charset' => strtolower('utf-8'),

    // 产品类型，无需修改
    'service' => $service,

    // 支付类型 ，无需修改
    'payment_type' => '1',

    'transport'=>'http',
);

$out_trade_no = date('YmdHis') . rand(1000, 9999);
$money = $_POST['money']; //支付金额
$subject = "订单" . $out_trade_no;
$body = "订单" . $out_trade_no;

$url_current = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];//当前地址
$notify_url = dirname($url_current)."/notify.php"; //通知地址
//echo $notify_url;exit;
$return_url = "https://www.baidu.com"; //支付成功跳转地址


require 'alipay/alipay.config.php';
require 'alipay/lib/alipay_submit.class.php';


//构造要请求的参数数组，无需改动
$parameter = array(
    "service" => $alipay_config['service'],
    "partner" => $alipay_config['partner'],
    "seller_id" => $alipay_config['seller_id'],
    "payment_type" => $alipay_config['payment_type'],
    "notify_url" => $notify_url,
    "return_url" => $return_url,
    "_input_charset" => $alipay_config['input_charset'],
    "out_trade_no" => $out_trade_no,
    "subject" => $subject,
    "total_fee" => $money,
    "show_url" => $return_url,
    //"app_pay" => "Y",//启用此参数能唤起钱包APP支付宝
    "body" => $body,
        //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.2Z6TSk&treeId=60&articleId=103693&docType=1
        //如"参数名"    => "参数值"   注：上一个参数末尾需要“,”逗号。
);

    //建立请求
    $alipaySubmit = new \alipay_submit($alipay_config);



if ($type == 'alipay') {

    $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");

    echo $html_text;
}elseif ($type == 'alipay_wap') {

    $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");

    echo $html_text;
}
