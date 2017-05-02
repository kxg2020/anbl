<?php
namespace Home\Controller;

use Think\Controller;

class RechargeController extends CommonController{

    /**
     * 账户充值
     */
    public function recharge(){

        $paramArr = $_REQUEST;

        //>> 判断用户是否登录
        if($this->isLogin == 0){
            $this->redirect('Home/Login/index');
            exit;
        }
        //>> 判断用户是否有权限充值
        $memberModel = M('Member');

        $row = $memberModel->where(['id'=>$this->userInfo['id']])->find();

        if($row['is_allowed_recharge'] != 1){

            die($this->_printError('1046'));
        }

        if(!empty($paramArr)){

            if(isset($paramArr['money']) && !empty($paramArr['money']) && is_numeric($paramArr['money'])){

                if($paramArr['money'] <= 700){

                    //>> 判断用户是否点击确认协议
                    $agree = session('agree'.$this->userInfo['id']);
                    if(!$agree){

                        die($this->_printError('1062'));
                    }
                }

                M()->startTrans();
                //>> 生成流水号
                $orderNumber = 'RE'.date('Ymd') . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
                $orderData = [
                    'member_id'=>$this->userInfo['id'],
                    'money'=>$paramArr['money'],
                    'create_time'=>time(),
                    'type'=>$paramArr['type'],
                    'is_pass'=>0,
                    'order_number'=>$orderNumber,
                    'image_url'=>$paramArr['image_url'],
                ];
                //>> 添加到充值订单表
                $ros = M('MemberRecharge')->add($orderData);

                if($ros){

                    M()->commit();

                    die($this->_printSuccess());

                }else{

                    die($this->_printError('1048'));
                }

            }else{

                die($this->_printError('1048'));
            }
        }else{

            die($this->_printError(''));
        }

    }
}