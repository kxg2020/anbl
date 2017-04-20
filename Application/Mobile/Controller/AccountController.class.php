<?php
namespace Mobile\Controller;

class AccountController extends CommonController{

    /**
     * 我的账户
     */
    public function index(){

        $this->display('account/index');
    }
}