<?php
namespace Admin\Controller;

use Think\Controller;

class MemberController extends  Controller{

    /**
     * 查询会员
     */
    public function select(){

        $memberList = M('Member')->select();

        $this->assign('list',$memberList);
        $this->display('member/index');
    }

}