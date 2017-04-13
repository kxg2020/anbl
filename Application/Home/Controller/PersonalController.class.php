<?php
namespace Home\Controller;

use Think\Controller;
use Think\Upload;

class PersonalController extends CommonController{


    /**
     * 查询下级
     */
    public function find(){

        $paramArr = $_REQUEST;
        if(!empty($paramArr)){

            $rows = M('Member')->where(['parent_id'=>$paramArr['id']])->select();
            foreach($rows as &$row){
                //查询支持金额
                $row['support_money'] = M('MemberSupport')->where(['member_id'=>$row['id']])->sum('support_money');
                if(!$row['support_money']){
                    $row['support_money'] = 0;
                }
            }
            unset($row);
            $this->ajaxReturn($rows);
        }
    }

    /**
     * 递归查询最上级
     */
    private function groupLeader ($id){


        $res = M('Member')->where(['id'=>$id])->find();

        if($res['parent_id'] != 0){
             return $this->groupLeader($res['parent_id']);
        }else{
            return $res;
        }
    }

    /**
     * 递归查询所有下级
     */
    public  function getMenuTree($id,$lev = 0){

        static  $arrTree = array();
        //>> 查询子类
        $childTree = M('Member')->where(['parent_id'=>$id])->select();
        $lev ++;
        if(!empty($childTree)){
            $arrTree['level_'.$lev] = $childTree;
            foreach($childTree as $key => $value){
                $this->getMenuTree($value['id'],$lev);
            }
        }
        return $arrTree;
    }


    /**
     * 个人中心
     */
    public function index(){


        $paramArr = $_REQUEST;

       //>> 判断用户是否登录
        if($this->isLogin != 1){
            $this->redirect('Home/Login/index');
            exit;
        }
        $personModel = M('Member as a');
        $row = $personModel->where(['id'=>$this->userInfo['id'],'username'=>$this->userInfo['username']])->find();

        //>> 查询消费情况(支持)

        $consume_1 = $personModel->field('a.username,b.support_money,b.create_time,b.order_number')
            ->join('right join an_member_support as b on a.id = b.member_id')
            ->where(['a.id'=>$this->userInfo['id']])
            ->select();
        foreach($consume_1 as $key => &$value){
            $value['type'] = '电影支持';
            $value['create_time'] = date('Y-m-d',$value['create_time']);
            $value['money'] = $value['support_money'];
        }
        unset($value);
        //>> 查询消费情况(当演员)
        $consume_2 = $personModel->field('b.*')
            ->join('left join an_member_star as b on a.id = b.member_id')
            ->where(['a.id'=>$this->userInfo['id']])
            ->select();
        foreach($consume_2 as $key => &$value){
            $value['type'] = '演员申请';
            $value['create_time'] = date('Y-m-d',$value['create_time']);
            $value['money'] = 70000;
        }
        unset($value);

        //>> 投票记录
        $consume_3 = $personModel->field('a.username,b.*,sum(b.money) as money')
            ->join('left join an_member_consume as b on a.id = b.member_id')
            ->where(['a.id'=>$this->userInfo['id'],'b.type'=>'投票'])
            ->select();
        foreach($consume_3 as $key => &$value){
            $value['create_time'] = date('Y-m-d',$value['create_time']);
        }
        unset($value);
        //>> 查最上级
        $topLeader = $row;


        //>> 所有消费




        //>> 查询当前用户的支持情况
        $rows = M('MemberSupport as a')->field('a.*,b.*')
            ->join('left join an_project as b on a.project_id = b.id')
            ->where(['a.member_id'=>$this->userInfo['id']])
            ->select();
        $count_1 = ceil(count($rows)/4);
        $rows = $this->pagination($rows,1,4);
        //>> 查询积分制度表
        $integral = M('IntegralInstitution')->select();

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
            }else{
                $allInfo = ['status'=>0,'integral'=>$row['integral']];
            }
        }

        //>> 查询收藏情况
        $collection = $personModel->where(['member_id'=>$this->userInfo['id']])
                    ->join('left join an_member_collection as b on a.id = b.member_id')
                    ->join('left join an_project as c on b.project_id = c.id')
                    ->select();
        foreach($collection as $key => &$value){
            $value['date'] = date('Y-m-d',$value['showtime']);
            unset($value);
        }

        $collectionCount = ceil(count($collection)/4);
        $collectionList = $this->pagination($collection,1,4);

        $supportMoney = M('MemberSupport')->where(['member_id'=>$this->userInfo['id']])->sum('support_money');


        //>> 查询提问
        $question = M('MemberConsult')->where(['member_id'=>$this->userInfo['id']])->select();

        //>> 查询招募电影
        $recruit = M('ProjectRecruit')->select();

        //>> 查询充值订单
        $orderLst = M('MemberRecharge')->where(['member_id'=>$this->userInfo['id']])->select();
        $count = ceil(count($orderLst)/12);

        if(isset($paramArr['pgNum']) && !empty($paramArr['pgNum']) && is_numeric($paramArr['pgNum'])){
            $pgNum = $paramArr['pgNum'];
        }else{
            $pgNum = 1;
        }
        if(isset($paramArr['pgSize']) && !empty($paramArr['pgSize']) && is_numeric($paramArr['pgSize'])){
            $pgSize = $paramArr['pgSize'];
        }else{
            $pgSize = 12;
        }
        $orderList = $this->pagination($orderLst,$pgNum,$pgSize);
        //>> 账户安全等级
        $safePercent = [
            '1'=>'25%',
            '2'=>'50%',
            '3'=>'75%'
        ];
        $safeLevel = $safePercent[$row['safe_level']];
        //>> 组装电话号码
        $secretPhone = substr($row['username'],0,3).'****'.substr($row['username'],7,4);
        if(IS_AJAX){

            $this->ajaxReturn([
                'count'=>$count,
                'orderList'=>$orderList,
            ]);
        }
        $this->assign([
            'count'=>$count,
            'orderList'=>$orderList,
        ]);



        $this->assign([
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
            'supportMoney'=>$supportMoney,
            'secretPhone'=>$secretPhone,
        ]);
        $this->display('personal/index');
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
     * 保存信息
     */
    public function save(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){
            if(isset($paramArr['sex']) && !empty($paramArr['sex']) && is_numeric($paramArr['sex'])){

                $insertData = [
                    'sex'=>$paramArr['sex']
                ];


                $res = M('Member')->where(['id'=>$this->userInfo['id']])->save($insertData);


                if($res != 0){

                    die($this->_printSuccess());
                }else{

                    die($this->_printError(''));
                }
            }else{

                die($this->_printError(''));
            }
        }else{

            die($this->_printError(''));
        }
    }

    /**
     * 安全信息
     */
    public function safeInfo(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){
            $memberModel = M('Member');

            if(!empty($paramArr['phone'])){
                //>> 判断手机号是否已经绑定过账号
                $res = $memberModel->where(['phone'=>$paramArr['phone']])->select();

                if(!empty($res)){

                    die($this->_printError('1042'));
                }
            }

            //>> 判断该账号是否已经有手机绑定
            $_res = $memberModel->where(['id'=>$this->userInfo['id']])->find();

            if($_res['is_bind_phone'] == 0 && $_res['is_bind_email'] == 1){
                $updateData = [
                    'is_true'=>isset($paramArr['realname']) ? 1 : 0,
                    'phone'=>$paramArr['phone'],
                    'realname'=>$paramArr['realname'],
                    'id_card'=>$paramArr['id_card'],
                    'bank_card_name'=>$paramArr['bank_card_name'],
                    'bank_card'=>$paramArr['bank_card'],
                    'city'=>$paramArr['city'],
                    'address'=>$paramArr['address'],
                    'is_bind_phone'=>$paramArr['phone'] ? 1 : 0,
                    'safe_level'=>3
                ];
            }elseif($_res['is_bind_email'] == 0 && $_res['is_bind_phone'] == 1){

                $updateData = [
                    'is_true'=>isset($paramArr['realname']) ? 1 : 0,
                    'email'=>$paramArr['email'],
                    'realname'=>$paramArr['realname'],
                    'id_card'=>$paramArr['id_card'],
                    'bank_card_name'=>$paramArr['bank_card_name'],
                    'bank_card'=>$paramArr['bank_card'],
                    'city'=>$paramArr['city'],
                    'address'=>$paramArr['address'],
                    'is_bind_email'=>$paramArr['email'] ? 1 : 0,
                    'safe_level'=>3
                ];
            }elseif($_res['is_bind_email'] == 0 && $_res['is_bind_phone'] == 0){
                $updateData = [
                    'is_true'=>isset($paramArr['realname']) ? 1 : 0,
                    'email'=>$paramArr['email'],
                    'phone'=>$paramArr['phone'],
                    'realname'=>$paramArr['realname'],
                    'id_card'=>$paramArr['id_card'],
                    'bank_card_name'=>$paramArr['bank_card_name'],
                    'bank_card'=>$paramArr['bank_card'],
                    'city'=>$paramArr['city'],
                    'address'=>$paramArr['address'],
                    'is_bind_email'=>$paramArr['email'] ? 1 : 0,
                    'is_bind_phone'=>$paramArr['phone'] ? 1: 0,
                    'safe_level'=>3
                ];
            }else{
                $updateData = [
                    'is_true'=>isset($paramArr['realname']) ? 1 : 0,
                    'realname'=>$paramArr['realname'],
                    'id_card'=>$paramArr['id_card'],
                    'bank_card_name'=>$paramArr['bank_card_name'],
                    'bank_card'=>$paramArr['bank_card'],
                    'city'=>$paramArr['city'],
                    'address'=>$paramArr['address'],
                    'safe_level'=>3
                ];
            }

            $res = $memberModel->where(['id'=>$this->userInfo['id']])->save($updateData);
            if($res != 0){
                die($this->_printSuccess());
            }
        }
    }

    /**
     * 提现
     */
    public function cash(){

        $paramArr = $_REQUEST;
        $crrDay = date('Y-m-d');
        $lastDay = $this->getTheMonth();
        //>> 判断当前时间是否是周五
        if(date('w') == 5){
            if(!empty($paramArr)){

                if(isset($paramArr['money']) && !empty($paramArr['money']) && is_numeric($paramArr['money'])){
                    //>> 查询余额
                    $row = M('Member')->where(['id'=>$this->userInfo['id']])->find();
                    if(empty($row)){

                        die($this->_printError('1056'));
                    }
                    //>> 判断金额是否大于余额
                    if($paramArr['money'] > $row['money']){

                        die($this->_printError('1052'));
                    }

                    //>> 提取现金，生成订单
                    $updateData = [
                        'money'=>$row['money'] - $paramArr['money']-$paramArr['money']*0.1,
                    ];

                    M('Member')->startTrans();
                    $res = M('Member')->where(['id'=>$this->userInfo['id']])->save($updateData);
                    //>> 生成订单
                    $orderNumber = 'CS'.date('Ymd') . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);

                    $insertData = [
                        'money'=>$paramArr['money'],
                        'member_id'=>$this->userInfo['id'],
                        'create_time'=>time(),
                        'is_pass'=>0,
                        'order_number'=>$orderNumber,
                        'charge'=>$paramArr['money'] * 0.1
                    ];

                    //>> 保存订单
                    $ros = M('MemberCash')->add($insertData);
                    if($ros && $res){
                        M('Member')->commit();
                        die($this->_printSuccess());
                    }else{

                        die($this->_printError('1056'));
                    }

                }else{

                    die($this->_printError('1056'));
                }
            }else{

                die($this->_printError('1056'));
            }
        }elseif($crrDay == $lastDay){
                if(!empty($paramArr)){
                    if(isset($paramArr['money']) && !empty($paramArr['money']) && is_numeric($paramArr['money'])){
                        //>> 查询余额
                        $row = M('Member')->where(['id'=>$this->userInfo['id']])->find();
                        if(empty($row)){

                            die($this->_printError(''));
                        }
                        //>> 判断金额是否大于余额
                        if($paramArr['money'] > $row['money']){

                            die($this->_printError('1052'));
                        }

                        //>> 提取现金，生成订单
                        $updateData = [
                            'money'=>$row['money'] - $paramArr['money'] - $paramArr['money'] * 0,
                        ];

                        M('Member')->startTrans();
                        $res = M('Member')->where(['id'=>$this->userInfo['id']])->save($updateData);

                        //>> 生成订单
                        $orderNumber = 'CS'.date('Ymd') . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);

                        $insertData = [
                            'money'=>$paramArr['money'],
                            'member_id'=>$this->userInfo['id'],
                            'create_time'=>time(),
                            'is_pass'=>0,
                            'order_number'=>$orderNumber,
                            'charge'=>$paramArr['money'] * 0
                        ];

                        //>> 保存订单
                        $ros = M('MemberCash')->add($insertData);
                        if($res && $ros){

                            M('Member')->commit();
                            die($this->_printSuccess());
                        }else{

                            die($this->_printError('1054'));
                        }

                    }else{

                        die($this->_printError('1054'));
                    }
                }else{

                    die($this->_printError('1054'));
            }
        }else{
            die($this->_printError('1056'));
        }
    }

    /**
     * 获取当月最后一天
     */
    function getTheMonth()
    {
        $firstDay = date('Y-m-01', strtotime(date("Y-m-d")));
        $lastDay = date('Y-m-d', strtotime("$firstDay +1 month -1 day"));

        return $lastDay;
    }


    /**
     * 图片文件上传
     */
    public function upload(){
        $config = [
            'exts'          =>  array('jpg','png','gif','bmp'), //允许上传的文件后缀
            'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath'      =>  'Upload/', //保存根路径
        ];
        $upload = new Upload($config);
        $rst = $upload->uploadOne(array_shift($_FILES));
        // 判断是否上传成功
        if($rst == false){
            $this->Msg['msg'] = $upload->getError();
            $this->ajaxReturn($this->Msg);
        }
        if(!$rst){
            $this->ajaxReturn([
                'status' => 0,
                'msg' => '文件上传失败'
            ]);
        }

        $this->ajaxReturn([
            'status' => 1,
            'url' => $rst['url']
        ]);
    }

    /**
     * 忘记密码
     */
    public function modify(){


    }

    /**
     * 我的支持分页
     */

    public function mySupport(){

        $paramArr = $_REQUEST;

        $pgNum = $paramArr['pgNum'];
        $pgSize = 4;

        $rows =  M('MemberSupport as a')->field('a.*,b.*')
            ->join('left join an_project as b on a.project_id = b.id')
            ->where(['a.member_id'=>$this->userInfo['id']])
            ->select();

        $rows = $this->pagination($rows,$pgNum,$pgSize);

        $this->ajaxReturn([
            'rows'=>$rows,
        ]);
    }

    /*
     * 我的收藏分页
     */
    public function myCollection(){

        $paramArr = $_REQUEST;
        //>> 查询收藏情况
        $collection = M('Member as a')->where(['member_id'=>$this->userInfo['id']])
            ->join('left join an_member_collection as b on a.id = b.member_id')
            ->join('left join an_project as c on b.project_id = c.id')
            ->select();
        foreach($collection as $key => &$value){
            $value['date'] = date('Y-m-d',$value['showtime']);
            unset($value);
        }

        $collectionList = $this->pagination($collection,$paramArr['pgNum'],4);
        $this->ajaxReturn([
            'rows'=>$collectionList,
        ]);
    }


    /**
     * 修改密码
     */
    public function editPassword(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr)){

            $user = M('Member')->where(['id'=>$this->userInfo['id']])->find();

            if(!empty($user)){

                if($user['password'] != md5($paramArr['password'])){

                    $this->ajaxReturn(['status'=>0,'msg'=>'当前密码错误']);
                }
            }
            $updateData  = [
                'password'=>md5($paramArr['newpassword']),
            ];
            $res = M('Member')->where(['id'=>$this->userInfo['id']])->save($updateData);
            if($res != false){
                $this->ajaxReturn([
                    'status'=>1,
                    'msg'=>'修改成功',
                ]);
            }else{
                $this->ajaxReturn([
                    'status'=>0,
                    'msg'=>'修改失败'
                ]);
            }
        }else{

            $this->ajaxReturn([
                'status'=>0
            ]);
        }
    }

    /**
     * 我要当演员
     */
    public function star(){

        $paramArr = $_REQUEST;
        if(!empty($paramArr)){

            M('Member')->startTrans();

            //>> 将消费信息写入数据库
            $data = [
                'money'=>70000,
                'create_time'=>time(),
                'member_id'=>$this->userInfo['id'],
                'type'=>'演员申请'
            ];

            M('MemberConsume')->add($data);
            $insertData = [
                'name'=>$paramArr['name'],
                'sex'=>$paramArr['sex'],
                'volk'=>$paramArr['volk'],
                'birthday'=>$paramArr['birthday'],
                'height'=>$paramArr['height'],
                'id_card'=>$paramArr['id_card'],
                'phone'=>$paramArr['phone'],
                'email'=>$paramArr['email'],
                'address'=>$paramArr['address'],
                'skill'=>$paramArr['skill'],
                'ex'=>$paramArr['ex'],
                'image_url'=>$paramArr['image_url'],
                'member_id'=>$this->userInfo['id'],
                'project_id'=>session('filmId'.$this->userInfo['id']),
                'role_id'=>session('roleId'.$this->userInfo['id']),
                'is_pass'=>2,
            ];

            $res = M('MemberStar')->where(['member_id'=>$this->userInfo['id']])->add($insertData);
            $re = M('Member')->where(['id'=>$this->userInfo['id']])->save(['money'=>$this->userInfo['money'] - 70000]);
            if($res && $re){

                M('Member')->commit();
                die($this->_printSuccess());
            }else{

                M('Member')->rollback();
                die($this->_printError(''));
            }
        }else{

            die($this->_printError(''));
        }
    }

    /**
     * 查看电影详情
     */
    public function filmDetail(){

        $paramArr = $_REQUEST;
        if(!empty($paramArr)){

            if(isset($paramArr['id']) && is_numeric($paramArr['id']) && !empty($paramArr['id'])){

                $film = M('ProjectRecruit')->where(['id'=>$paramArr['id']])->find();
                $film['role_id'] = json_decode($film['role_id']);

                if(!empty($film)){
                    static $dataArr = [];
                    //>> 循环查询角色
                    foreach($film['role_id'] as $key => $value){
                        $row = M('ProjectRole')->where(['id'=>$value])->find();
                        $dataArr[$key] = array_merge($row);
                    }
                    $this->assign('role',$dataArr);
                    $this->assign('film',$film);
                }
            }else{

                $this->ajaxReturn([
                    'status'=>0,
                    'msg'=>'查询失败'
                ]);
            }
        }else{

            $this->ajaxReturn([
                'status'=>0,
                'msg'=>'数据为空'
            ]);
        }
        $this->display('role/detail');
    }

    /**
     * 保存选择的角色
     */
    public function filmSave(){
        $paramArr = $_REQUEST;

        $filmId = $paramArr['filmId'];
        $roleId = $paramArr['roleId'];

      if(!empty($filmId) && !empty($roleId)){
          //>> 将id存到session中
          session('filmId'.$this->userInfo['id'],$filmId);
          session('roleId'.$this->userInfo['id'],$roleId);
      }
    }

    /**
     * 申请演员完成提示
     */
    public function tips(){

        $this->display('personal/tips');
    }
}