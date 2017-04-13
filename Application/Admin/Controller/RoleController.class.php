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

        if(IS_POST && IS_AJAX){

            $paramArr = $_REQUEST;

            if(!empty($paramArr)){

                //>> 判断电影是否添加
                $where = [];
                $where['name'] = ['like',"%".$paramArr['film']."%"];
                $result = M('ProjectRecruit')->where($where)->find();

                if(!empty($result)){
                    $updateData = [
                        'name'=>$paramArr['film'] ? $paramArr['film'] :'',
                        'image_url'=>$paramArr['image_url'] ? $paramArr['image_url']: '',
                        'role_id'=>json_encode($paramArr['roles']),
                        'create_time'=>time(),
                        'intro'=>$paramArr['intro'] ? $paramArr['intro'] : '',
                    ];
                    $re = M('ProjectRecruit')->where(['id'=>$result['id']])->save($updateData);

                    if($re === false){

                        $this->ajaxReturn([
                            'msg'=>'添加失败',
                            'status'=>0
                        ]);
                    }else{
                        $this->ajaxReturn([
                            'msg'=>'添加成功',
                            'status'=>1
                        ]);
                    }
                }
                $insertData = [
                    'name'=>$paramArr['film'],
                    'image_url'=>$paramArr['image_url'],
                    'role_id'=>json_encode($paramArr['roles']),
                    'create_time'=>time(),
                    'intro'=>$paramArr['intro'] ? $paramArr['intro'] : '',
                ];
                $res = M('ProjectRecruit')->add($insertData);
                if($res){

                    $this->ajaxReturn([
                        'msg'=>'添加成功',
                        'status'=>1
                    ]);
                }else{

                    $this->ajaxReturn([
                        'msg'=>'添加失败',
                        'status'=>0
                    ]);
                }
            }else{

                $this->ajaxReturn([
                    'status'=>0,
                    'msg'=>'添加失败'
                ]);
            }
        }

        $roles = M('ProjectRole')->select();
        $this->assign('roles',$roles);
        $this->display('role/film');
    }

    /**
     * 招募列表
     */
    public function index(){

        $films = M('ProjectRecruit')->select();
        foreach($films as $key => &$value){
            $value['role_id'] = json_decode($value['role_id']);
            //>> 循环查询角色
            foreach($value['role_id'] as $k => $v){
                $row = M('ProjectRole')->where(['id'=>$v])->find();
                $value['roles'][] = $row['name'];
            }
            $value['roles'] = implode('、',$value['roles']);
        }
        unset($value);

        $this->assign('films',$films);
        $this->display('role/index');
    }

    /**
     * 删除招募
     */
    public function delRecruit(){

        $paramArr = $_REQUEST;
        if(!empty($paramArr)){

            $res = M('ProjectRecruit')->where(['id'=>$paramArr['id']])->delete();
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



}