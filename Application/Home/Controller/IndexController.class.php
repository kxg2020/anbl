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
            $rows = M('Comment')->where(['movie_id'=>$paramArr['movie_id'] ,'type'=>$paramArr['type']])->select();

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

    public function support(){
        if(IS_POST && IS_AJAX){
            //判断会员是否已经登录
            if(!$this->isLogin){
                $this->ajaxReturn(['msg'=>"对不起，您还没有登录！！！",'status'=>0]);
            }
            $data = i('post.');
            // 支持金额
            $support_money = $data['money'];

            // 判断用户余额够不够
            if($support_money>$this->userInfo['money']){
                $this->ajaxReturn(['msg'=>"对不起，余额不足！！！",'status'=>0]);
            }
            // 会员id
            $member_id = $this->userInfo['id'];
            // 项目id
            $project_id = intval($data['project_id']);

            $projectInfo = M('Project')->find($project_id);
            if(!$projectInfo){
                $this->ajaxReturn(['msg'=>"非法项目！！！",'status'=>0]);
            }

            // 生成订单
            $order_number = 'AN' . sprintf("%09d",$member_id);
            //封装数据
            $supportInfo = [
                'member_id' => $member_id,
                'project_id' => $project_id,
                'support_money' => $support_money,
                'expect_return' => '',
                'order_number' => $order_number,
                'create_time' => time(),
            ];

            // 开启事物
            M()->startTrans();

            //保存支持信息
            $rest = M('MemberSupport')->add($supportInfo);
            if(!$rest){
                M()->rollback();
                $this->ajaxReturn(['msg'=>"订单保存失败！！！",'status'=>0]);
            }

            // 更新用户余额
            $rest = M('Member')->where(['id'=>$member_id])->save(['money'=>$this->userInfo['money']-$support_money]);
            if(!$rest){
                M()->rollback();
                $this->ajaxReturn(['msg'=>"订单保存失败！！！",'status'=>0]);
            }
            //提交事物
            M()->commit();
            $this->ajaxReturn(['msg'=>"支持成功！！！",'status'=>1]);
        }
    }
//收藏
    public function collect(){
        if(IS_POST && IS_AJAX){
            //判断会员是否已经登录
            if(!$this->isLogin){
                $this->ajaxReturn(['msg'=>"对不起，您还没有登录！！！",'status'=>0]);
            }
            $project_id = intval(I('post.project_id'));
            $projectInfo = M('Project')->find($project_id);

            if(!$projectInfo){
                $this->ajaxReturn(['msg'=>"非法项目！！！",'status'=>0]);
            }

            $model = M('MemberCollection');

            //判断用户是否已经收藏该项目
            $info = $model->where(['member_id'=>$this->userInfo['id'],
                'project_id'=>$projectInfo['id']])->find();
            if($info){
                $this->ajaxReturn(['msg'=>"您已收藏该项目！！！",'status'=>0]);
            }
            //收藏
            $data = [
                'member_id'=>$this->userInfo['id'],
                'project_id'=>$projectInfo['id'],
                'create_time'=>time(),
            ];

            $id = $model->add($data);
            if($id===false){
                $this->ajaxReturn(['msg'=>"收藏失败",'status'=>0]);
            }

            //更新项目收藏人数
            $rest = M('Project')->where(['id'=>$projectInfo['id']])->save(['collection_number'=>$projectInfo['collection_number']+1]);
            if($rest === false){
                $this->ajaxReturn(['msg'=>"收藏失败",'status'=>0]);
            }

            $this->ajaxReturn(['msg'=>"收藏成功",'status'=>1,'info'=>$projectInfo['collection_number']+1]);

        }
    }
}
