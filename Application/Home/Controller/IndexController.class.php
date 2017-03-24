<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {

    /**
     * 初始化
     */
    public function _initialize(){
        parent::_initialize();
        if(!$this->isLogin){
            $this->redirect('home/login/index');
        }
    }
    /**
     * 首页界面
     */
    public function index(){

        // 查询出首页轮播 项目
        $model = M('project');
        $lunbos = $model
            ->where(['recommend' => 1])
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



}