<?php
namespace Home\Controller;

use Think\Controller;

class LoginController extends Controller{

    /**
     * ��¼����
     */
    public function index(){

        $this->display('login/index');

    }
}