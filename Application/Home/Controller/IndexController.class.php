<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 首页
 */
class IndexController extends CommonController {
    public function index(){
        $code = I('code');
        $res = $this->getCodeAccessToken($code);
        $userInfo = $this->getUserInfo($res);
        $this->display();
    }


}