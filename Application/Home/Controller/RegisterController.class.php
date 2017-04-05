<?php
namespace Home\Controller;
use Think\Controller;

class RegisterController extends CommonController{

    /**
     * 注册界面
     */
    public function index(){

        $this->display('register/index');

    }

    /**
     * 用户注册
     */
    public function register(){

        $paramArr = $_REQUEST;

        if(!empty($paramArr) && !empty($paramArr['phone']) && !empty($paramArr['password']) && !empty($paramArr['captcha'])){

            $userModel = M('Member');

            //>> 检测邀请码
            if(empty($paramArr['invite_key'])){

                die($this->_printError('1038'));

            }

            //>> 检测验证码
            $captcha = session('verify_code'.$paramArr['phone']);

            if($captcha != $paramArr['captcha']){

                die($this->_printError('1008'));

            }else{

                //>> 检测用户名和密码
                $res = $this->checkUser($paramArr['password']);

                //>> 检测手机号
                $row = $this->checkPhone($paramArr['phone']);

                if(!$row){

                    die($this->_printError('1006'));

                }
                if(!$res){

                    die($this->_printError('1010'));

                }

                if(isset($paramArr['invite_key']) && !empty($paramArr['invite_key']) && strlen($paramArr['invite_key']) < 10){

                    $where = [
                        'invite_key'=>$paramArr['invite_key'],
                    ];
                    //>> 查询当前用户的上级
                    $row = $userModel->where($where)->find();
                    if(!empty($row)){
                        //>> 查询上级投资
                        $support = M('MemberSupport')->where(['member_id'=>$row['id']])->find();
                       //>> 判断投资是否满100
                        if($support['support_money'] >= 100){

                            M('Member')->where(['id'=>$row['id']])->save(['role'=>1]);
                        }

                        //>> 判断上级已经有多少下线
                        $count = $this->group($row['id']);
                        //>> 团队一共多少人
                        $all = $this->allMembers($row['id']);
                        if($count >= 2){
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
                        $parent_id = $row['id'];
                    }else{

                        die($this->_printError('1040'));
                    }

                }
                //>> 生成一个推荐码
                $str = '012345679ABCDEFGHJKMNPQRSTUZabcdefghjkmnpqrstuz';

                $strArr = str_split($str);

                shuffle($strArr);

                //>> 截取8位
                $endArr = array_slice($strArr,0,7);

                $invite_key = implode('',$endArr);

                //>> 判断当前用户是否已经注册
                $res = $userModel->where(['phone'=>$paramArr['phone']])->find();
                if($res){

                    die($this->_printError('1014'));

                }

                //>> 将用户信息保存到数据库
                $insertData = [
                    'username'=>$paramArr['phone'],
                    'password'=>md5($paramArr['password']),
                    'create_time'=>time(),
                    'last_ip'=>get_client_ip(),
                    'invite_key'=>$invite_key,
                    'parent_id'=>isset($parent_id) ? $parent_id : 0,
                    'safe_level'=>1,
                    'class'=>1,
                ];

                $res = $userModel->add($insertData);

                if($res){

                    die($this->_printSuccess());

                }else{

                    die($this->_printError('1012'));

                }

            }

        }else{

            die($this->_printError('1000'));

        }
    }

    /**
     * 检测密码
     */
    private function checkUser($password){

        if(empty($password)){

            return false;

        }else{
            //>> 检测密码
            if(isset($password) && strlen($password) < 16){

                //>> 密码由字母、数字、下划线组成，5-16位
                $reg = '/^[a-zA-Z]\w{5,16}$/';

                preg_match_all($reg,$password,$str);

                if(!empty($str)){

                    return true;

                }else{

                    return false;
                }
            }

        }

    }

    /**
     * 检测手机号
     */
    private function checkPhone($phone){

        $reg = '/^0?(13|14|15|17|18)[0-9]{9}$/';

        preg_match_all($reg,$phone,$str);

        if($str){

            return true;

        }else{
            return false;

        }

    }

    /**
     * 发送短信
     */
    public function sendMessage(){

        //>> 获取用户的手机号码
        $paramArr = $_REQUEST;

        if(!empty($paramArr['phone']) && is_numeric($paramArr['phone']) && strlen($paramArr['phone']) == 11){

            //>> 验证手机号
            $res = $this->checkPhone($paramArr['phone']);

            if(!$res){

                die($this->_printError('1006'));

            }

            $verifyTime = session('verify_create_time'.$paramArr['phone'],time());

            //>> 判断用户是否已经发送过短信
            if(!empty($verifyTime)){

                //>> 判断时间是否小于60秒
                if(time() - $verifyTime < 60 ){

                    die($this->_printError('1004'));

                }
            }

            //>> 生成一个推荐码
            $str = '0123456789';

            $strArr = str_split($str);

            shuffle($strArr);

            //>> 截取8位
            $endArr = array_slice($strArr,0,6);

            $code = implode('',$endArr);

            //>> 配置信息
            $config = [

                'phone_api_app_key'=>C('PHONE_API_APP_KEY'),

                'verify_code_tpl'=>C('VERIFY_CODE_TPL'),
            ];

            //>> 将验证码保存到session
            session('verify_code'.$paramArr['phone'],$code);

            //>> 发送短信
            $res = sendSMS($paramArr['phone'],$code,$config,1);

            if($res){

                //>> 保发送时间
                session('verify_create_time'.$paramArr['phone'],time());

                die($this->_printSuccess());

            }else{

                die($this->_printError('1002'));

            }

        }else{

            die($this->_printError('1006'));
        }
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
        return $sum;
    }


}