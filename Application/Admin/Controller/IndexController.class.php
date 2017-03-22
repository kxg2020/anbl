<?php
namespace Admin\Controller;

use Think\Controller;

class IndexController extends CommonController {

    public function _initialize(){
        parent::_initialize();
        // 检测用户是否登录，没有登录不能继续执行
        if(!$this->isLogin){
            $this->redirect('admin/login/index');
            exit;
        }
    }

    /**
     * 后台首页
     */
    public function index(){

        $this->display('index/index');
    }


}