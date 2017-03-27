<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController{
    /**
     * 展示登录界面
     */
    public function index(){

        // 查询出首页轮播 项目
        $model = M('project');
        $lunbos = $model
            ->where([
                'recommend' => 1,
                'end_time'   => [['egt', time()], '0', 'or'],// 结束时间 大于等于当前时间 或 为0
                'start_time' => ['elt', time()],// 开始时间 小于等于当前时间
                'is_active'      => 1,
                ])
            ->limit(0,3)
            ->select();

        // 查询出星级项目
        $where[] = [
            'end_time'   => [['egt', time()], '0', 'or'],// 结束时间 大于等于当前时间 或 为0
            'start_time' => ['elt', time()],// 开始时间 小于等于当前时间
            'is_active'      => 1,//上架状态
        ];
        $projectInfo = $model
            ->where($where)
            ->select();

        $this->assign('lunbos',$lunbos);
        $this->assign('projectInfo',$projectInfo);
        $this->display('index/index');
    }


    /**
     * 项目详情
     */
    public function detail($id){
        $id = intval($id);

        // 查看项目是否存在
        $info = M('project as a')
            ->join('left join an_project_survey as b on b.project_id = a.id')
            ->where(['a.id'=>$id])
            ->find();
        if(!$info){
            $this->error('项目不存在');
            exit;
        }
        $this->assign('info',$info);
        $this->display('detail');
    }

}