<?php
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller{

    //��¼�û���¼״̬
    public $isLogin = false;

    //��ǰ�û���Ϣ
    public $userInfo = [];

    protected $_msgArr = [

        '1000'=>['�û�ע����Ϣ����Ϊ��!','�û�ע����Ϣ����Ϊ��!'],
        '1002'=>['���ŷ���ʧ��!','���ŷ���ʧ��!'],
        '1004'=>['��ȴ�60����ٷ�����֤��!','��ȴ�60����ٷ�����֤��!'],
        '1006'=>['�ֻ������ʽ����ȷ!','�ֻ������ʽ����ȷ!'],
        '1008'=>['��֤�����!','��֤�����!'],
        '1010'=>['�û����������ʽ����ȷ!','�û���������ĸ�ʽ����ȷ!'],
        '1012'=>['ע��ʧ��!','ע��ʧ�ܣ�'],
    ];

    /**
     * ��ʼ��
     */
    public function _initialize(){
        //>> ��session
        $session = session(md5('home'));
        if(!empty($session)){
            //>> ��ѯ�û�
            $row = M('Member')->where(['session_token'=>$session])->find();
            if(!empty($row)){
                $this->isLogin = 1;
                $this->userInfo = $row;
                $this->assign('userInfo',$row);
            }
        }else{
            //>> ��cookie
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

    }

    /**
     *��ȡ����
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
     * ���ʹ���
     */
    public function _printError($code){

        if(empty($code)) return false;

        $out = $this->getError($code);

        return json_encode($out,JSON_UNESCAPED_UNICODE);

    }

    /**
     * ����ɹ�
     */
    public function _printSuccess($value = [],$isobject = 0)
    {
        $out = array("status" => 1,"data" => $value);

        if($isobject){

            $out = array("status" => 1,"data" => (object)$value );
        }

        return json_encode($out);
    }
}