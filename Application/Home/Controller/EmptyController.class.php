<?php
    /**
     * 创建者:帅哥杨
     * QQ:203521819
     * Date: 2016/11/17 0017
     * Time: 13:50
     */

    namespace Home\Controller;


    /**
     * 空控制器
     * 
     * Class EmptyController
     * @package Wap\Controller
     */
    class EmptyController extends CommonController
    {
        public function index(){
            $this->display('Error:404');
        }

        public function _empty(){
            $this->display('Error:404');
        }

    }