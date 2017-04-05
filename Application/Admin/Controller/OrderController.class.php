<?php
namespace Admin\Controller;

use Think\Page;

class OrderController extends CommonController
{
    /**
     * 下载订单
     */

    public function downloadOrder(){

        $where = [];
        $order_number = I('get.order_number','','strip_tags');
        $username = I('get.username','','strip_tags');
        $name = I('get.project_name','','strip_tags');
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
        if($order_number){
            $where['a.order_number'] = ['like',"%$order_number%"];
        }
        if($username){
            $where['c.username'] = ['like',"%$username%"];
        }
        if($name){
            $where['b.name'] = ['like',"%$name%"];
        }
        if($start_time){
            $where['a.create_time'] = ['egt',$start_time];
        }
        if($end_time){
            $where['a.create_time'] = ['elt',$end_time];
        }
        // 查询总记录数
        $count =   M('MemberDownload as a')
            ->field('a.*,b.name as project_name,c.username')
            ->join('left join an_project as b on b.id=a.project_id')
            ->join('left join an_member as c on c.id=a.member_id')
            ->where($where)
            ->count();
        // 实列化一个分页工具类
        $page = new Page($count,15);

        //查询出所有下载订单
        $rows = M('MemberDownload as a')
            ->field('a.*,b.name as project_name,c.username')
            ->join('left join an_project as b on b.id=a.project_id')
            ->join('left join an_member as c on c.id=a.member_id')
            ->where($where)
            ->limit($page->firstRow,$page->listRows)
            ->select();

        // 生成分页DOM结构
        $pages = $page->show();
        // 向模板分配分页条
        $this->assign('pages',$pages);
        $this->assign('count',$count);
        $this->assign('rows',$rows);
        $this->display('download');
    }

    /**
     * 导出下载订单列表
     */
    public function exportData(){

        $where = [];
        $order_number = I('get.order_number','','strip_tags');
        $username = I('get.username','','strip_tags');
        $name = I('get.project_name','','strip_tags');
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
        if($order_number){
            $where['a.order_number'] = ['like',"%$order_number%"];
        }
        if($username){
            $where['c.username'] = ['like',"%$username%"];
        }
        if($name){
            $where['b.name'] = ['like',"%$name%"];
        }
        if($start_time){
            $where['a.create_time'] = ['egt',$start_time];
        }
        if($end_time){
            $where['a.create_time'] = ['elt',$end_time];
        }

        //查询出所有下载订单
        $rows = M('MemberDownload as a')
            ->field('a.*,b.name as project_name,c.username')
            ->join('left join an_project as b on b.id=a.project_id')
            ->join('left join an_member as c on c.id=a.member_id')
            ->where($where)
            ->select();
        foreach ($rows as &$info){
            if($info['money'] == 0){
                $info['money'] = "免费下载";
            }
            $info['create_time'] = date('Y-m-d',$info['create_time']);
        }
        unset($info);

        $xlsCell  = array(
            array('id','编号'),
            array('order_number','订单号'),
            array('username','下载用户'),
            array('project_name','下载项目'),
            array('money','下载金额'),
            array('create_time','下载时间'),
        );

        $this->exportExcel(date('Y-m-d').'_下载订单',$xlsCell,$rows);

    }

    /**
     * 支持订单
     */
    public function supportOrder(){
        $where = [];
        $order_number = I('get.order_number','','strip_tags');
        $username = I('get.username','','strip_tags');
        $name = I('get.project_name','','strip_tags');
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
        if($order_number){
            $where['a.order_number'] = ['like',"%$order_number%"];
        }
        if($username){
            $where['c.username'] = ['like',"%$username%"];
        }
        if($name){
            $where['b.name'] = ['like',"%$name%"];
        }
        if($start_time){
            $where['a.create_time'] = ['egt',$start_time];
        }
        if($end_time){
            $where['a.create_time'] = ['elt',$end_time];
        }
        // 查询总记录数
        $count =   M('MemberSupport as a')
            ->field('a.*,b.name as project_name,c.username')
            ->join('left join an_project as b on b.id=a.project_id')
            ->join('left join an_member as c on c.id=a.member_id')
            ->where($where)
            ->count();
        // 实列化一个分页工具类
        $page = new Page($count,15);

        //查询出所有下载订单
        $rows = M('MemberSupport as a')
            ->field('a.*,b.name as project_name,c.username')
            ->join('left join an_project as b on b.id=a.project_id')
            ->join('left join an_member as c on c.id=a.member_id')
            ->where($where)
            ->order('a.create_time desc')
            ->limit($page->firstRow,$page->listRows)
            ->select();

        // 生成分页DOM结构
        $pages = $page->show();
        // 向模板分配分页条
        $this->assign('pages',$pages);
        $this->assign('count',$count);
        $this->assign('rows',$rows);
        $this->display('support');
    }

    /**
     * 导出支持订单列表
     */
    public function exportDataSupport()
    {

        $where = [];
        $order_number = I('get.order_number', '', 'strip_tags');
        $username = I('get.username', '', 'strip_tags');
        $name = I('get.project_name', '', 'strip_tags');
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
        if ($order_number) {
            $where['a.order_number'] = ['like', "%$order_number%"];
        }
        if ($username) {
            $where['c.username'] = ['like', "%$username%"];
        }
        if ($name) {
            $where['b.name'] = ['like', "%$name%"];
        }
        if ($start_time) {
            $where['a.create_time'] = ['egt', $start_time];
        }
        if ($end_time) {
            $where['a.create_time'] = ['elt', $end_time];
        }

        //查询出所有下载订单
        $rows = M('MemberSupport as a')
            ->field('a.*,b.name as project_name,c.username')
            ->join('left join an_project as b on b.id=a.project_id')
            ->join('left join an_member as c on c.id=a.member_id')
            ->where($where)
            ->select();
        foreach ($rows as &$info) {
            $info['create_time'] = date('Y-m-d', $info['create_time']);
        }
        unset($info);

        $xlsCell = array(
            array('id', '编号'),
            array('order_number', '订单号'),
            array('username', '支持用户'),
            array('project_name', '支持项目'),
            array('support_money', '支持金额'),
            array('create_time', '支持时间'),
        );

        $this->exportExcel(date('Y-m-d') . '_支持订单', $xlsCell, $rows);
    }


    /**
     * 充值订单
     */
    public function recharge(){

        $paramArr = $_REQUEST;

        $where = [
            'is_pass'=>0
        ];
        if(!empty($paramArr['order_number'])){
            $where = [
                'order_number'=>$paramArr['order_number']
            ];
        }
        if(!empty($paramArr['type'])){
            $where = [
                'is_pass'=>$paramArr['type']
            ];
        }

        //>> 查询充值订单
        $orderLst = M('Member_recharge as a')->field('a.*,b.username')
                ->join('left join an_member as b on a.member_id = b.id')
                ->where($where)->select();

        if(isset($paramArr['pgNum']) && !empty($paramArr['pgNum']) && is_numeric($paramArr['pgNum'])){
            $pgNum = $paramArr['pgNum'];
        }else{
            $pgNum = 1;
        }
        if(isset($paramArr['pgSize']) && !empty($paramArr['pgSize']) && is_numeric($paramArr['pgSize'])){
            $pgSize = $paramArr['pgSize'];
        }else{
            $pgSize = 15;
        }
        $count = ceil(count($orderLst)/$pgSize);
        $orderList = $this->pagination($orderLst,$pgNum,$pgSize);

        if(IS_AJAX){
            $this->ajaxReturn([
                'data'=>array_values($orderList),
                'status'=>1,
                'count'=>$count
            ]);
        }

        $this->assign('order',$orderList);
        $this->assign('count',$count);
        $this->display('order/recharge');

    }

    /**
     * 分页
     */
    public function pagination($data = [],$phNum,$pgSize){

        if(empty($data))return false;

        $start = ($phNum - 1) * $pgSize;

        $sliceArr = array_slice($data,$start,$pgSize);

        return  $sliceArr;
    }

    /**
     * 提现订单
     */
    public function cash(){

        $where = [];
        $order_number = I('get.order_number','','strip_tags');
        $username = I('get.username','','strip_tags');
        $money = I('get.money','','strip_tags');
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
        if($order_number){
            $where['a.order_number'] = ['like',"%$order_number%"];
        }
        if($username){
            $user = M('Member')->where(['username'=>$username])->find();
            $id = $user['id'];
            $where['a.member_id'] = ['like',"%$id%"];
        }
        if($money){
            $where['a.money'] = ['like',"%$money%"];
        }
        if($start_time){
            $where['a.create_time'] = ['egt',$start_time];
        }
        if($end_time){
            $where['a.create_time'] = ['elt',$end_time];
        }

        // 查询总记录数
        $count =   M('MemberCash as a')
            ->field('a.*,b.username')
            ->join('left join an_member as b on a.member_id = b.id')
            ->where($where)
            ->count();

        // 实列化一个分页工具类
        $page = new Page($count,15);

        //查询出所有下载订单
        $rows = M('MemberCash as a')
            ->field('a.*,b.username')
            ->join('left join an_member as b on a.member_id = b.id')
            ->where($where)
            ->limit($page->firstRow,$page->listRows)
            ->select();

        // 生成分页DOM结构
        $pages = $page->show();
        // 向模板分配分页条
        $this->assign('pages',$pages);
        $this->assign('count',$count);
        $this->assign('order',$rows);
        $this->display('order/cash');
    }


    /**
     * 导出提现订单
     */
    public function exportDataCash(){

        $where = [];
        $order_number = I('get.order_number','','strip_tags');
        $username = I('get.username','','strip_tags');
        $money = I('get.money','','strip_tags');
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
        if($order_number){
            $where['a.order_number'] = ['like',"%$order_number%"];
        }
        if($username){
            $user = M('Member')->where(['username'=>$username])->find();
            $id = $user['id'];
            $where['a.member_id'] = ['like',"%$id%"];
        }
        if($money){
            $where['a.money'] = ['like',"%$money%"];
        }
        if($start_time){
            $where['a.create_time'] = ['egt',$start_time];
        }
        if($end_time){
            $where['a.create_time'] = ['elt',$end_time];
        }


        //查询出所有下载订单
        $rows = M('MemberCash as a')
            ->field('a.*,b.username')
            ->join('left join an_member as b on a.member_id = b.id')
            ->where($where)
            ->select();
        foreach ($rows as &$info) {
            $info['create_time'] = date('Y-m-d', $info['create_time']);
        }
        unset($info);

        $xlsCell = array(
            array('id', '编号'),
            array('order_number', '订单号'),
            array('username', '提现用户'),
            array('money', '提现金额'),
            array('create_time', '提现时间'),
            array('is_pass', '状态'),
        );
        $this->exportExcel(date('Y-m-d') . '_提现订单', $xlsCell, $rows);
    }

    /**
     * 充值详情
     */
    public function detail(){

        $paramArr =$_REQUEST;

        $res = [];
        if(isset($paramArr['id']) && !empty($paramArr['id']) && is_numeric($paramArr['id'])){
            //>> 查询数据库
            $res = M('MemberRecharge')->where(['id'=>$paramArr['id']])->find();
            $row = M('Member')->where(['id'=>$res['member_id']])->find();
            $res['username'] = $row['username'];
        }

        $this->assign('detail',$res);
        $this->display('order/detail');
    }

    /**
     * 删除
     */
    public function delete(){
        $paramArr = $_REQUEST;
        if(!empty($paramArr)){
            $id = $paramArr['id'];
            $res = M('MemberCash')->where(['id'=>$id])->delete();
            if($res){

                $this->ajaxReturn(['status'=>1,'msg'=>'删除成功!']);
            }else{
                $this->ajaxReturn(['status'=>1,'msg'=>'删除失败!']);
            }
        }
    }

    /**
     * 通过审核
     */
    public function pass(){

        $paramArr = $_REQUEST;
        if(!empty($paramArr)){

            if(isset($paramArr['id']) && !empty($paramArr['id']) && is_numeric($paramArr['id'])){

                $row = M('MemberRecharge')->where(['id'=>$paramArr['id']])->find();

                $user = M('Member')->where(['id'=>$row['member_id']])->find();

                //>> 查询积分规则表
                $ins = M('IntegralInstitution')->select();
                $newLevel = $user['level'];
                foreach($ins as $key => $value){
                    //>> 取出当前等级下一级所对应的积分
                    if($paramArr['money'] + $user['money'] >= $value['integral'] && $user['integral'] + $paramArr['money'] >= $value['integral'] ){
                        $newLevel = $value['level'];
                    }
                }
                M('Member')->where(['id'=>$row['member_id']])->save([
                    'money'=>$user['money'] + $paramArr['money'],
                    'integral'=>$user['integral'] + $paramArr['money'],
                    'level'=>$newLevel,
                ]);

                //>> 查询数据库,审核通过，余额和积分
                $res = M('MemberRecharge')->where(['id'=>$paramArr['id']])->save([
                    'is_pass'=>1,
                ]);

                if($res){

                    $this->ajaxReturn(['status'=>1]);

                }else{

                    $this->ajaxReturn(['status'=>0]);
                }

            }else{

                $this->ajaxReturn(['status'=>0]);
            }
        }
    }

    /**
     * 充值订单(用tp自带分页)
     */

    public function orderRecharge(){

        $paramArr = $_REQUEST;

        $where = [];
       if(!empty($paramArr)){
           //>> 查询记录
           if(!empty($paramArr['order_number'])){
               $where['a.order_number'] = $paramArr['order_number'];
           }
           if(!empty($paramArr['username'])){
               $user = M('Member')->where(['username'=>$paramArr['username']])->find();
               $where['a.member_id'] = $user['id'];
           }
           if(!empty($paramArr['money'])){

               $where['a.money'] = $paramArr['money'];
           }
           if(!empty($paramArr['start_time'])){
               $where['a.create_time'] = ['egt',strtotime($paramArr['start_time'])];
           }
           if(!empty($paramArr['end_time'])){
               $where['a.create_time'] = ['elt',strtotime($paramArr['end_time'])];
           }


       }

        $count = M('MemberRecharge as a ')
            ->field('a.*,b.username')
            ->join('left join an_member as b on a.member_id = b.id')
            ->where($where)
            ->count();

        // 实列化一个分页工具类
        $page = new Page($count,15);
        $rows = M('MemberRecharge as a ')->field('a.*,b.username')
            ->where($where)
            ->join('left join an_member as b on a.member_id = b.id')
            ->limit($page->firstRow, $page->listRows)
            ->select();

        // 生成分页DOM结构
        $pages = $page->show();
        // 向模板分配分页条
        $this->assign('pages',$pages);
        $this->assign('order',$rows);
        $this->assign('count',$count);
        $this->display('order/recharge');
    }

    /**
     * 导出支持订单列表
     */
    public function exportDataRecharge()
    {

        $where = ['1=1'];
        $order_number = I('get.order_number', '', 'strip_tags');
        $username = I('get.username', '', 'strip_tags');
        $money = I('get.money', '', 'strip_tags');
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
        if ($order_number) {
            $where['a.order_number'] = ['like', "%$order_number%"];
        }
        if ($username) {
            $where['a.username'] = ['like', "%$username%"];
        }
        if ($money) {
            $where['a.money'] = ['like', "%$money%"];
        }
        if ($start_time) {
            $where['a.create_time'] = ['egt', $start_time];
        }
        if ($end_time) {
            $where['a.create_time'] = ['elt', $end_time];
        }

        //查询出所有下载订单
        $rows = M('MemberRecharge as a')
            ->field('a.*,b.username')
            ->join('left join an_member as b on a.member_id = b.id')
            ->where($where)
            ->select();
        foreach ($rows as &$info) {
            $info['create_time'] = date('Y-m-d', $info['create_time']);
        }
        unset($info);

        $xlsCell = array(
            array('id', '编号'),
            array('order_number', '订单号'),
            array('username', '充值用户'),
            array('money', '充值金额'),
            array('create_time', '支持时间'),
            array('is_pass', '状态'),
        );
        $this->exportExcel(date('Y-m-d') . '_充值订单', $xlsCell, $rows);
    }

    /**
     * 提现订单(tp自带分页)
     */
}
