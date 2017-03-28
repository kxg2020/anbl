<?php
namespace Home\Controller;

class FactoryController extends CommonController
{

    public function index(){
        // 查询出所有优秀演员
        $performerInfos = M('Performer')
            ->order('create_time desc')
            ->limit(0,11)
            ->select();
        $this->assign('performerInfos',$performerInfos);
        // 查询出所有优秀导演
        $directorInfos = M('Director')
            ->order('create_time desc')
            ->limit(0,11)
            ->select();
        $this->assign('directorInfos',$directorInfos);
        // 查询出所有优秀作品
        $worksInfos = M('Works')
            ->order('create_time desc')
            ->limit(0,11)
            ->select();
        $this->assign('worksInfos',$worksInfos);
        dump($performerInfos);
        dump($directorInfos);
        dump($worksInfos);
    }

    /**
     * 投票
     */
    public function vote($type_id,$id){

    }

}