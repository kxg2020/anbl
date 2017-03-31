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
    public function exportDataSupport(){

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
        $rows = M('MemberSupport as a')
            ->field('a.*,b.name as project_name,c.username')
            ->join('left join an_project as b on b.id=a.project_id')
            ->join('left join an_member as c on c.id=a.member_id')
            ->where($where)
            ->select();
        foreach ($rows as &$info){
            $info['create_time'] = date('Y-m-d',$info['create_time']);
        }
        unset($info);

        $xlsCell  = array(
            array('id','编号'),
            array('order_number','订单号'),
            array('username','支持用户'),
            array('project_name','支持项目'),
            array('support_money','支持金额'),
            array('create_time','支持时间'),
        );

        $this->exportExcel(date('Y-m-d').'_支持订单',$xlsCell,$rows);

    }
}