<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller {
    /**
     * 登录界面
     */
    public function index(){

        $this->display('index/login');

    }

    /**
     * 后台首页
     */
    public function admin(){
        $this->display('index/index');
    }
}