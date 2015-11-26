<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    

    Public function _initialize() {
        // if (!session('uid')) $this->redirect('/Admin/Login/index');
    }
    

    /**
     * @param string $statusCode	返回状态码 200ok 300失败 301会话超时
     * @param string $message		提示信息
     * @param string $navTabId		刷新地址
     * @param string $callbackType	closeCurrent 关闭当前窗口
     * @param string $rel
     * @param string $forwardUrl	跳转地址
     */
    protected function ajax($statusCode,$message,$navTabId,$callbackType,$rel='',$forwardUrl=''){
        $status = array(
            'statusCode' => $statusCode,
            'message' => $message,
            'navTabId' => $navTabId,
            'rel' => $rel,
            'callbackType' => $callbackType,
            'forwardUrl' => $forwardUrl
        );
        echo json_encode($status);
        exit;
    }

}