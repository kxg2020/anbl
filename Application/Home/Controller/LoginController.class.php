<?php
namespace Home\Controller;

use Think\Controller;

class LoginController extends CommonController{

    /**
     * 登录界面
     */
    public function index(){

        //>> 判断是否登录过了
        if($this->isLogin == 1){

            $this->redirect('home/index/index');
        }

        $this->display('login/index');
    }

    /**
     * 检测登录
     */
    public function login(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){

            $userModel = M('Member');
            if(isset($paramArr['username']) && !empty($paramArr['username']) && is_numeric($paramArr['username'])){

                //>> 判断用户名
                $res = $this->checkPhone($paramArr['username']);
                if(!$res){

                    die($this->_printError('1022'));
                }

            }else{

                die($this->_printError('1018'));
            }

            //>>检测密码
            if(isset($paramArr['password']) && !empty($paramArr['password']) && strlen($paramArr['password']) <= 16){

                $res = $this->checkPassword($paramArr['password']);
                if(!$res){

                    die($this->_printError('1010'));
                }

            }else{

                die($this->_printError('1020'));
            }

            //>> 查询数据库
            $row = $userModel->where(['username'=>$paramArr['username'],'password'=>md5($paramArr['password'])])->find();

            if(!empty($row)){
                //>> 生成token
                $session_token = md5(microtime().'@#$%^&*('.rand(0,9999));
                session(md5('home'),$session_token);
                //>> 将token保存到数据库
                M('Member')->where(['username'=>$paramArr['username'],'password'=>md5($paramArr['password'])])->save([
                    'session_token'=>$session_token
                ]);
                //>> 跳转到首页
                die($this->_printSuccess());
            }else{

                die($this->_printError('1016'));
            }
        }else{

            die($this->_printError('1000'));
        }
    }

    /**
     * 检测用户名
     */
    private function checkPhone($phone){

        if(empty($phone)) return false;

        $reg = '/^0?(13|14|15|17|18)[0-9]{9}$/';

        preg_match_all($reg,$phone,$str);

        if($str){

            return true;

        }else{
            return false;

        }

    }
    /**
     * 检测密码
     */
    private function checkPassword($password){

        if(empty($password)){

            return false;

        }else{
            //>> 检测密码
            if(isset($password) && strlen($password) < 16){

                //>> 密码由字母、数字、下划线组成，5-16位
                $reg = '/^[a-zA-Z]\w{5,16}$/';

                preg_match_all($reg,$password,$str);

                if(!empty($str)){

                    return true;

                }else{

                    return false;
                }
            }

        }

    }
}