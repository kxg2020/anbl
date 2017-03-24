<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    /**
     * 展示登录界面
     */
    public function index(){
        $this->display('index/index');
    }



}