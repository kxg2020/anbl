<?php
namespace Home\Controller;

class CompanyController extends CommonController
{
    public function index(){
        $this->display('company/index');
    }
    public function about(){
        $this->display('company/about');
    }
}