<?php
namespace Admin\Controller;

use Think\Page;

class OrderController extends CommonController{
    //下载订单
    public function downloadOrder(){

        // 查询总记录数
        $count =  M('project as a')
            ->field('a.*, b.story,c.name as type')
            ->join('LEFT JOIN an_project_survey as b ON a.id=b.project_id')
            ->join('LEFT JOIN an_project_category as c ON c.id=a.type_id')
            ->count();

        // 实列化一个分页工具类
        $page = new Page($count,10);

        //查询出所有下载订单
        $rows = M('MemberDownload as a')
            ->field('a.*,b.name as project_name,c.username')
            ->join('left join an_project as b on b.id=a.project_id')
            ->join('left join an_member as c on c.id=a.member_id')
            ->limit($page->firstRow,$page->listRows)
            ->select();

        // 生成分页DOM结构
        $pages = $page->show();
        // 向模板分配分页条
        $this->assign('pages',$pages);
        $this->assign('rows',$rows);
        $this->display('download');
    }


    /**
     * 充值订单
     */
    public function recharge(){

        $paramArr = $_REQUEST;


        if(!empty($paramArr['order_number'])){
            $where = [
                'order_number'=>$paramArr['order_number']
            ];
        }else{
            $where = [
                '1=1'
            ];
        }
        //>> 查询充值订单
        $orderLst = M('Member_recharge as a')->field('a.*,b.username')
                ->join('left join an_member as b on a.member_id = b.id')
                ->where($where)->select();


        $count = ceil(count($orderLst)/15);

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

        $orderList = $this->pagination($orderLst,$pgNum,$pgSize);

        if(IS_AJAX){
            $this->ajaxReturn([
                'data'=>array_values($orderList),
                'status'=>1
            ]);
            exit;
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
     * 通过审核
     */
    public function pass(){

        $paramArr = $_REQUEST;
        if(!empty($paramArr)){

            if(isset($paramArr['id']) && !empty($paramArr['id']) && is_numeric($paramArr['id'])){
                //>> 查询数据库
                $res = M('MemberRecharge')->where(['id'=>$paramArr['id']])->save(['is_pass'=>1]);

                if($res != 0){

                    $this->ajaxReturn(['status'=>1]);

                }else{

                    $this->ajaxReturn(['status'=>0]);
                }

            }else{

                $this->ajaxReturn(['status'=>0]);
            }
        }
    }
}