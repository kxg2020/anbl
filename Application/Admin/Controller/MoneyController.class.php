<?php
namespace Admin\Controller;

class MoneyController extends CommonController
{
    /**
     * 静态制度分红
     */
    public function index(){
        if(IS_POST && IS_AJAX){
            $id =  intval(I('post.id'));
            // 判断项目是否存在
            $projectInfo = M('Project')->find($id);
            if(!$projectInfo){
                $this->ajaxReturn(['msg'=>"项目不存在",'status'=>0]);
            }

            //判断分红方式是否存在
            if(!$projectInfo['fixed_rate']){
                $this->ajaxReturn(['msg'=>"固定分红比例没有设置",'status'=>0]);
            }

            if(!$projectInfo['float_rate']){
                $this->ajaxReturn(['msg'=>"浮动分红比例没有设置",'status'=>0]);
            }

            if($projectInfo['is_active'] == 1){
                $this->ajaxReturn(['msg'=>"项目还未下架，不能进行分红",'status'=>0]);
            }

            /*if(!$projectInfo['real_rate']){
                $this->ajaxReturn(['msg'=>"真实票房收益没有设置",'status'=>0]);
            }*/

            //=============================== 立即分红===========================//

            // 查询出当前项目所有支持订单
            $where = [
                'project_id'=>$projectInfo['id'],//当前项目
                'is_fh'=> 0,//未分红的订单
            ];
            $supportInfo = M('MemberSupport')
                ->where($where)->select();

            if(!$supportInfo){
                $this->ajaxReturn(['msg'=>"该项目还没有支持订单产生",'status'=>0]);
            }
            M()->startTrans();
            // 静态分红
            foreach($supportInfo as &$info){
                if($info['type'] == 1){//订单为固定分红方式的用户
                    $rest = M('MemberSupport')
                        ->where(['id'=>$info['id']])
                        ->save([
                            'expect_return'=>$info['support_money']*($projectInfo['fixed_rate']/100),
                            'is_fh'=> 1,
                            'is_true'=> 1,
                        ]);
                    if($rest === false){
                        M()->rollback();
                        $this->ajaxReturn(['msg'=>"分红失败",'status'=>0]);
                    }
                    // 更新会员余额
                    $money = $info['support_money']+$info['support_money']*($projectInfo['fixed_rate']/100);
                    $rest = M('Member')->where(['id'=>$info['member_id']])->save(['money'=>['exp','money+'.$money]]);
                    if($rest === false){
                        M()->rollback();
                        $this->ajaxReturn(['msg'=>"分红失败",'status'=>0]);
                    }

                    // 向会员收益表追加一条记录
                    $rest = M('MemberProfit')->add([
                        'member_id' =>$info['member_id'],
                        'money' =>$money,
                        'create_time' =>time(),
                        'type' =>1,
                        'remark' =>$projectInfo['name']."影片分红",
                    ]);
                    if($rest === false){
                        M()->rollback();
                        $this->ajaxReturn(['msg'=>"分红失败",'status'=>0]);
                    }


                }elseif($info['type'] == 2){//订单为浮动分红方式的用户
                    $rest = M('MemberSupport')
                        ->where(['id'=>$info['id']])
                        ->save([
                            'expect_return'=>$info['support_money']*($projectInfo['float_rate']/100),
                            'is_fh' =>1,
                            'is_true'=> 1,
                        ]);
                    if($rest === false){
                        M()->rollback();
                        $this->ajaxReturn(['msg'=>"分红失败",'status'=>0]);
                    }

                    // 更新会员余额
                    $money = $info['support_money']+$info['support_money']*($projectInfo['float_rate']/100);
                    $rest = M('Member')->where(['id'=>$info['member_id']])->save(['money'=>['exp','money+'.$money]]);
                    if($rest === false){
                        M()->rollback();
                        $this->ajaxReturn(['msg'=>"分红失败",'status'=>0]);
                    }

                    // 向会员收益表追加一条记录
                    $rest = M('MemberProfit')->add([
                        'member_id' =>$info['member_id'],
                        'money' =>$money,
                        'create_time' =>time(),
                        'type' =>1,
                        'remark' =>$projectInfo['name']."影片分红",
                    ]);
                    if($rest === false){
                        M()->rollback();
                        $this->ajaxReturn(['msg'=>"分红失败",'status'=>0]);
                    }

                }
            }
            // 修改项目分红状态
            $rest = M('Project')->where(['id'=>$projectInfo['id']])->save(['is_fh'=>1]);
            if($rest === false){
                M()->rollback();
                $this->ajaxReturn(['msg'=>"分红失败",'status'=>0]);
            }
            M()->commit();

            $this->ajaxReturn(['msg'=>"分红成功",'status'=>1]);
        }
    }

    /**
     * 分发佣金
     */
    public function fy(){
        if(IS_POST && IS_AJAX) {
            $id = intval(I('post.id'));
            // 判断项目是否存在
            $projectInfo = M('Project')->find($id);
            if (!$projectInfo) {
                $this->ajaxReturn(['msg' => "项目不存在", 'status' => 0]);
            }
            // 判断分佣所用到的参数是否完整
            if(!$projectInfo['first_rate']){
                $this->ajaxReturn(['msg' => "分佣参数未设置", 'status' => 0]);
            }
            if(!$projectInfo['two_rate']){
                $this->ajaxReturn(['msg' => "分佣参数未设置", 'status' => 0]);
            }
            if(!$projectInfo['three_rate']){
                $this->ajaxReturn(['msg' => "分佣参数未设置", 'status' => 0]);
            }

            if($projectInfo['is_fh'] == 0){
                $this->ajaxReturn(['msg' => "还没有进行分红，无法分佣", 'status' => 0]);
            }

            // 查询出所有会员
            $members = M('Member')->select();
            if (!$members) {
                $this->ajaxReturn(['msg' => "该系统没有注册会员", 'status' => 0]);
            }

            //查询出所有支持订单且状态为未分佣的订单
            $where = [
                'project_id' => $projectInfo['id'],//当前项目
                'is_fy' => 0,//未分佣的订单
                'is_fh' => 1,//已分红订单
            ];

            $supportInfo = M('MemberSupport')->where($where)->select();

            if(!$supportInfo){
                $this->ajaxReturn(['msg'=>"该项目还没有支持订单产生",'status'=>0]);
            }


            // 开启事物
            M()->startTrans();

            foreach($supportInfo as $info){//拿到每一笔支持订单

                //接受请求参数
                $member_id = $info['member_id'];//当前订单会员id
                // 查询出当前会员信息
                $memberInfo = M('Member')->find($member_id);

                if($info['type'] == 1){//固定分红类型
                    $box = 0;
                }else{
                    $box = $info['expect_return'];
                }
                //进行分佣
                $this->genCommission($info,$box,$projectInfo,$memberInfo['parent_id'],1);
            }
            // 提交事物
            M()->commit();
            $this->ajaxReturn(['msg'=>"分佣成功",'status'=>1]);

        }
    }

    /**
     * @param $info 当前订单信息
     * @param $roi 票房分红
     * @param $projectInfox 当前项目信息
     * @param $parent_id 父级id
     * @param $level 级别
     */
    protected function genCommission($info,$roi, $projectInfox,$parent_id, $level){
        if ($parent_id == 0) {
            return;
        }
        $projectInfo = $projectInfox;

        $parent = M('Member')->where(['id'=>$parent_id])->find();

        switch($parent['role']) {
            case "1":
                if ($level > 1) {
                    return ;
                }
                if($level == 1){//第一父
                    // 计算佣金
                    $commission = $info['support_money']*($projectInfo['first_rate']/100) + $roi*($projectInfo['first_rate']/100);//一代投资额的5%  一代票房收益的5%
                    // 操作数据库
                    $this->insertDb($info,$commission,$parent,$projectInfo['name']);
                }
                break;

            case "2":
                if ($level > 2) {
                    return;
                }
                if($level == 1){//第一父
                    // 计算佣金
                    $commission = $info['support_money']*($projectInfo['first_rate']/100) + $roi*($projectInfo['first_rate']/100);// 5%
                    $this->insertDb($info,$commission,$parent,$projectInfo['name']);
                }
                if($level == 2){//第二父
                    $commission = $info['support_money']*($projectInfo['two_rate']/100) + $roi*($projectInfo['two_rate']/100);//  3%
                    $this->insertDb($info,$commission,$parent,$projectInfo['name']);
                }

                break;

            case "3":
                //计算票房收益
                if ($level > 3) {
                    return;
                }
                if($level == 1){
                    // 计算佣金
                    $commission = $info['support_money']*($projectInfo['first_rate']/100) + $roi*($projectInfo['first_rate']/100);// 5%
                    $this->insertDb($info,$commission,$parent,$projectInfo['name']);

                }
                if($level == 2){
                    $commission = $info['support_money']*($projectInfo['two_rate']/100) + $roi*($projectInfo['two_rate']/100);// 3%
                    $this->insertDb($info,$commission,$parent,$projectInfo['name']);
                }
                if($level == 3){
                    $commission = $info['support_money']*($projectInfo['three_rate']/100) + $roi*($projectInfo['three_rate']/100);// 1%
                    $this->insertDb($info,$commission,$parent,$projectInfo['name']);
                }

                break;

            case "4":
                if ($level > 3) {
                    return;
                }
                if($level == 1){
                    // 计算佣金
                    $commission = $info['support_money']*($projectInfo['first_rate']/100) + $roi*($projectInfo['first_rate']/100);// 5%
                    $this->insertDb($info,$commission,$parent,$projectInfo['name']);
                }
                if($level == 2){
                    $commission = $info['support_money']*($projectInfo['two_rate']/100) + $roi*($projectInfo['two_rate']/100);// 3%
                    $this->insertDb($info,$commission,$parent,$projectInfo['name']);
                }
                if($level == 3){
                    $commission = $info['support_money']*($projectInfo['three_rate']/100) + $roi*($projectInfo['three_rate']/100);// 1%
                    $this->insertDb($info,$commission,$parent,$projectInfo['name']);
                }
                break;

        }
        $this->genCommission($info['support_money'], $roi, $projectInfo,$parent['parent_id'],$level+1);
    }


    /**
     * @param $info 当前订单信息
     * @param $commission 佣金
     * @param $parent 父级
     * @param $projectName 项目名称
     */
    protected function insertDb($info,$commission,$parent,$projectName){

        // 修改订单状态
        $rest = M('MemberSupport')
            ->where(['id'=>$info['id']])
            ->save([
                'is_fy'=> 1,
                'is_ok'=> 1,
            ]);
        if($rest === false){
            M()->rollback();
            $this->ajaxReturn(['msg'=>"分佣失败",'status'=>0]);
        }
        // 更新会员余额
        $money = $commission;
        $rest = M('Member')->where(['id'=>$parent['id']])->save(['money'=>['exp','money+'.$money]]);
        if($rest === false){
            M()->rollback();
            $this->ajaxReturn(['msg'=>"分佣失败",'status'=>0]);
        }

        // 向会员收益表追加一条记录
        $rest = M('MemberProfit')->add([
            'member_id' =>$parent['id'],
            'money' =>$money,
            'create_time' =>time(),
            'type' =>2,
            'remark' =>$projectName."影片分佣",
        ]);
        if($rest === false){
            M()->rollback();
            $this->ajaxReturn(['msg'=>"分佣失败",'status'=>0]);
        }
    }
}