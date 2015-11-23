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
        $data = I('post.');
        if($data['is_new']) {
            $uid = M('user')->add($data);
        } else {
            $uid = $data['is_new'];
        }

        $data['uid'] = $uid;
        $infoid = M('info')->add($data);
        if($infoid && $uid)
            $data = array(
                'status' => 1,
                'msg' => '成功'
            );
        else
            $data = array(
                'status' => 0,
                'msg' => '失败'
            );
        echo json_encode($data);
    }


}