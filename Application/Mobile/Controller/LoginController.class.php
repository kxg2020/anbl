<?php
namespace Mobile\Controller;

class LoginController extends CommonController{

    /*
     * 展示登录
     */
    public function index(){

        $this->display('login/index');
    }
}