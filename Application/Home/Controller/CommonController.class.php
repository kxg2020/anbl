<?php
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller{

    //记录用户登录状态
    public $isLogin = 0;

    //当前用户信息
    public $userInfo = [];

    protected $_msgArr = [

        '1000'=>['用户信息不能为空!','用户信息不能为空!'],
        '1002'=>['短信发送失败!','短信发送失败!'],
        '1004'=>['请等待60秒后再发送验证码!','请等待60秒后再发送验证码!'],
        '1006'=>['手机号码格式不正确!','手机号码格式不正确!'],
        '1008'=>['验证码错误!','验证码错误!'],
        '1010'=>['用户名或密码格式不正确!','用户名或密码的格式不正确!'],
        '1012'=>['注册失败!','注册失败！'],
        '1014'=>['请不要重复注册!','请不要重复注册！'],
        '1016'=>['用户名或密码错误!','用户名或密码错误！'],
        '1018'=>['用户名不能为空!','用户名不能为空！'],
        '1020'=>['密码不能为空!','密码不能为空！'],
        '1022'=>['用户名格式不正确!','用户名格式不正确！'],
        '1024'=>['密码格式不正确!','密码格式不正确！'],
        '1026'=>['确认密码不能为空!','确认密码不能为空！'],
        '1028'=>['两次密码不一致!','两次密码不一致！'],
        '1030'=>['密码修改失败!','密码修改失败！'],
        '1032'=>['用户名不存在!','用户名不存在！'],

    ];

    /**
     * 初始化
     */
    public function _initialize(){
        //>> 拿session
        $session = session(md5('home'));
        if(!empty($session)){
            //>> 查询用户
            $row = M('Member')->where(['session_token'=>$session])->find();
            if(!empty($row)){
                $this->isLogin = 1;
                $this->userInfo = $row;
                $this->assign('userInfo',$row);
            }
        }else{
            //>> 拿cookie
            $cookie = cookie(md5('home'));

            if(!empty($cookie)){
                $row = M('User')->where(['remember_token'=>$cookie]);
                if(!empty($row)){

                    $this->isLogin = 1;
                    $this->userInfo = $row;
                    $this->assign('userInfo',$row);
                }
            }
        }

    }

    /**
     *获取错误
     */
    public function getError($code,$isShow = 1){

        if(empty($code)) return false;

        $errMsg = $this->_msgArr[$code][0];

        if($isShow){

            $msg = ['status'=>0,'msg'=>$errMsg,'errCode'=>$code];

        }else{

            $msg = ['status'=>0,'errCode'=>$code];

        }

        return $msg;
    }

    /**
     * 发送错误
     */
    public function _printError($code){

        if(empty($code)) return false;

        $out = $this->getError($code);

        return json_encode($out,JSON_UNESCAPED_UNICODE);

    }

    /**
     * 请求成功
     */
    public function _printSuccess($value = [],$isobject = 0)
    {
        $out = array("status" => 1,"data" => $value);

        if($isobject){

            $out = array("status" => 1,"data" => (object)$value );
        }

        return json_encode($out);
    }
}