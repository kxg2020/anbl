<?php
namespace Admin\Controller;

use Think\Page;

class CountController extends CommonController
{
    /**
     * 影片统计
     */
    public function projectCount(){
        // 统计上架影片数量
        $projectNum = M('Project')->where(['is_active'])->count();
        $this->assign('projectNum', $projectNum);

        // 统计影片总数
        $num = M('Project')->count();
        $this->assign('num', $num);

        // 查询影片信息
        //查看是否有查询
        $name = I('get.name','','strip_tags');

        // 创建查询条件
        $where =[];
        if($name){
            $where['name'] = ['like',"%$name%"];
        }

        // 查询总记录数
        $count =  M('project')->where($where)->count();

        // 实列化一个分页工具类
        $page = new Page($count,5);

        $rows = M('project')
            ->where($where)
            ->limit($page->firstRow, $page->listRows)
            ->order('id')
            ->select();
        // 生成分页DOM结构
        $pages = $page->show();
        // 向模板分配分页条
        $this->assign('pages',$pages);
        $this->assign('projectInfos',$rows);

        $this->display('project');
    }

    /**
     * 销售数据统计
     */
    public function payCount(){

        // 会员累计下载金额
        $dlMoney = M('MemberDownload')->sum('money');
        $this->assign('dlMoney',$dlMoney);
        // 会员累计支持金额
        $spMoney = M('MemberSupport')->sum('support_money');
        $this->assign('spMoney',$spMoney);

       //查看是否有查询
        $name = I('get.name','','strip_tags');
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
        // 创建查询条件
        $where =[];
        if($name){
            $where['b.name'] = ['like',"%$name%"];
        }

        if($start_time){
            $where['a.create_time'] = ['egt',$start_time];
        }
        if($end_time){
            $where['a.create_time'] = ['elt',$end_time];
        }

        // 统计具体项目的累计支持金额
        $support = M('MemberSupport as a')
            ->field('sum(a.support_money) as money,a.id,b.name,b.image_url')
            ->join('left join an_project as b on b.id=a.project_id')
            ->where($where)
            ->group('a.project_id')
            ->select();
        $this->assign('support',$support);

        // 统计具体项目的累计下载金额
        $download = M('MemberDownload as a')
            ->field('sum(a.money) as money,a.id,b.name,b.image_url')
            ->join('left join an_project as b on b.id=a.project_id')
            ->where($where)
            ->group('a.project_id')
            ->select();
        $this->assign('download',$download);

        $this->display('pay');
    }


    /**
     * 财务数据统计
     */
    public function financeCount(){
        //查看是否有查询
        $start_time = strtotime(I('get.start_time'));//统计开始时间
        $end_time = strtotime(I('get.end_time'));//统计结束时间
        // 创建查询条件
        $where =[];
        if($start_time){
            $where['create_time'] = ['egt',$start_time];
        }
        if($start_time && $end_time ){
            $where['create_time'] = [
                ['egt',$start_time],
                ['elt',$end_time]
            ];
        }

        //统计会员充值金额
        $amoney = M('MemberRecharge')->where(array_merge($where,['is_pass'=>1]))->sum('money');
        $this->assign('amoney',$amoney);
        //统计会员提现金额
        $bmoney = M('MemberCash')->where(array_merge($where,['is_pass'=>1]))->sum('money');
        $this->assign('bmoney',$bmoney);
        //统计会员分红金额
        $cmoney = M('MemberProfit')->where(array_merge($where,['type'=>1]))->sum('money');
        $this->assign('cmoney',$cmoney);
        //统计会员分佣金额
        $dmoney = M('MemberProfit')->where(array_merge($where,['type'=>2]))->sum('money');
        $this->assign('dmoney',$dmoney);

        $this->display('finance');
    }
}