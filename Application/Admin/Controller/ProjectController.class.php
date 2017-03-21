<?php
namespace Admin\Controller;

use Think\Upload;

class ProjectController extends CommonController
{

    public function index(){
        $this->display('index');
    }

    public function add(){
        if(IS_POST && IS_AJAX){
            // 获取数据
            $_data = i('post.');

            // 判断开始时间是否比大结束时间
            if ($_data['start_time'] >= $_data['end_time']) {
                $this->ajaxReturnError('开始时间不能大于或等于结束时间',__LINE__);
            }

            // 处理上传图片
            $config = [
                'exts'     => array('jpg', 'png', 'gif', 'bmp','jpeg'), //允许上传的文件后缀
                'subName'  => array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
                'rootPath' => 'Uploads/', //保存根路径
            ];
            $upload = new Upload($config);
            $rst = $upload->upload($_FILES['image_url']);
            dump($_FILES);
            exit;

            // 获取项目基本信息
            $projectInfo = [
                'name' => $_data['name'],
                'target_amount' => $_data['target_amount'],
                'title' => $_data['title'],
                'intro' => $_data['intro'],
                'start_time' => strtotime($_data['start_time']),
                'end_time' => strtotime($_data['end_time']),
                'sort' => $_data['sort'],
                'is_active' => $_data['is_active'],
                'type_id' => intval($_data['type_id']),
                'url' => $_data['url'],
                'image_url' => $_data['image_url'],
                'create_time' => time(),
            ];
        }
        $this->display('add');
    }

    public function edit(){

    }

    public function delete(){

    }

}