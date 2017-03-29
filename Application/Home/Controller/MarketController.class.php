<?php
namespace Home\Controller;

// 电影超市
class MarketController extends CommonController
{
    public function index(){
        $model = M('project');
        //查询所有上线项目
        $where[] = [
            'end_time'   => [['egt', time()], '0', 'or'],// 结束时间 大于等于当前时间 或 为0
            'start_time' => ['elt', time()],// 开始时间 小于等于当前时间
            'is_active'      => 1,//上架状态
        ];
        $projectInfo = $model
            ->where($where)
            ->select();
        $this->assign('projectInfo',$projectInfo);
        dump($projectInfo);
    }
}