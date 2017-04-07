<?php
namespace Admin\Controller;

class SystemController extends CommonController
{
    //系统设置
    public function index(){
        if (IS_POST) {
            // 获取数据
            $data = M('System')->create();

            // 判断数据是否合法
            if (!$data) {
                $this->Msg['msg'] = M('System')->getError();
                $this->ajaxReturn($this->Msg);
            }
            // 判断 是否需要更改邮件发送密码
            if (empty($data['send_mail_password'])) {
                unset($data['send_mail_password']);
            }

            // 将数据保存到数据库中
            $rst = M('System')->save($data);
            if ($rst === false) {
                $this->Msg['msg'] = '保存失败';
                $this->ajaxReturn($this->Msg);
            } else {
                $this->Msg['status'] = 1;
                $this->Msg['msg'] = '保存成功';
                $this->ajaxReturn($this->Msg);
            }
            exit;

        }
        // 查询出系统设置信息
        $systemInfo = M('System')->find();
        $this->assign('info',$systemInfo);
        $this->display('index');
    }
}