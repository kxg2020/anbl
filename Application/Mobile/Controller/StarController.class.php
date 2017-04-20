<?php
namespace Mobile\Controller;

class StarController extends CommonController{

    public function index(){

        //>> 查询招募电影
        $recruit = M('ProjectRecruit')->select();
        $this->assign('recruit',$recruit);
        $this->display('star/index');
    }
}