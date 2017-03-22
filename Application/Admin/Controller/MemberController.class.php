<?php
namespace Admin\Controller;

use Think\Controller;

class MemberController extends  CommonController{

    public function _initialize(){
        parent::_initialize();
        // 检测用户是否登录，没有登录不能继续执行
        if(!$this->isLogin){
            $this->redirect('admin/login/index');
            exit;
        }
    }

    /**
     * 查询会员
     */
    public function select(){

        $paramArr = $_REQUEST;

        $list = M('Member')->where(['is_active'=>1])->select();
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
        $res = $memberModel->where(['id'=>$paramArr['id'],'is_active'=>1])->find();
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
            $data = [
                'password'=>md5($paramArr['password']),
                'level'=>$paramArr['level'],
                'integral'=>$paramArr['integral'],
                'money'=>$paramArr['money'],
                'phone'=>$paramArr['phone'],
            ];
            $res = $memberModel->where(['id'=>$paramArr['id']])->save($data);

            if($res){

                $this->redirect('admin/member/select');

            }else{

                $this->error('保存失败');

            }

        }

    }

    /**
     * 删除会员
     */
    public function delete(){

        $paramArr = $_REQUEST;

        if(isset($paramArr['id']) && !empty($paramArr['id']) && is_numeric($paramArr['id'])){

            $res = M('Member')->where(['id'=>$paramArr['id']])->save(['is_active'=>0]);
            if($res){

                $this->ajaxReturn([
                    'status'=>1
                ]);

            }else{

                $this->ajaxReturn([
                    'status'=>0
                ]);

            }
        }else{

            return false;

        }
    }
}