<?php
namespace Home\Controller;

use Think\Controller;
use Think\Upload;

class PersonalController extends CommonController{

    /**
     * 个人中心
     */
    public function index(){

       //>> 判断用户是否登录
        if($this->isLogin != 1){
            $this->redirect('Home/Login/index');
            exit;
        }
        $personModel = M('Member as a');
        $row = $personModel->where(['id'=>$this->userInfo['id'],'username'=>$this->userInfo['username']])->find();
        //>> 查询当前用户的支持情况
        $rows = M('MemberSupport as a')->field('a.*,b.*')
            ->join('left join an_project as b on a.project_id = b.id')
            ->where(['a.member_id'=>$this->userInfo['id']])
            ->select();
        //>> 查询积分制度表
        $integral = M('IntegralInstitution')->select();

        //>> 取出当前用户的积分
        $crrIntegral = $row['integral'];

        //>> 取出当前用户等级
        $crrLevel = $row['level'];

        //>> 取出积分表下一个等级对应的积分
        $allInfo = ['status'=>0,'integral'=>$row['integral']];
        foreach($integral as $key => $value){
            if($value['level'] == $crrLevel + 1){
                $expIntegral = $value['integral'];
                $allInfo['level'] = $value['level'];
                //>> 算出还需要多少积分
                $needIntegral = $expIntegral - $crrIntegral;
                $allInfo['integral'] = $needIntegral;
                $allInfo['status'] = 1;
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
        $supportMoney = 0;
        if(!empty($rows)){
            //>> 对用户支持的电影金额求和
            foreach($rows as $key => $value){
                $supportMoney += $value['support_money'];
            }
        }

        //>> 查询充值订单
        $orderList = M('MemberRecharge')->where(['member_id'=>$this->userInfo['id']])->select();
        //>> 账户安全等级
        $safePercent = [
            '1'=>'25%',
            '2'=>'50%',
            '3'=>'75%'
        ];
        $safeLevel = $safePercent[$row['safe_level']];
        //>> 组装电话号码
        $secretPhone = substr($row['username'],0,3).'****'.substr($row['username'],7,4);
        $this->assign([
            'orderList'=>$orderList,
            'allInfo'=>$allInfo,
            'personal'=>$row,
            'collection'=>$collection,
            'safeLevel'=>$safeLevel,
            'supportSituation'=>$rows,
            'supportMoney'=>$supportMoney,
            'secretPhone'=>$secretPhone,
        ]);
        $this->display('personal/index');
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
     * 提取现金
     */
    public function cash(){

        $paramArr = $_REQUEST;

        //>> 判断当前时间是否是周五
        
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

}