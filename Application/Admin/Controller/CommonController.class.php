<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Upload;

class CommonController extends Controller
{

    //记录用户登录状态
    public $isLogin = false;

    //当前用户信息
    public $userInfo = [];

    // 初始化
    public function _initialize(){
        //>> 拿session
        $session = session(md5('admin'));
        if(!empty($session)){
            //>> 查询用户
            $row = M('User')->where(['session_token'=>$session])->find();
            if(!empty($row)){
                $this->isLogin = 1;
                $this->userInfo = $row;
                $this->assign('userInfo',$row);
            }
        }else{
            //>> 拿cookie
            $cookie = cookie(md5('admin'));

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
     * Json返回信息
     * @var array
     */
    protected $Msg = [
        'status'     => 0,
        'msg'        => '',
        'error_code' => 0
    ];


    /**
     * ajaxReturn  返回错误信息
     *
     * @param string $msg 错误信息
     * @param int $error_code 错误代码 默认为0 建议为代码的当前行号  __LINE__
     * @param int $status 错误状态 默认为0
     */

    public function ajaxReturnError($msg, $error_code = 0, $status = 0)
    {
        // 错误信息
        $this->Msg['msg'] = $msg;
        // 错误代码 通常为当前行号
        $this->Msg['error_code'] = $error_code;
        // 错误状态
        $this->Msg['status'] = $status;
        // 返回错误信息
        $this->ajaxReturn($this->Msg);
    }

    /**
     * ajaxReturn  返回正确信息
     *
     * @param string $msg 返回信息
     * @param array $data 返回数据 默认为空
     * @param int $error_code 返回错误代码 默认为0 建议为代码的当前行号  __LINE__
     * @param int $status 返回状态 默认为1
     */

    public function ajaxReturnSuccess( $data = [],$msg = 'success', $status = 1, $error_code = 0)
    {
        // 返回信息
        $this->Msg['msg'] = $msg;
        // 返回数据
        $this->Msg['data'] = $data;
        // 返回代码 通常为当前行号
        $this->Msg['error_code'] = $error_code;
        // 返回状态
        $this->Msg['status'] = $status;
        // 返回信息
        $this->ajaxReturn($this->Msg);
    }

    /**
     * 上传文件
     */

    private function upload()
    {
        $config = [
            'exts'     => array('jpg', 'png', 'gif', 'bmp','jpeg'), //允许上传的文件后缀
            'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            'rootPath' => 'Uploads/', //保存根路径
        ];
        $upload = new Upload($config);
        $rst = $upload->upload($_FILES);
        // 判断是否上传成功
        if($rst == false){
            $this->Msg['msg'] = $upload->getError();
            $this->ajaxReturn($this->Msg);
        }
        $url = [
            'status' => 1
        ];
        // 组合出正确的 url 地址
        foreach ($rst as $item) {
            $url[] = [
                'url' => $item['url']
            ];
        }
        $this->ajaxReturn($url);
    }

}