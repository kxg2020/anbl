<?php
namespace Home\Controller;

class FactoryController extends CommonController
{

    public function index(){
        // 查询出所有优秀演员
        $performerInfos = M('Performer')
            ->order('create_time desc')
            ->limit(0,10)
            ->select();
        $this->assign('performerInfos',$performerInfos);
        // 查询出所有优秀导演
        $directorInfos = M('Director')
            ->order('create_time desc')
            ->limit(0,10)
            ->select();
        $this->assign('directorInfos',$directorInfos);
        // 查询出所有优秀作品
        $worksInfos = M('Works')
            ->order('create_time desc')
            ->limit(0,10)
            ->select();
        $this->assign('worksInfos',$worksInfos);
        $this->display('factory/index');
    }

    /**
     * 投票
     */
    public function vote(){
        if(IS_POST && IS_AJAX){
            //判断会员是否已经登录
            if(!$this->isLogin){
                $this->ajaxReturn(['msg'=>"对不起，您还没有登录！！！",'status'=>0]);
            }
            $data = I('post.');
            $type_id = intval($data['type']);
            $id = intval($data['id']);
            $model = '';
            //判断投票类别
            if($type_id == 1){//优秀演员
                $model = M('performer');
                //查看是否存在记录
                $info = $model->find($id);
                if(!$info){
                    $this->ajaxReturn(['msg'=>"演员信息不存在",'status'=>0]);
                }
            }elseif($type_id == 2){
                $model = M('Director');
                $info = $model->find($id);
                if(!$info){
                    $this->ajaxReturn(['msg'=>"导演信息不存在",'status'=>0]);
                }
            }else{
                $model = M('Works');
                $info = $model->find($id);
                if(!$info){
                    $this->ajaxReturn(['msg'=>"作品信息不存在",'status'=>0]);
                }
            }

            $result = $model->where(['id'=>$id])->save(['vote_number'=>$info['vote_number']+1]);
            if($result === false){
                $this->ajaxReturn(['msg'=>"投票失败",'status'=>0]);
            }
            $this->ajaxReturn(['msg'=>"投票成功",'status'=>1]);

        }
    }

}