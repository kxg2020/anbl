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

                //>> 查询出原有的积分和余额
                $row = M('Member')->where(['id'=>$this->userInfo['id']])->find();
                //>> 查询积分规则表
                $ins = M('IntegralInstitution')->select();

                $newLevel = $row['level'];
                foreach($ins as $key => $value){
                    //>> 取出当前等级下一级所对应的积分
                    if($paramArr['money'] + $row['money'] > $value['integral'] && $row['integral'] + $paramArr['money'] > $value['integral'] ){
                        $newLevel = $value['level'];
                    }
                }
                $insertData = [
                    'money'=>$paramArr['money'] + $row['money'],
                    'integral'=>$paramArr['money'] + $row['integral'],
                    'level'=>$newLevel,
                ];

                M('Member')->startTrans();
                $res = M('Member')->where(['id'=>$this->userInfo['id']])->save($insertData);
                //>> 生成流水号
                $orderNumber = 'RE' . sprintf("%08d",$this->userInfo['id']);
                $orderData = [
                    'member_id'=>$this->userInfo['id'],
                    'money'=>$paramArr['money'],
                    'create_time'=>time(),
                    'type'=>1,
                    'is_pass'=>0,
                    'order_number'=>$orderNumber
                ];
                //>> 添加到充值订单表
                $ros = M('MemberRecharge')->add($orderData);

                if($res && $ros){

                    M('Member')->commit();

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