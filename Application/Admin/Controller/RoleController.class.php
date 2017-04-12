<?php
namespace Admin\Controller;

class RoleController extends CommonController{

    /**
     * 添加电影角色
     */
    public function add(){

        //>> 查询已存在的角色
        $roles = M('ProjectRole')->select();

        $this->assign('roles',$roles);
        $this->display('role/add');
    }

    /**
     * 保存角色
     */
    public function save(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){

            //>> 判断是否已经添加过了
            $role = M('ProjectRole')->where(['name'=>$paramArr['role']])->find();
            if(empty($role)){
                $insertData = [
                    'name'=>$paramArr['role'],
                    'create_time'=>time(),
                ];
                $res = M('ProjectRole')->add($insertData);
                if($res){
                    $this->ajaxReturn([
                        'status'=>1,
                        'msg'=>'添加成功'
                    ]);
                }else{
                    $this->ajaxReturn([
                        'status'=>'0',
                        'msg'=>'添加失败'
                    ]);
                }
            }else{
                $this->ajaxReturn([
                    'status'=>0,
                    'msg'=>'你已经添加过该角色'
                ]);
            }
        }else{
            $this->ajaxReturn([
                'status'=>0,
                'msg'=>'添加失败'
            ]);
        }
    }

    /**
     * 删除角色
     */
    public function delete(){
        $paramArr = $_REQUEST;

        if(!empty($paramArr)){

            $res = M('ProjectRole')->where(['id'=>$paramArr['id']])->delete();
            if($res){

                $this->ajaxReturn([
                    'status'=>1,
                    'msg'=>'删除成功'
                ]);
            }else{
                $this->ajaxReturn([
                    'status'=>0,
                    'msg'=>'删除失败'
                ]);
            }
        }else{

            $this->ajaxReturn([
                'status'=>0,
                'msg'=>'删除失败'
            ]);
        }
    }

    /**
     * 招募电影
     */
    public function film(){

        $roles = M('ProjectRole')->select();
        $this->assign('roles',$roles);
        $this->display('role/film');
    }
}