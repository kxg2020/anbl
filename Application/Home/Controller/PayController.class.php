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

        // 设置这个页面的字符集
        header("Content-type:text/html;charset=utf-8");
        // 获取支付宝配置
        $alipay_config=C('alipay_config');
        // 支付类型,不修改
        $payment_type = "1";
        // 服务器异步通知页面路径
        $notify_url = C('alipay.notify_url');
        // 页面跳转同步通知页面路径
        $return_url = C('alipay.return_url');
        // 卖家支付宝帐户必填
        $seller_email = C('alipay.seller_email');
        // 商户订单号 通过支付页面的表单进行传递，注意要唯一
        $out_trade_no = '801512365245';
        // 订单名称,必填 通过支付页面的表单进行传递
        $subject = '比手速大赛';
        // 付款金额,必填,通过支付页面的表单进行传递
        $total_fee = '0.01';
        // 订单描述,通过支付页面的表单进行传递
        $body = '快付款，比赛手速';
        // 商品展示地址 通过支付页面的表单进行传递
        $show_url = $_POST['ordshow_url'];
        // 防钓鱼时间戳,若要使用请调用类文件submit中的query_timestamp函数
        $anti_phishing_key = "";
        // 客户端的IP地址
        $exter_invoke_ip = '';

        // 构造要请求的参数数组
        $parameter = array(
            "service"       => "create_direct_pay_by_user",
            "partner"       => trim($alipay_config['partner']),
            "payment_type"  => $payment_type,
            "notify_url"    => $notify_url,
            "return_url"    => $return_url,
            "seller_email"  => $seller_email,
            "out_trade_no"  => $out_trade_no,
            "subject"       => $subject,
            "total_fee"     => $total_fee,
            "body"          => $body,
            "show_url"      => $show_url,
            "anti_phishing_key"    => $anti_phishing_key,
            "exter_invoke_ip"      => $exter_invoke_ip,
            "_input_charset"       => trim(strtolower($alipay_config['input_charset']))
        );
        //>> 实例化对象,建立请求
        $submit = new \AlipaySubmit($alipay_config);

        // 创建支付表单页面
        $htmlText = $submit->buildRequestForm($parameter,"post", "确认");

        // 显示支付表单页面
        echo $htmlText;
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