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
        echo 111;die;
        $info = M('user')->where(array('openid'=>$userInfo['openid']))->find();

        $this->code = $code;
        $this->info = $info;
        $this->userInfo = $userInfo;
        $this->display();
    }

    /**
     * 添加反馈信息
     */
    public function addInfo() {
        $data = array(
            'status' => 1,
            'msg' => '成功'
        );
        echo json_encode($data);
    }


}