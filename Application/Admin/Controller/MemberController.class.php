<?php
namespace Admin\Controller;

use Think\Controller;

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

        $list = M('Member')->where(['is_active'=>1])->order('create_time desc ')->select();

        $count = ceil(count($list)/20);

        if(isset($paramArr['pgNum']) && !empty($paramArr['pgNum']) && is_numeric($paramArr['pgNum'])){
            $pgNum = $paramArr['pgNum'];
        }else{
            $pgNum = 1;
        }
        if(isset($paramArr['pgSize']) && !empty($paramArr['pgSize']) && is_numeric($paramArr['pgSize'])){
            $pgSize = $paramArr['pgSize'];
        }else{
            $pgSize = 20;
        }

        $memberList = $this->pagination($list,$pgNum,$pgSize);

        if(IS_AJAX){
            $this->ajaxReturn([
                'data'=>array_values($memberList),
                'status'=>1
            ]);
            exit;
        }

        $this->assign([
            'list'=>$memberList,
            'count'=>$count
        ]);

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

        }else{
            $this->ajaxReturn([
                'status'=>0,
                'msg'=>'修改失败'
            ]);
        }
    }

}