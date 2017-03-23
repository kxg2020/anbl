<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        echo "懵逼树上懵逼果，懵逼树下你和我，懵逼树前做交易，懵逼树后泄浴火".'--鲁迅'."<br>";
        echo"Authored By 张涛".date('Y-m-d',time());
    }
}