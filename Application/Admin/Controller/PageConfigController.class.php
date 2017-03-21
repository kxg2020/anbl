<?php
namespace Admin\Controller;

use Think\Controller;

class PageConfigController extends  Controller{

    /**
     * 优秀作品
     */
    public function Select(){

        $paramArr = $_REQUEST;
        $list = M('Works')->where(['is_active'=>1])->select();

        if(isset($paramArr['pgNum']) && !empty($paramArr['pgNum']) && $paramArr['pgNum'] < 1000 && is_numeric($paramArr['pgNum'])){
            $pgNum = $paramArr['pgNum'];
        }else{
            $pgNum = 1;
        }
        if(isset($paramArr['pgSize']) && !empty($paramArr['pgSize']) && $paramArr['pgSize'] < 30 && is_numeric($paramArr['pgSize'])){
            $pgSize = $paramArr['pgSize'];
        }else{
            $pgSize = 20;
        }

        if(!empty($list)){

            $count = ceil(count($list)/20);

            $worksList = $this->pagination($list,$pgNum,$pgSize);


        }else{

            return false;

        }

        if(IS_AJAX){
            $this->ajaxReturn([
                'data'=>array_values($worksList),
                'pages'=>$count,
                'status'=>1
            ]);
            exit;
        }

        $this->assign([
            'list'=>$worksList,
            'count'=>$count
        ]);
        $this->display('page/index');

    }

    /**
     * 添加作品
     */
    public function add(){

        $this->display('page/add');
    }

    /**
     * 删除作品
     */
    public function delete(){

        $paramArr = $_REQUEST;

        if(isset($paramArr['id']) && is_numeric($paramArr['id']) && !empty($paramArr['id'])){

            $res = M('Works')->where(['id'=>$paramArr['id']])->save(['is_active'=>0]);
            if($res){
                $this->ajaxReturn([
                    'status'=>1,
                ]);
            }
        }else{
            $this->ajaxReturn([
                'status'=>0
            ]);
        }
    }

    /**
     * 作品详情
     */
    public function detail(){

        $paramArr = $_REQUEST;

        if(isset($paramArr['id']) && !empty($paramArr['id']) && is_numeric($paramArr['id'])){

            $row = M('Works')->where(['id'=>$paramArr['id'],'is_active'=>1])->find();
            if(!empty($row)){

                $this->assign('work',$row);

            }
        }
        $this->display('page/detail');

    }

    /**
     * 分页工具
     */
    public function pagination($data = [],$pgNum = '',$pgSize = ''){

        if(empty($data)){

            return false;

        }
        $start = ($pgNum - 1) * $pgSize;

        $sliceArr = array_slice($data,$start,$pgSize);

        return $sliceArr;
    }

}