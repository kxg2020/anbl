<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Page;

class MemberController extends  CommonController{

    public function _initialize(){
        parent::_initialize();
        // 检测用户是否登录，没有登录不能继续执行
        if(!$this->isLogin){
            $this->redirect('admin/login/index');
            exit;
        }
    }

    /**
     * 查询会员
     */
    public function select(){

        $paramArr = $_REQUEST;
        $where = [];
        if($paramArr['username']){

            $where['username'] = $paramArr['username'];
        }
        if($paramArr['level']){

            $where['level'] = $paramArr['level'];
        }
        if($paramArr['money']){

            $where['money'] = $paramArr['money'];
        }
        if($paramArr['start_time']){

            $where['create_time'] = ['egt',$paramArr['start_time']];
        }
        if($paramArr['end_time']){

            $where['create_time'] = ['elt',$paramArr['end_time']];
        }

        $count = M('Member')->where($where)->order('create_time desc ')->count();

        $page = new Page($count,15);

        $memberList = M('Member')->where($where)->order('create_time desc ')->limit($page->firstRow,$page->listRows)->select();

        $pages = $page->show();
        $this->assign('list',$memberList);
        $this->assign('count',$count);
        $this->assign('pages',$pages);
        $this->display('member/index');
    }

    /**
     * 添加会员
     */

    public function addMember(){

        $paramArr = $_REQUEST;
        if(IS_POST){
            if(!empty($paramArr)){
                //>> 生成一个推荐码
                $str = '012345679ABCDEFGHJKMNPQRSTUZabcdefghjkmnpqrstuz';
                $strArr = str_split($str);
                shuffle($strArr);
                //>> 截取8位
                $endArr = array_slice($strArr,0,7);

                $invite_key = implode('',$endArr);
                if(isset($paramArr['username']) && !empty($paramArr['username'])){

                    //>> 查询用户是否已经添加过
                    $row = M('Member')->where(['username'=>$paramArr['username']])->find();
                    if(!empty($row)){
                        $this->ajaxReturn([
                            'status'=>0,
                            'msg'=>'用户已经注册过了'
                        ]);
                    }
                    //>> 查询积分制度表
                    $level = 0;
                    $integral = M('IntegralInstitution')->select();
                    foreach($integral as $key => $value){
                        if($value['integral'] == $paramArr['money']){
                            $level = $value['level'];
                            $integral = $value['integral'];
                        }
                    }

                    $insertData = [
                        'username'=>$paramArr['username'],
                        'last_ip'=>get_client_ip(),
                        'password'=>md5($paramArr['password']),
                        'money'=>$paramArr['money'] ? $paramArr['money'] : 0,
                        'integral'=>$integral,
                        'create_time'=>time(),
                        'is_allowed_recharge'=>1,
                        'invite_key'=>$invite_key,
                        'parent_id'=>0,
                        'level'=>$level,
                        'safe_level'=>1,
                        'class'=>0
                    ];

                    $res = M('Member')->add($insertData);
                    if($res){

                        $this->ajaxReturn([
                            'status'=>1,
                            'msg'=>'添加成功!'
                        ]);
                    }else{
                        $this->ajaxReturn([
                            'status'=>0,
                            'msg'=>'添加失败!'
                        ]);
                    }
                }else{
                    $this->ajaxReturn([
                        'status'=>0,
                        'msg'=>'用户名不能为空'
                    ]);
                }
            }else{
                $this->ajaxReturn([
                    'status'=>0,
                    'msg'=>'会员信息不能为空!'
                ]);
            }
        }else{

            //>> 查询升级规则
            $institution = M('IntegralInstitution')->select();
            $this->assign('integral',$institution);
            $this->display('member/add');
        }
    }

    /**
     * 分页方法
     */
    public function pagination($data = [],$pgNum = '',$pgSize = ''){
        if(empty($data)){

            return false;
        }

        $start = ($pgNum - 1)*$pgSize;

        $sliceArr = array_slice($data,$start,$pgSize,true);

        return $sliceArr;
    }

    /**
     * 会员详情
     */
    public function detail(){

        $paramArr = $_REQUEST;
        $memberModel = M('Member');

        //>> 查询数据库
        $res = $memberModel->where(['id'=>$paramArr['id'],'is_active'=>1])->find();
        if(!empty($res)){

            $res['date'] = date('Y-m-d',$res['create_time']);

            //>> 分配数据
            $this->assign('detail',$res);

            $this->display('member/detail');

        }else{

            return;

        }
    }

    /**
     * 编辑保存
     */
    public function save(){

        $paramArr = $_REQUEST;
        $memberModel = M('Member');

        //>> 保存数据
        if(!empty($paramArr)){
            $data = [
                'password'=>md5($paramArr['password']),
                'level'=>$paramArr['level'],
                'integral'=>$paramArr['integral'],
                'money'=>$paramArr['money'],
                'phone'=>$paramArr['phone'],
                'realname'=>$paramArr['realname'],
                'bank_card_name'=>$paramArr['bank_card_name'],
                'address'=>$paramArr['address'],
                'city'=>$paramArr['city'],
            ];
            $res = $memberModel->where(['id'=>$paramArr['id']])->save($data);

            if($res){

                $this->redirect('admin/member/select');

            }else{

                $this->error('保存失败');

            }

        }

    }

    /**
     * 删除会员
     */
    public function delete(){

        $paramArr = $_REQUEST;

        if(isset($paramArr['id']) && !empty($paramArr['id']) && is_numeric($paramArr['id'])){

            $res = M('Member')->where(['id'=>$paramArr['id']])->delete();
            if($res){

                $this->ajaxReturn([
                    'status'=>1
                ]);

            }else{

                $this->ajaxReturn([
                    'status'=>0
                ]);

            }
        }else{

            return false;
        }
    }

    /**
     * 积分制度
     */
    public function integral(){

        if(IS_POST){
            $paramArr = $_REQUEST;
            //>> 开启事物
            $model = M('IntegralInstitution');
            //>> 更新积分数据库
            if(!empty($paramArr)){
                foreach($paramArr['integral'] as $key => $value){
                    $data = [
                        'level'=>$key,
                        'integral'=>$value
                    ];
                    $model->where(['level'=>$data['level']])->save($data);
                }
            }else{
                $this->ajaxReturn(['msg'=>'数据不能为空','status'=>0]);
            }
        }else{

            $rows = M('IntegralInstitution')->select();
            $this->assign('row',$rows);
            $this->display('member/integral');
        }
    }

    /**
     * 充值权限
     */

    public function status(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){
            $status = $paramArr['c_id'] ^ 1;
            $res = M('Member')->where(['id'=>$paramArr['id']])->save(['is_allowed_recharge'=>$status]);
            if($res != 0){
                $this->ajaxReturn([
                    'status'=>1,
                    'msg'=>'修改成功'
                ]);
            }else{
                $this->ajaxReturn([
                    'status'=>0,
                ]);
            }
        }else{
            $this->ajaxReturn([
                'status'=>0,
                'msg'=>'修改失败'
            ]);
        }
    }

    /**
     * 会员问答
     */
    public function question(){

        $where = [];

        $paramArr = $_REQUEST;
        if($paramArr['username']){
            $user = M('Member')->where(['username'=>$paramArr['username']])->find();
            $where['a.member_id'] = $user['id'];
        }

        if($paramArr['start_time']){

            $where['a.create_time'] = ['egt',strtotime($paramArr['start_time'])];
        }

        $count = M('MemberConsult as a')->field('a.*,b.username')
                ->join('left join an_member as b on a.member_id = b.id')
                ->where($where)
                ->count();

        $page = new Page($count,15);
        $rows = M('MemberConsult as a')->field('a.*,b.username')
            ->join('left join an_member as b on a.member_id = b.id')
            ->where($where)
            ->limit($page->firstRow,$page->listRows)
            ->select();
        $pages = $page->show();
        $this->assign('question',$rows);
        $this->assign('pages',$pages);
        $this->assign('count',$count);
        $this->display('member/question');
    }

    /**
     * 问题详情
     */

    public function questionDetail(){

        $paramArr = $_REQUEST;

        $row = M('MemberConsult as a')->field('a.*,b.username')->join('left join an_member as b on a.member_id = b.id')->where(['a.id'=>$paramArr['id']])->find();

        $this->assign('question',$row);
        $this->display('member/single');
    }

    /**
     * 问题回复
     */
    public function questionReply(){

        $paramArr = $_REQUEST;

        //>>更新
        $updateData = [
            'status'=>1,
            'reply'=>$paramArr['reply'],
        ];

         M('MemberConsult')->where(['id'=>$paramArr['id']])->save($updateData);

        $this->ajaxReturn([
            'status'=>1
        ]);
    }

    /**
     * 会员搜索
     */
    public function memberSearch(){







    }
}