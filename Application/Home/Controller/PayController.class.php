<?php
namespace  Home\Controller;

use Think\Controller;

class PayController extends  Controller{

    public function _initialize(){
        //>> 引入类
        vendor('Alipay.lib.Corefunction');
        vendor('Alipay.lib.Md5function');
        vendor('Alipay.lib.Notify');
        vendor('Alipay.lib.Submit');

    }

    public function doPay(){

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
    }


    /**
     * 异步通知地址
     */
    public  function notifyUrl(){

        // 获取支付宝配置
        $alipay_config=C('alipay_config');
        // 计算得出通知验证结果
        $alipayNotify = new \AlipayNotify($alipay_config);
        // 验证是否是支付宝发出的消息
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {

            // 获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            // 商户订单号
            $out_trade_no   = $_POST['out_trade_no'];
            // 支付宝交易号
            $trade_no       = $_POST['trade_no'];
            // 交易状态
            $trade_status   = $_POST['trade_status'];
            // 交易金额
            $total_fee      = $_POST['total_fee'];
            // 通知校验ID。
            $notify_id      = $_POST['notify_id'];
            // 通知的发送时间。格式为yyyy-MM-dd HH:mm:ss
            $notify_time    = $_POST['notify_time'];
            // 买家支付宝帐号
            $buyer_email    = $_POST['buyer_email'];


            // 组合参数数组
            $parameter = array(
                // 商户订单编号
                "out_trade_no"  => $out_trade_no,
                // 支付宝交易号
                "trade_no"      => $trade_no,
                // 交易金额
                "total_fee"     => $total_fee,
                // 交易状态
                "trade_status"  => $trade_status,
                // 通知校验ID
                "notify_id"     => $notify_id,
                // 通知的发送时间
                "notify_time"   => $notify_time,
                // 买家支付宝帐号
                "buyer_email"   => $buyer_email,
            );

            // 收到TRADE_FINISHED,表示买家已经支付成功,订单完成(及时到账普通版返回的值,普通版不包含退款功能)
            if($_POST['trade_status'] == 'TRADE_FINISHED') {
                // 查找这个订单
                $orderData = D('Order')->where(array('order_no'=>$parameter['out_trade_no']))->find();
                if (empty($orderData)) {

                    exit;
                }

                // 订单是否已经支付过
                if($orderData['status'] != 0){

                    echo  "订单已经支付过了";
                }
                // 将订单支付状态置为已支付
                D('Order')->where(array('order_no'=>$parameter['out_trade_no']))->save(array('status'=>1));

                // 告诉支付宝验证成功(必须为'success')
                echo "success";


            }

            // 收到TRADE_SUCCESS,表示买家只是支付成功,订单完成(及时到账高级版返回的值,高级版包含退款功能)
            if ($_POST['trade_status'] == 'TRADE_SUCCESS') {

                // 查找这个订单
                $orderData = D('Order')->where(array('order_no'=>$parameter['out_trade_no']))->find();
                if (empty($orderData)) {

                     exit;
                 }

                 // 订单是否已经支付过
                if($orderData['status'] != 0){

                    echo  "订单已经支付过了";
                }
                // 将订单支付状态置为已支付但未收货状态(买家有可能需要退款),
                D('Order')->where(array('order_no'=>$parameter['out_trade_no']))->save(array('status'=>2));

                // 告诉支付宝验证成功(必须为'success')
                echo "success";

            }

        }else{

            //告诉支付宝验证失败(必须为'fail')
            echo "fail";
        }
    }

    /**
     * 同步跳转地址
     */
    public function returnUrl(){

        // 获取支付宝配置
        $alipay_config=C('alipay_config');

        // 实例化支付宝
        $alipayNotify = new \AlipayNotify($alipay_config);

        // 判断是否是支付宝返回的参数
        $verify_result = $alipayNotify->verifyReturn();

        if($verify_result) {

            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            // 商户订单号
            $out_trade_no   = $_GET['out_trade_no'];
            // 支付宝交易号
            $trade_no       = $_GET['trade_no'];
            // 交易状态
            $trade_status   = $_GET['trade_status'];
            // 交易金额
            $total_fee      = $_GET['total_fee'];
            // 通知校验ID
            $notify_id      = $_GET['notify_id'];
            // 通知的发送时间
            $notify_time    = $_GET['notify_time'];
            // 买家支付宝帐号
            $buyer_email    = $_GET['buyer_email'];

            $parameter = array(
                //商户订单编号
                "out_trade_no"  => $out_trade_no,
                //支付宝交易号
                "trade_no"      => $trade_no,
                //交易金额
                "total_fee"     => $total_fee,
                //交易状态
                "trade_status"  => $trade_status,
                //通知校验ID
                "notify_id"     => $notify_id,
                //通知的发送时间。
                "notify_time"   => $notify_time,
                //买家支付宝帐号
                "buyer_email"   => $buyer_email,
            );

            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {

                // 查询订单的状态然后跳转到页面
                $this->redirect(C('alipay.successpage'));//跳转到配置项中配置的支付成功页面；

            }else {

                echo "trade_status=".$_GET['trade_status'];
                // 跳转到支付失败页面
                $this->redirect(C('alipay.errorpage'));//跳转到配置项中配置的支付失败页面；
            }
        }else {

            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo "支付失败！";
        }
    }

    /**
     *测试
     */
    public function example(){


        $this->display('example/index');
    }


    public function successPage(){

        echo  1;

    }

    public function failedPage(){

        echo  2;
    }

}