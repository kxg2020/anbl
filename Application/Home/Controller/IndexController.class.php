<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends CommonController{

    /**
     * 首页界面
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
        $commentModel = M('Comment');
        //>> 默认查询导演
        $rows = $commentModel->where(['type'=>1,'movie_id'=>$id])->select();
        $directorArr = [];
        $count = 0;
        if(!empty($rows)){
            $count = ceil(count($rows) / 12);
            $directorArr = $this->pagination($rows,1,12);
        }
        // 查看项目是否存在
        $info = M('project as a')
            ->join('left join an_project_survey as b on b.project_id = a.id')
            ->where(['a.id'=>$id])
            ->find();
        if(!$info){
            $this->error('项目不存在');
            exit;
        }
        $this->assign([
            'info'=>$info,
            'comment'=>$directorArr,
            'count'=>$count,
        ]);
        $this->display('index/detail');
    }

    /**
     * 分页查询
     */
    public function pageSelect(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){
            if(isset($paramArr['pgNum']) && !empty($paramArr['pgNum']) && is_numeric($paramArr['pgNum'])){
                $pgNum = $paramArr['pgNum'];
            }else{
                $pgNum = 1;
            }
            if(isset($paramArr['pgSize']) &&!empty($paramArr['pgSize']) && is_numeric($paramArr['pgSize'])){
                $pgSize = $paramArr['pgSize'];
            }else{
                $pgSize = 12;
            }
            $rows = M('Comment')->where(['movie_id'=>$paramArr['type']])->select();

            if(!empty($rows)){
                $directorArr = $this->pagination($rows,$pgNum,$pgSize);
                $this->ajaxReturn([
                    'directorArr'=>$directorArr,
                    'status'=>1
                ]);
            }else{
                die($this->_printError(''));
            }
        }else{
            die($this->_printError(''));
        }
    }

    /**
     * 分页工具
     */
    public function pagination($data = [],$pgNum,$pgSize){

        if(empty($data)) return false;

        $start = ($pgNum - 1) * $pgSize;
        $sliceArr = array_slice($data,$start,$pgSize);
        return $sliceArr;
    }
}
