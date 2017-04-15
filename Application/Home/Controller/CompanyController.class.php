<?php
namespace Home\Controller;

class CompanyController extends CommonController
{
    public function index(){
        $this->display('company/index');
    }
    public function about(){
        // 查询出合作机构
        $cooper = M('Cooper')->select();
        // 分配合作机构数据
        $this->assign('cooper',$cooper);
        $this->display('company/about');
    }
}