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
        $info = M('wx_user')->where(array('openid'=>$userInfo['openid']))->find();

        $this->code = $code;
        $this->info = $info;

        $this->display();
    }

    /**
     * 添加反馈信息
     */
    public function addInfo() {

    }


}