<?php
namespace Admin\Controller;

class CommissionController extends CommonController
{

    /**
     * 分发支持佣金,只看投资额
     */
    public function getYj()
    {
            $where = [
                'is_fy' => 1,//已分佣的订单
            ];

            $supportInfo = M('MemberSupport')->where($where)->select();
            foreach($supportInfo as $info){
                $projectInfo = M('Project')->find($info['project_id']);
                if (!$projectInfo) {// 项目不存在
                    continue;
                }
                if ($projectInfo['is_active'] == 0 && $projectInfo['is_ok'] == 0) {

                    // 当前订单用户的收益全部失效
                    $profits = M('MemberProfit')->where(['support_id' => $info['id']])->select();
                    foreach ($profits as $profit) {
                        // 修改收益状态
                        $rest = M('MemberProfit')->where(['id' => $profit['id']])->save(['is_ok' => 0, 'intro' => $projectInfo['name'] . "目标金额未达到",]);
                        // 扣除用户余额
                        $money = $profit['money'];
                        $rest = M('Member')->where(['id' => $profit['member_id']])->save(['money' => ['exp', 'money-' . $money]]);
                    }
                    // 修改订单状态
                    $rest = M('MemberSupport')
                        ->where(['id' => $info['id']])
                        ->save([
                            'fixed' => 0,//每天的收益
                            'is_fh' => 2,//失效订单
                            'is_fy' => 2,//失效订单
                        ]);
                    if ($rest === false) {
                        M()->rollback();
                        exit;
                    }
                    continue;
                }
            }

            //查询出所有支持订单且状态为未分佣的订单
            $where = [
                'is_fy' => 0,//未分佣的订单
            ];

            $supportInfo = M('MemberSupport')->where($where)->select();

            if (!$supportInfo) {
                $this->ajaxReturn(['msg' => "该项目没有未分佣的订单", 'status' => 0]);
            }


            // 开启事物
            M()->startTrans();

            foreach ($supportInfo as $info) {//拿到每一笔支持订单
                $projectInfo = M('Project')->find($info['project_id']);
                if (!$projectInfo) {// 项目不存在
                    continue;
                }

                if ($projectInfo['is_active'] == 0 && $projectInfo['is_ok'] == 0) {

                    // 当前订单用户的收益全部失效
                    $profits = M('MemberProfit')->where(['support_id' => $info['id']])->select();
                    foreach ($profits as $profit) {
                        // 修改收益状态
                        $rest = M('MemberProfit')->where(['id' => $profit['id']])->save(['is_ok' => 0, 'intro' => $projectInfo['name'] . "目标金额未达到",]);
                        // 扣除用户余额
                        $money = $profit['money'];
                        $rest = M('Member')->where(['id' => $profit['member_id']])->save(['money' => ['exp', 'money-' . $money]]);
                    }
                    // 修改订单状态
                    $rest = M('MemberSupport')
                        ->where(['id' => $info['id']])
                        ->save([
                            'fixed' => 0,//每天的收益
                            'is_fh' => 2,//失效订单
                            'is_fy' => 2,//失效订单
                        ]);
                    if ($rest === false) {
                        M()->rollback();
                        exit;
                    }
                    continue;
                }

                //接受请求参数
                $member_id = $info['member_id'];//当前订单会员id
                // 查询出当前会员信息
                $memberInfo = M('Member')->find($member_id);

                // 查询投资项目
                $projectInfo = M('Project')->where(['id'=>$info['project_id']])->find();

                //进行分佣
                $this->genCommission($info, $projectInfo, $memberInfo['parent_id'], 1);
            }
            // 提交事物
            M()->commit();
            $this->ajaxReturn(['msg' => "分佣成功", 'status' => 1]);

    }

    /**
     * @param $info 当前订单信息
     * @param $projectInfox 当前项目信息
     * @param $parent_id 父级id
     * @param $level 级别
     */
    protected function genCommission($info, $projectInfox, $parent_id, $level)
    {

        if ($parent_id == 0) {
            $rest = M('MemberSupport')
                ->where(['id' => $info['id']])
                ->save([
                    'is_fy' => 1,
                    'is_ok' => 1,
                ]);
            if ($rest === false) {
                M()->rollback();
                $this->ajaxReturn(['msg' => "分佣失败", 'status' => 0]);
            }
            return;
        }
        $projectInfo = $projectInfox;

        $parent = M('Member')->where(['id' => $parent_id])->find();

        switch ($parent['role']) {
            case "1":
                if ($level > 1) {
                    return;
                }
                if ($level == 1) {//第一父
                    // 计算佣金
                    $commission = $info['support_money'] * ($projectInfo['first_rate'] / 100);//一代投资额的5%  一代票房收益的5%
                    // 操作数据库
                    $this->insertDb($info, $commission, $parent, $projectInfo['name']);
                }
                break;

            case "2":
                if ($level > 2) {
                    return;
                }
                if ($level == 1) {//第一父
                    // 计算佣金
                    $commission = $info['support_money'] * ($projectInfo['first_rate'] / 100);// 5%


                    $this->insertDb($info, $commission, $parent, $projectInfo['name']);
                }
                if ($level == 2) {//第二父
                    $commission = $info['support_money'] * ($projectInfo['two_rate'] / 100);//  3%
                    $this->insertDb($info, $commission, $parent, $projectInfo['name']);
                }

                break;

            case "3"://制片人
                //计算票房收益
                if ($level > 3) {
                    return;
                }
                if ($level == 1) {
                    // 计算佣金
                    $commission = $info['support_money'] * ($projectInfo['first_rate'] / 100);// 5%
                    $this->insertDb($info, $commission, $parent, $projectInfo['name']);

                }
                if ($level == 2) {

                    $commission = $info['support_money'] * ($projectInfo['two_rate'] / 100);// 3%

                    $this->insertDb($info, $commission, $parent, $projectInfo['name']);
                }
                if ($level == 3) {
                    $commission = $info['support_money'] * ($projectInfo['three_rate'] / 100);// 1%
                    $this->insertDb($info, $commission, $parent, $projectInfo['name']);
                }

                break;

            case "4"://出品人
                if ($level > 3) {
                    return;
                }
                if ($level == 1) {
                    // 计算佣金
                    $commission = $info['support_money'] * ($projectInfo['first_rate'] / 100);// 5%
                    $this->insertDb($info, $commission, $parent, $projectInfo['name']);
                }
                if ($level == 2) {
                    $commission = $info['support_money'] * ($projectInfo['two_rate'] / 100);// 3%
                    $this->insertDb($info, $commission, $parent, $projectInfo['name']);
                }
                if ($level == 3) {
                    $commission = $info['support_money'] * ($projectInfo['three_rate'] / 100);// 1%
                    $this->insertDb($info, $commission, $parent, $projectInfo['name']);
                }
                break;

        }
        $this->genCommission($info,$projectInfo, $parent['parent_id'], $level + 1);
    }


    /**
     * @param $info 当前订单信息
     * @param $commission 佣金
     * @param $parent 父级
     * @param $projectName 项目名称
     */
    protected function insertDb($info, $commission, $parent, $projectName)
    {

        // 修改订单状态
        $rest = M('MemberSupport')
            ->where(['id' => $info['id']])
            ->save([
                'is_fy' => 1,
                'is_ok' => 1,
            ]);
        if ($rest === false) {
            M()->rollback();
            $this->ajaxReturn(['msg' => "分佣失败", 'status' => 0]);
        }
        // 更新会员余额
        $money = $commission;
        $rest = M('Member')->where(['id' => $parent['id']])->save(['money' => ['exp', 'money+' . $money]]);
        if ($rest === false) {
            M()->rollback();
            $this->ajaxReturn(['msg' => "分佣失败", 'status' => 0]);
        }

        // 向会员收益表追加一条记录
        $rest = M('MemberProfit')->add([
            'member_id' => $parent['id'],
            'money' => $money,
            'create_time' => time(),
            'support_id' =>$info['id'],
            'type' => 2,
            'remark' => $projectName . "影片分佣",
        ]);
        if ($rest === false) {
            M()->rollback();
            $this->ajaxReturn(['msg' => "分佣失败", 'status' => 0]);
        }
    }

}