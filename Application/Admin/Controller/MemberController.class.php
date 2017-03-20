<?php
namespace Admin\Controller;

use Think\Controller;

class MemberController extends  Controller{

    /**
     * 查询会员
     */
    public function select(){

        $paramArr = $_REQUEST;

        $list = M('Member')->select();
        if(empty($list)){

            exit;
        }
        $count = ceil(count($list)/20);

        if(isset($paramArr['pgNum']) && !empty($paramArr['pgNum']) && is_numeric($paramArr['pgNum'])){
            $pgNum = $paramArr['pgNum'];
        }else{
            $pgNum = 1;
        }
        if(isset($paramArr['pgSize']) && !empty($paramArr['pgSize']) && is_numeric($paramArr['pgSize'])){
            $pgSize = $paramArr['pgSize'];
        }else{
            $pgSize = 20;
        }

        $memberList = $this->pagination($list,$pgNum,$pgSize);

        if(IS_AJAX){
            $this->ajaxReturn([
                'data'=>array_values($memberList),
                'status'=>1
            ]);
            exit;
        }

        $this->assign([
            'list'=>$memberList,
            'count'=>$count
        ]);

        $this->display('member/index');
    }

    /**
     * 分页方法
     */
    public function pagination($data = [],$pgNum = '',$pgSize = ''){
        if(empty($data)){

            return false;
        }

        $start = ($pgNum - 1)*$pgSize;

        $sliceArr = array_slice($data,$start,$pgSize,true);

        return $sliceArr;
    }

    /**
     * 会员详情
     */
    public function detail(){

        $paramArr = $_REQUEST;
        $memberModel = M('Member');

        //>> 查询数据库
        $res = $memberModel->where(['id'=>$paramArr['id']])->find();
        if(!empty($res)){

            $res['date'] = date('Y-m-d',$res['create_time']);

            //>> 分配数据
            $this->assign('detail',$res);

            $this->display('member/detail');

        }else{

            return;

        }
    }

    /**
     * 编辑保存
     */
    public function save(){

        $paramArr = $_REQUEST;
        $memberModel = M('Member');

        //>> 保存数据
        if(!empty($paramArr)){
            var_dump($paramArr);
        }

    }

}