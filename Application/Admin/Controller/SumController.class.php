<?php
namespace Admin\Controller;

class SumController extends CommonController
{
    public function index($id){
        // 接收会员id
        $id = intval($id);
        // 查看会员是否存在
        $memberInfo = M('Member')->find($id);
        if(!$memberInfo){
            $this->error('会员不存在');
        }
        $this->display('sum/index');
    }
}