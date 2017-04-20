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
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
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
        if($start_time){
            $where['create_time'] = ['egt',$start_time];
        }
        if($start_time && $end_time ){
            $where['create_time'] = [
                ['egt',$start_time],
                ['elt',$end_time]
            ];
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
     * 导出下载订单列表
     */
    public function exportDataMember(){

        $paramArr = $_REQUEST;
        $start_time = strtotime(I('get.start_time'));
        $end_time = strtotime(I('get.end_time'));
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

        if($start_time){
            $where['create_time'] = ['egt',$start_time];
        }
        if($start_time && $end_time ){
            $where['create_time'] = [
                ['egt',$start_time],
                ['elt',$end_time]
            ];
        }

        $count = M('Member')->where($where)->order('create_time desc ')->count();

        $page = new Page($count,15);

        $memberList = M('Member')->where($where)->order('create_time desc ')->limit($page->firstRow,$page->listRows)->select();
        foreach ($memberList as &$info){
            $info['create_time'] = date('Y-m-d',$info['create_time']);
        }
        unset($info);

        $xlsCell  = array(
            array('id','编号'),
            array('username','账户'),
            array('money','余额'),
            array('phone','电话'),
            array('create_time','加入时间'),
        );

        $this->exportExcel(date('Y-m-d').'_会员信息',$xlsCell,$memberList);

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
                'level'=>isset($paramArr['level']) ? $paramArr['level'] : 0,
                'integral'=>isset($paramArr['integral']) ? $paramArr['integral'] : 0,
                'money'=>isset($paramArr['money']) ? $paramArr['money'] : 0,
                'phone'=>isset($paramArr['phone']) ? $paramArr['phone'] : '',
                'realname'=>isset($paramArr['realname']) ? $paramArr['realname'] : '',
                'bank_card_name'=>isset($paramArr['bank_card_name']) ? $paramArr['bank_card_name'] : '',
                'address'=>isset($paramArr['address']) ? $paramArr['city'] : '',
                'city'=>isset($paramArr['city']) ? $paramArr['city'] : '',
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

                   $re =  $model->where(['level'=>$key])->save(['integral'=>$value]);
                    
                }
                $this->ajaxReturn(['msg'=>'保存成功','status'=>1]);
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
        if($paramArr['id']){

            $where['a.id'] = $paramArr['id'];
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
     * 明星会员
     */
    public function memberStar(){


        $paramArr = $_REQUEST;
        $where = [];
        if($paramArr['name']){
            $where['name'] = $paramArr['name'];
        }
        //>> 查询明星会员
        $rows = M('MemberStar')->where($where)->count();

        $page = new Page($rows,15);

        $rows = M('MemberStar as a')->field('a.*,b.name as rolename,c.name as filmname')
            ->join('left join an_project_role as b on a.role_id = b.id')
            ->join('left join an_project_recruit as c on a.project_id = c.id')
            ->where($where)
            ->limit($page->firstRow,$page->listRows)->select();

        $pages = $page->show();

        $this->assign('star',$rows);
        $this->assign('pages',$pages);
        $this->display('member/star');


    }

    public function memberStarDetail(){


        $id = $_REQUEST['id'];
        //>> 查询明星会员


        $row = M('MemberStar')->where(['id'=>$id])->find();
        $row['image_url'] = explode(',',$row['image_url']);


        $this->assign('star',$row);

        $this->display('member/details');


    }

    /**
     * 发送邮件
     */
    public function sendEmail($toEmail, $subject, $body){
        vendor('PHPMailer.PHPMailerAutoload');
        $mail = new \PHPMailer;
        $mail->isSMTP(); // 设置使用SMTP服务器发送邮件
        $mail->Host = $this->systemInfo['send_mail_server'];  // 设置SMTP服务器地址
        $mail->SMTPAuth = true;  // 使用SMTP的授权规则
        $mail->Username = $this->systemInfo['send_mail_user']; // 要使用哪一个邮箱发邮件
        $mail->Password = $this->systemInfo['send_mail_password']; //
        $mail->SMTPSecure = C('SEND_EMAIL_SECURE');  // 设置使用SMTP的协议
        $mail->Port = C('SEND_EMAIL_PORT'); // SMTP ssl协议的端口

        $mail->setFrom($this->systemInfo['send_mail_user'], C('SEND_EMAIL_SENDER'));
        $mail->addAddress($toEmail);

        $mail->isHTML(true); // 表示发送的邮件内容以html的形式发送

        $mail->Subject = $subject;
        $mail->Body    = $body;
        return $mail->send();

    }

    /**
     * 调用发送邮件
     */
    public function sendToMember(){
        $paramArr = $_REQUEST;
        if(!empty($paramArr)){

            switch($paramArr['result']){

                case 1:
                    $body ="<p>".'亲爱的会员，恭喜你通过我们的明星筛选，我们稍后将安排工作人员联系您'."</p>" ;
                    $res = $this->sendEmail($paramArr['email'],'关于明星会员的回复',$body);
                    if($res){
                        M('MemberStar')->where(['id'=>$paramArr['id']])->save(['is_pass'=>1,'status'=>1]);
                        $this->ajaxReturn(['status'=>1]);
                    }else{
                        $this->ajaxReturn(['status'=>0]);
                    }
                    break;
                case 0:
                    $body ="<p>".'亲爱的会员，很抱歉您未能通过我们的明星筛选，请再接再厉哦'."</p>" ;
                    $res = $this->sendEmail($paramArr['email'],'明星会员申请结果',$body);

                    if($res){
                        //>> 退还申请的金额
                        M('Member')->where(['id'=>$paramArr['member_id']])->save(['money' => ['exp', 'money+' . 70000]]);
                        M('MemberStar')->where(['id'=>$paramArr['id']])->save(['is_pass'=>0,'status'=>1]);
                        $this->ajaxReturn(['status'=>1]);
                    }else{
                        $this->ajaxReturn(['status'=>0]);
                    }
                    break;
            }

        }else{

            die();
        }
    }


    /**
     * 会员收益
     */
    public function getProfit(){
        //搜索条件
        $where =[];
        $phone = I('get.phone');
        $type =  I('get.type_id');
        if($phone){
            $where['b.phone'] = ['like',"%$phone%"];
        }
        if($type){
            $where['a.type'] = ['like',"%$type%"];
        }
        $count = M('MemberProfit as a')
            ->field('a.*,b.username')
            ->join('left join an_member as b on b.id=a.member_id')
            ->where($where)
            ->count();

        $page = new Page($count,15);
        // 查询出会员收益
        $profit = M('MemberProfit as a')
            ->field('a.*,b.username')
            ->join('left join an_member as b on b.id=a.member_id')
            ->where($where)
            ->limit($page->firstRow, $page->listRows)
            ->order('a.create_time desc')
            ->select();

        // 生成分页DOM结构
        $pages = $page->show();
        // 向模板分配分页条
        $this->assign('pages',$pages);

        $this->assign('rows',$profit);
        $this->display('member/profit');
    }

}