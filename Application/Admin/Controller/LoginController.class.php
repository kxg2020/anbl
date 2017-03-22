<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends CommonController{

    /**
     * 登录界面
     */
    public function index(){

        if($this->isLogin){
            $this->redirect('admin/index/index');
            exit;
        }
        $this->display('index/login');

    }

    /**
     * 登录方法
     */
    public function login(){


        $paramArr = $_REQUEST;

        if(empty($paramArr['username']) || empty($paramArr['password'])){

            $this->error('用户名或密码不能为空!');

            exit;
        }

        if(!isset($paramArr['username']) && strlen($paramArr['username']) > 16 && !isset($paramArr['password'])){

            $this->error('用户名或密码格式不正确!');
        }

        $where = [
            'username'=>$paramArr['username'],
            'password'=>md5($paramArr['password']),
        ];

        $res = M('User')->where($where)->find();

        if(!empty($res)){

            $token = md5(microtime().'!@#$$%^'.rand(0,1000));
            session(md5('admin'),$token);
            M('User')->where(['id'=>$res['id']])->save(['session_token'=>$token,'create_time'=>time(),'last_ip'=>get_client_ip()]);
            //>> 判断是否记住个人信息
            if(isset($paramArr['remember']) && $paramArr['remember'] == 1){

                $rememberToken = md5(microtime().rand(0,1000));

                cookie(md5('admin'),$rememberToken,time()+7*3600*24);

                //>> 将token保存到数据库
                M('User')->where(['id'=>$res['id']])->save(['remember_token'=>$rememberToken]);
            }

            $this->redirect('admin/Index/index');

        }else{

            $this->error('用户名或密码错误!');
        }
    }

    /**
     * 退出方法
     */
    public function logout(){
        session(md5('admin'), null);
        cookie(md5('remember'), null);
        $this->redirect('Admin/login/index');
    }
}