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
            // 开启事物
            M()->startTrans();
            // 将项目基本信息保存到数据库 an_project表
            $_id = M('project')->add($projectInfo);
            if($_id === false){
                M()->rollback();
                $this->ajaxReturnError('数据保存失败',__LINE__);
            }

            // 商品概况表
            $survey = [
                'project_id' => $_id,
                'expected_return' => $_data['expected_return'],
                'story' => $_data['story'],
                'analysis' => $_data['analysis'],
                'film_critic' => $_data['film_critic'],
                'create_time' => time(),
            ];

            $result = M('project_survey')->add($survey);
            if($result === false){
                M()->rollback();
                $this->ajaxReturnError('数据保存失败',__LINE__);
            }

            // 提交事物
            M()->commit();
            $this->ajaxReturn(['msg'=>'数据保存成功', 'status'=>1,]);

        }
        $this->display('add');
    }

    public function edit(){

    }

    public function delete(){

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
     * 视频文件上传
     */
    public function upload_video(){
        $config = [
            'exts'          =>  array('avi','wma','rmvb','rm','flash','mp4','mid','3gp','mpg','mov','wmov','qt'), //允许上传的文件后缀
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