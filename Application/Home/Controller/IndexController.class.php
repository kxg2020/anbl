<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {

    /**
     * 初始化
     */
    public function _initialize(){
        parent::_initialize();
        if(!$this->isLogin){
            $this->redirect('home/login/index');
        }
    }
    /**
     * 首页界面
     */
    public function index(){
        $this->display('index/index');
    }



}