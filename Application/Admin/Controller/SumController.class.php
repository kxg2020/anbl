<?php
namespace Admin\Controller;

class SumController extends CommonController
{

    public function index($id){

        // 接收会员id
        $id = intval($id);

        $paramArr = $_REQUEST;

        if(isset($paramArr['pgNum']) && !empty($paramArr['pgNum']) && is_numeric($paramArr['pgNum'])){
            $pgNum = $paramArr['pgNum'];
        }else{
            $pgNum = 1;
        }
        if(isset($paramArr['pgSize']) && !empty($paramArr['pgSize']) && is_numeric($paramArr['pgSize'])){
            $pgSize = $paramArr['pgSize'];
        }else{
            $pgSize = 17;
        }

        // 查看会员是否存在
        $memberInfo = M('Member')->find($id);

        if(!$memberInfo){

            $this->error('会员不存在');
            exit;
        }


        $personModel = M('Member as a');
        $row = $personModel->where(['id'=>$id])->find();

        //>> 查询消费情况(支持)

        $consume_1 = $personModel->field('a.username,b.support_money,b.create_time,b.order_number,c.name as cname')
            ->join('inner join an_member_support as b on a.id = b.member_id')
            ->join('inner join an_project as c on c.id = b.project_id')
            ->where(['a.id'=>$id])
            ->select();
        if(!empty($consume_1)){
            foreach($consume_1 as $key => &$value){
                $value['type'] = '电影支持';
                $value['money'] = $value['support_money'];
            }
            unset($value);
        }

        $consume_count_1 = ceil(count($consume_1) / 17);
        $consume_1 = $this->pagination($consume_1,$pgNum ? $pgNum : 1,$pgSize ? $pgSize :17);
        //>> 查询消费情况(当演员)
        $consume_2 = $personModel->field('b.*')
            ->join('inner join an_member_consume as b on a.id = b.member_id and b.type="演员申请"')
            ->where(['a.id'=>$id])
            ->select();


        if(isset($consume_2)){
            foreach($consume_2 as $key => &$value){
                $value['type'] = '演员申请';
            }
            unset($value);
        }
        $consume_count_2 = ceil(count($consume_2) / 17);
        $consume_2 = $this->pagination($consume_2,$pgNum ? $pgNum : 1,$pgSize ? $pgSize :17);

        //>> 投票记录
        $consume_3 = $personModel->field('a.username,b.*')
            ->join('inner join an_member_consume as b on a.id = b.member_id')
            ->where(['a.id'=>$id,'b.type'=>'投票'])
            ->select();
        foreach ($consume_3 as &$value){

            $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);

        }
        unset($value);
        $consume_count = ceil(count($consume_3) / 17);
        $consume_3 = $this->pagination($consume_3,$pgNum ? $pgNum : 1,$pgSize ? $pgSize :17);

        //>> 查最上级
        $topLeader = $row;



        //>> 所有收益
        $allGet = M('MemberProfit as a')->field('b.role,a.*')->join('left join an_member as b on a.member_id = b.id')->where(['a.member_id'=>$id,'a.type != 4'])->order('a.create_time desc')->select();

        foreach ($allGet as &$value){

            $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
            if($value['intro']== null){

                $value['intro'] = '';
            }


            switch ($value['type']){
                case 1:
                    $value['type'] = '分红';
                    break;
                case 2:
                    $value['type'] = '佣金';
                    break;
                case 3:
                    $value['type'] = '新增业绩';
                    if($value['role'] == 3){

                        $value['intro'] = '制片人三代外当月新增业绩：'.$value['money'] / 0.02.'，分红2%';
                    }
                    if($value['role'] == 4){

                        $value['intro'] = '出品人三代外当月新增业绩：'.$value['money'] / 0.04.'，分红4%';
                    }
                    break;
                case 4:
                    $value['type'] = '转入';
                    break;
                case 5:
                    $value['type'] = '管理员操作';
                    break;
                case 6:
                    $value['type'] = '收益补差';
                    break;
            }

        }
        unset($value);
        $allc = ceil(count($allGet) / 17);
        $allGet = $this->pagination($allGet,$pgNum ? $pgNum: 1,$pgSize ? $pgSize :17);

        $allGt = M('MemberProfit as a')->field('a.id,a.member_id,a.money,a.type,a.create_time,a.from_username')->join('left join an_member as b on a.member_id = b.id')->where(['a.member_id'=>$id,'a.type'=>4])->select();
        foreach ($allGt as &$value){
            $value['type'] = '转入';
            $value['money'] = '+'.$value['money'];
            $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
            $value['to_username'] = $value['from_username'];
        }
        unset($value);
        //>> 转账消费
        $allConsume = M('MemberConsume')->where(['member_id'=>$id,'type'=>'转出'])->select();

        foreach ($allConsume as &$value){

            $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
            $value['money'] = '-'.$value['money'];
        }
        unset($value);

        $allConsume = array_merge($allGt,$allConsume);



        $allcon = ceil(count($allConsume) / 17);
        $allConsume = $this->pagination($allConsume,$pgNum ? $pgNum : 1,$pgSize ? $pgSize :17);


        //>> 查询当前用户的支持情况
        $rows = M('MemberSupport as a')->field('a.id as aid,a.support_money,a.project_id,a.type as atype,a.float,a.fixed,b.*')
            ->join('left join an_project as b on a.project_id = b.id')
            ->where(['a.member_id'=>$id,'a.is_fh'=>0])
            ->select();

        foreach ($rows as &$value){
            $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);

        }
        unset($value);

        $count_1 = ceil(count($rows)/17);
        $rows = $this->pagination($rows,$pgNum,$pgSize);


        //>> 查询积分制度表
        $integral = M('IntegralInstitution')->select();

        //>> 查询提现
        $tiXian = M('MemberCash')->where(['member_id'=>$id])->select();

        //>> 将时间转换
        foreach ($tiXian as &$value){

            $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
        }

        unset($value);

        $countTixian = ceil(count($tiXian)/17);

        $tiXian = $this->pagination($tiXian,$pgNum,$pgSize);


        //>> 取出当前用户的积分
        $crrIntegral = $row['integral'];

        //>> 取出当前用户等级
        $crrLevel = $row['level'];

        //>> 取出积分表下一个等级对应的积分
        $allInfo = ['status'=>0,'integral'=>$row['integral']];
        foreach($integral as $key => $value){
            if($value['level'] == $crrLevel + 1 ){
                $expIntegral = $value['integral'];
                $allInfo['level'] = $value['level'];
                //>> 算出还需要多少积分
                $needIntegral = $expIntegral - $crrIntegral;
                $allInfo['integral'] = $needIntegral;
                $allInfo['status'] = 1;

            }
        }


        //>> 电影招募演员
        $films = M('ProjectRecruit')->select();


        //>> 查询收藏情况
        $collection = $personModel
            ->field('a.*,b.id as cid,c.*')
            ->join('left join an_member_collection as b on a.id = b.member_id')
            ->join('left join an_project as c on b.project_id = c.id')
            ->where(['member_id'=>$id])
            ->select();
        foreach($collection as $key => &$value){
            $value['date'] = date('Y-m-d',$value['showtime']);
            unset($value);
        }

        $collectionCount = ceil(count($collection)/4);
        $collectionList = $this->pagination($collection,1,4);

        $supportMoney = M('MemberSupport')->where(['member_id'=>$this->userInfo['id'],'is_true'=>0])->sum('support_money');


        //>> 查询提问
        $question = M('MemberConsult')->where(['member_id'=>$this->userInfo['id']])->select();

        //>> 支付方式
        $weixin = M('Pay')->where(['name'=>'微信'])->find();
        $ali = M('Pay')->where(['name'=>'支付宝'])->find();
        $yinlian = M('Pay')->where(['name'=>'公司银联'])->select();

        //>> 查询招募电影
        $recruit = M('ProjectRecruit')->select();

        //>> 查询我的下级
        $follower = M('Member')->where(['parent_id'=>$id])->select();

        //>> 查询充值订单
        $orderLst = M('MemberRecharge as a')->field('a.*,b.name as payname')
            ->join('left join an_pay as b on a.type = b.id')
            ->where(['a.member_id'=>$id,'a.is_pass'=>1])
            ->select();

        //>> 将时间转换
        foreach ($orderLst as &$value){

            $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);
            $value['payname'] = $value['payname'] ? $value['payname'] : '';
        }
        unset($value);

        $count = ceil(count($orderLst)/17);


        $orderList = $this->pagination($orderLst,$pgNum,$pgSize);

        if(IS_AJAX){

            $this->ajaxReturn([
                'count'=>$count,
                'orderList'=>$orderList,
                'tixian'=>$tiXian,
                'allget'=>$allGet,
                'touzi'=>$rows,
                'zhuanzhang'=>$allConsume
            ]);
        }

        $this->assign([
            'count_chongzhi'=>$count,
            'orderList'=>$orderList,
            'count_tixian'=>$countTixian,
            'count_touzi'=>$count_1,
        ]);

        //>> 账户安全等级
        $safePercent = [
            '1'=>'35%',
            '2'=>'65%',
            '3'=>'100%'
        ];
        $safeLevel = $safePercent[$row['safe_level']];
        //>> 组装电话号码
        $secretPhone = substr($row['username'],0,3).'****'.substr($row['username'],7,4);


        $this->assign([
            'allConsume'=>$allConsume,
            'weixin'=>$weixin,
            'yinlian'=>$yinlian,
            'ali'=>$ali,
            'films'=>$films,
            'allget'=>$allGet,
            'allc'=>$allc,
            'allcon'=>$allcon,
            'consume_count_1'=>$consume_count_1,
            'consume_count_2'=>$consume_count_2,
            'consume_count'=>$consume_count,
            'follower'=>$follower,
            'recruit'=>$recruit,
            'topLeader'=>$topLeader,
            'consume_3'=>$consume_3,
            'consume_2'=>$consume_2,
            'consume_1'=>$consume_1,
            'question'=>$question,
            'allInfo'=>$allInfo,
            'personal'=>$row,
            'collectionCount'=>$collectionCount,
            'collection'=>$collectionList,
            'safeLevel'=>$safeLevel,
            'count_1'=>$count_1,
            'supportSituation'=>$rows,
            'supportMoney'=>$supportMoney ? $supportMoney : 0.00,
            'secretPhone'=>$secretPhone,
            'tixian'=>$tiXian
        ]);

        $this->display('sum/index');
    }


    /**
     * 导出收益
     */

    public function exportSy(){


        $where = [];
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
        $id = I('get.username');
        $user = M('Member')->where(['id'=>$id])->find();
        if($start_time){
            $where['a.create_time'] = ['egt',$start_time];
        }
        if($start_time && $end_time ){
            $where['a.create_time'] = [
                ['egt',$start_time],
                ['elt',$end_time]
            ];
        }
        if($id){

            $where['a.member_id'] = $id;
        }

        $where['a.type'] = ['neq',4];

        $rows = M('MemberProfit as a')->field('a.*,b.username,b.role')->join('left join an_member as b on b.id = a.member_id')->where($where)->order('create_time desc')->select();


        foreach ($rows as &$info){
            switch ($info['type']){
                case 1:
                    $info['type'] = '分红';
                    break;
                case 2:
                    $info['type'] = '佣金';
                    break;
                case 3:
                    $info['type'] = '新增业绩';
                    if($info['role'] == 3){

                        $info['intro'] = '制片人三代外当月新增业绩：'.$info['money'] / 0.02.'，分红2%';
                    }
                    if($info['role'] == 4){

                        $info['intro'] = '出品人三代外当月新增业绩：'.$info['money'] / 0.04.'，分红4%';
                    }
                    break;
                case 4:
                    $info['type'] = '转入';
                    break;
                case 5:
                    $info['type'] = '管理员操作';
                    break;
                case 6:
                    $info['type'] = '收益补差';
                    break;
            }
            if($info['is_ok'] == 0){
                $info['is_ok'] = '失效';
                $info['money'] = '-'.$info['money'];
            }else{
                $info['is_ok'] = '正常';
                $info['money'] = '+'.$info['money'];
            }

            $info['create_time'] = date('Y-m-d',$info['create_time']);
        }
        unset($info);

        $xlsCell  = array(
            array('id','编号'),
            array('username','会员 '),
            array('money','金额'),
            array('remark','来源'),
            array('intro','备注'),
            array('is_ok','状态'),
            array('from_username','转入账号'),
            array('create_time','时间'),
        );

        $this->exportExcel(date('Y-m-d').'会员'.$user['username'].'_收益',$xlsCell,$rows);
    }

}