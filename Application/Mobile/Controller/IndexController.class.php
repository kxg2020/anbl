<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends CommonController {

    public function index(){
        $where[] = [
            'end_time'   => [['egt', time()], '0', 'or'],// 结束时间 大于等于当前时间 或 为0
            'start_time' => ['elt', time()],// 开始时间 小于等于当前时间
            'is_active'      => 1,//上架状态
        ];
        $model = M('project');
        $projectInfo = $model->where($where)->select();
        $this->assign('projectInfo',$projectInfo);
        $this->display('index');
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
                $this->ajaxReturn(['msg'=>"对不起，积分不足！！！",'status'=>0]);
            }
            // 会员id
            $member_id = $this->userInfo['id'];
            // 项目id
            $project_id = intval($data['project_id']);

            $projectInfo = M('Project')->find($project_id);
            if(!$projectInfo){
                $this->ajaxReturn(['msg'=>"项目不存在！！！",'status'=>0]);
            }

            // 判断目标金额是否达到
            if($projectInfo['target_amount'] <= $projectInfo['money']){
                $this->ajaxReturn(['msg'=>"积分已达到，不能进行支持",'status'=>0]);
            }

            if(($support_money+$projectInfo['money'])>$projectInfo['target_amount']){
                $x = $projectInfo['target_amount']-$projectInfo['money'];
                $this->ajaxReturn(['msg'=>"该影片还可以提供.$x.阿纳豆支持",'status'=>0]);
            }

            // 分红类型  1固定 2浮动

            $type = intval($data['type']);

            // 生成订单
            $order_number = 'ZC'.date('Ymd') . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
            //封装数据
            $supportInfo = [
                'member_id' => $member_id,
                'project_id' => $project_id,
                'support_money' => $support_money,
                'type' => $type,
                'order_number' => $order_number,
                'is_fh' => 0,//是否分红
                'is_true' => 0,//是否返还用户余额
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
            $rest = M('Member')->where(['id' => $member_id])->save(['money' => ['exp', 'money-' . $support_money]]);
            if(!$rest){
                M()->rollback();
                $this->ajaxReturn(['msg'=>"订单保存失败！！！",'status'=>0]);
            }

            // 更新支持人数 //支持金额
            $rest = M('Project')
                ->where(['id'=>$projectInfo['id']])
                ->save([
                    'support_number' => $projectInfo['support_number']+1,
                    'money' => $projectInfo['money']+$support_money,
                ]);
            if(!$rest){
                M()->rollback();
                $this->ajaxReturn(['msg'=>"订单保存失败！！！",'status'=>0]);
            }

            //提交事物
            M()->commit();
            $this->ajaxReturn(['msg'=>"支持成功！！！",'status'=>1]);
        }
    }

}