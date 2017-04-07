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
            $id = intval(I('get.id'));
            // 判断项目是否存在
            $projectInfo = M('Project')->find($id);
            if (!$projectInfo) {
                $this->ajaxReturn(['msg' => "项目不存在", 'status' => 0]);
            }
            // 判断分佣所用到的参数是否完整
            if(!$projectInfo['real_rate']){
                $this->ajaxReturn(['msg' => "真实票房收益不存在", 'status' => 0]);
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
            ];

            $supportInfo = M('MemberSupport')->where($where)->select();

            if(!$supportInfo){
                $this->ajaxReturn(['msg'=>"该项目还没有支持订单产生",'status'=>0]);
            }

            // 开启事物
            M()->startTrans();

            foreach ($members as $member) {
                //判断会员等级
                if ($member['role'] == 1) {//支持者 查询出一代会员
                    $money = '';
                    $childs = M('Member')->where(['parent_id'=>$member['id']])->select();
                    foreach($childs as $child){
                        foreach($supportInfo as $info){
                            if($info['member_id'] == $child['id']){
                                $money += $info['support_money']*0.05;
                            }
                        }
                    }
                    $data = [
                        'member_id' =>$member['id'],
                        'type' =>2,//佣金
                        'money' =>$money,
                        'remark' =>"支持者一代佣金",
                        'create_time' =>time(),
                    ];
                    // 保存到数据表
                    $rest = M('MemberProfit')->add($data);
                    if($rest === false){
                        $this->ajaxReturn(['msg'=>"分佣失败",'status'=>0]);
                    }

                } elseif ($member['role'] == 2) {//经纪人

                } elseif ($member['role'] == 3) {//制片人

                } elseif ($member['role'] == 4) {//出品人

                }
            }

            // 提交事物
            M()->commit();
            $this->ajaxReturn(['msg'=>"分佣成功",'status'=>1]);

        }
    }
}