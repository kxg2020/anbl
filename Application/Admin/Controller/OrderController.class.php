<?php
namespace Admin\Controller;

use Think\Page;

class OrderController extends CommonController
{
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
}