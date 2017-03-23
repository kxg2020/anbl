<?php
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller{

    //记录用户登录状态
    public $isLogin = false;

    //当前用户信息
    public $userInfo = [];

    protected $_msgArr = [

        '1000'=>['用户注册信息不能为空!','用户注册信息不能为空!'],
        '1002'=>['短信发送失败!','短信发送失败!'],
        '1004'=>['请等待60秒后再发送验证码!','请等待60秒后再发送验证码!'],
        '1006'=>['手机号码格式不正确!','手机号码格式不正确!'],
        '1008'=>['验证码错误!','验证码错误!'],
        '1010'=>['用户名或密码格式不正确!','用户名或密码的格式不正确!'],
        '1012'=>['注册失败!','注册失败！'],
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