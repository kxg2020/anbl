<?php
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller{

    //记录用户登录状态
    public $isLogin = 0;

    //当前用户信息
    public $userInfo = [];

    protected $_msgArr = [

        '1000'=>['用户信息不能为空!','用户信息不能为空!'],
        '1002'=>['短信发送失败!','短信发送失败!'],
        '1004'=>['请等待60秒后再发送验证码!','请等待60秒后再发送验证码!'],
        '1006'=>['手机号码格式不正确!','手机号码格式不正确!'],
        '1008'=>['验证码错误!','验证码错误!'],
        '1010'=>['用户名或密码格式不正确!','用户名或密码的格式不正确!'],
        '1012'=>['注册失败!','注册失败！'],
        '1014'=>['请不要重复注册!','请不要重复注册！'],
        '1016'=>['用户名或密码错误!','用户名或密码错误！'],
        '1018'=>['用户名不能为空!','用户名不能为空！'],
        '1020'=>['密码不能为空!','密码不能为空！'],
        '1022'=>['用户名格式不正确!','用户名格式不正确！'],
        '1024'=>['密码格式不正确!','密码格式不正确！'],
        '1026'=>['确认密码不能为空!','确认密码不能为空！'],
        '1028'=>['两次密码不一致!','两次密码不一致！'],
        '1030'=>['密码修改失败!','密码修改失败！'],
        '1032'=>['用户名不存在!','用户名不存在！'],
        '1034'=>['用户名不存在!','用户名不存在！'],
        '1036'=>['发表失败!','发表失败！'],
        '1038'=>['邀请码必填!','邀请码必填！'],
        '1040'=>['邀请码不存在!','邀请码不存在！'],
        '1042'=>['该手机号已经绑定过账号了!','该手机号已经绑定过账号了！'],
        '1044'=>['当前账号已经绑定过手机号了!','当前账号已经绑定过手机号了！'],
        '1046'=>['你没有充值权限!','你没有充值权限！'],
        '1048'=>['充值失败!','充值失败!'],
        '1050'=>['只有每周星期五才能提现!','只有每周星期五才能提现!'],
        '1052'=>['提现金额不能大于余额!','提现金额不能大于余额!'],
        '1054'=>['提现失败!','提现失败!'],
        '1056'=>['只有周五或月末才能提现','只有周五或月末才能提现'],
        '1058'=>['您已经申请过了','您已经申请过了'],

    ];

    // 系统设置
    public $systemInfo;
    /**
     * 初始化
     */
    public function _initialize(){
        // 获取系统设置信息
        $this->getSystemInfo();
        //>> 拿session
        $session = session(md5('home'));
        if(!empty($session)){
            //>> 查询用户
            $row = M('Member')->where(['session_token'=>$session])->find();
            if(!empty($row)){
                //>> 查询投资
                $support = M('MemberSupport')->where(['member_id'=>$row['id']])->find();
                //>> 判断投资是否满100
                if($support['support_money'] >= 100){

                    M('Member')->where(['id'=>$row['id']])->save(['role'=>1]);
                }

                //>> 判断上级已经有多少下线
                $count = $this->group($row['id']);
                //>> 团队一共多少人
                $all = $this->allMembers($row['id']);
                if($count >= 3){
                    //>> 升级为经纪人
                    M('Member')->where(['id'=>$row['id']])->save(['role'=>2]);
                }

                //>> 如果投资5000以上,直推10人,团队100人升级为制片人
                if($support['support_money'] >= 5000 && $count >= 10 && $all >= 100){
                    //>> 升级为经纪人
                    M('Member')->where(['id'=>$row['id']])->save(['role'=>3]);
                }

                //>> 如果个人投资10000 直推50人 团队500人 升级出品人
                if($support['support_money'] >= 5000 && $count >= 50 && $all >= 500){
                    //>> 升级为经纪人
                    M('Member')->where(['id'=>$row['id']])->save(['role'=>4]);
                }


                $this->isLogin = 1;
                $this->userInfo = $row;
                $this->assign('userInfo',$row);
            }
        }else{
            //>> 拿cookie
            $cookie = cookie(md5('home'));
            if(!empty($cookie)){
                $row = M('User')->where(['remember_token'=>$cookie]);
                if(!empty($row)){
                    $this->isLogin = 1;
                    $this->userInfo = $row;
                    $this->assign('userInfo',$row);
                }
            }
        }
        $this->assign('isLogin',$this->isLogin);


    }


    /**
     * 查询直推
     */
    private function group($id){

        $res = M('Member')->where(['parent_id'=>$id])->select();

        if(!empty($res)){

            return count($res);
        }
    }

    /**
     * 团队
     */
    public function allMembers($id){

        static $sum = 0;
        $rows = M('Member')->where(['parent_id'=>$id])->select();
        $count = count($rows);
        $sum += $count;
        if(!empty($rows)){
            foreach($rows as $k => $v){
                $this->allMembers($v['id']);
            }
        }
        return $sum/2;
    }



    /**
     *获取错误
     */
    public function getError($code,$isShow = 1){

        if(empty($code)) return false;

        $errMsg = $this->_msgArr[$code][0];

        if($isShow){

            $msg = ['status'=>0,'msg'=>$errMsg,'errCode'=>$code];

        }else{

            $msg = ['status'=>0,'errCode'=>$code];

        }

        return $msg;
    }

    /**
     * 发送错误
     */
    public function _printError($code){

        if(empty($code)) return false;

        $out = $this->getError($code);

        return json_encode($out,JSON_UNESCAPED_UNICODE);

    }

    /**
     * 请求成功
     */
    public function _printSuccess($value = [],$isobject = 0)
    {
        $out = array("status" => 1,"data" => $value);

        if($isobject){

            $out = array("status" => 1,"data" => (object)$value );
        }

        return json_encode($out);
    }

    /**
     * 获取系统配置信息
     */
    public function getSystemInfo()
    {
        // 判断系统设置 是否存在于缓存中
        if (S('SystemInfo') && S('SystemInfoOutTime') > time()) {
            $this->systemInfo = S('SystemInfo');
            // 分配到页面中
            $this->assign('systemInfo', $this->systemInfo);
            return;
        } else {
            // 清空缓存
            S('SystemInfo', null);
            S('SystemInfoOutTime', null);
        }

        // 获取系统设置数据
        $this->systemInfo = M('System')->find(1);

        // 放在缓存中
        S('SystemInfo', $this->systemInfo);
        // 设置过期时间
        S('SystemInfoOutTime', time() + 600); // 10 分钟更新一次

        // 分配到页面中
        $this->assign('systemInfo', $this->systemInfo);
    }
}