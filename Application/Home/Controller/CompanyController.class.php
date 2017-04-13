<?php
namespace Home\Controller;

class CompanyController extends CommonController
{
    public function index(){
        // 查询出合作机构
        $cooper = M('Cooper')->select();
        // 分配合作机构数据
        $this->assign('coopers',$cooper);
        $this->display('company/index');
    }
    public function about(){
        $this->display('company/about');
    }
}