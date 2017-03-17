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
}