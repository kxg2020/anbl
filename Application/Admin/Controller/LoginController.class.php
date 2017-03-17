<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller{

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

            session(md5('admin'),$res);

            //>> 判断是否记住个人信息
            if(isset($paramArr['remember']) && $paramArr['remember'] == 1){

                $token = md5(microtime().'!@#$$%^'.rand(0,1000));

                //>> 将token保存到数据库
                M('User')->where(['id'=>$res['id']])->save(['token'=>$token,'create_time'=>time(),'last_ip'=>get_client_ip()]);

                cookie(md5('remember'),$token,time()+7*3600*24);
            }

            $this->redirect('admin/Index/admin');

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
        $this->redirect('Admin/index/index');
    }
}