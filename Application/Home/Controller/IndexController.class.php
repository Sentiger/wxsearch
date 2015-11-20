<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 首页
 */
class IndexController extends Controller {
    public function index(){



        $this->display();
    }


    /**
     * 获取用户详细信息
     * @return [type] [description]
     */
    public function getUserInfo() {
    	echo 111;die;
    }
}