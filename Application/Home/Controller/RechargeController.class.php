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

                $insertData = [
                    'money'=>$paramArr['money'],
                ];
            }else{

                die($this->_printError('1048'));
            }
        }else{

            die($this->_printError(''));
        }

    }
}