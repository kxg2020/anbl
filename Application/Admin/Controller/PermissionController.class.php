<?php
namespace Admin\Controller;
use Admin\Logic\DbMysqlLogic;
use Admin\Service\NestedSets;
class PermissionController extends CommonController{

    public function add(){

        if(IS_POST){

            $paramArr = $_REQUEST;

            if(empty($paramArr)){

                $this->ajaxReturn(['status'=>0]);
            }

            $db = new DbMysqlLogic();
            $ns = new NestedSets($db, 'an_user_permission', 'lft', 'rght', 'parent_id', 'id', 'level');
            $parent_id = $paramArr['parent_id'];
            $data = [
                'name' => $paramArr['name'],
                'intro' => $paramArr['intro'],
                'status' => $paramArr['status']
            ];
            $res = $ns->insert($parent_id, $data, 'bottom');
            if($res){
                $this->ajaxReturn(['status'=>1]);
            }else{
                $this->ajaxReturn(['status'=>0]);
            }
        }
        //>> 查询权限
        $lists = M('UserPermission')->where(['status' => 1])->order('lft')->select();
        $data = ['id' => -1, 'name' => '顶级分类', 't' => '', 'pId' => 0];
        array_unshift($lists, $data);
        foreach ($lists as &$v){
            $v['pId'] = $v['parent_id'];
            $v['t'] = $v['intro'];
            $v['open'] = true;
        }
        $lists = json_encode($lists);
        $this->assign('list', $lists);
        $this->display('permission/add');
    }
}