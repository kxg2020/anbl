<?php
namespace Home\Controller;

class CompanyController extends CommonController
{
    public function index(){
        $this->display('index');
    }
    public function about(){
        $this->display('about');
    }
}