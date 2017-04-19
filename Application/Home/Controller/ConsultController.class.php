<?php
namespace Home\Controller;

use Think\Controller;

class ConsultController extends CommonController{

    /**
     * �û���ѯ
     */
    public function add(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){

            $insertData = [
                'title'=>$paramArr['title'],
                'content'=>$paramArr['content'],
                'status'=>0,
                'image_url'=>$paramArr['image_url'],
                'create_time'=>time(),
                'member_id'=>$this->userInfo['id'],
            ];

            $res = M('MemberConsult')->add($insertData);
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

            die();
        }
    }
}