<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
/**
 * 2014-12-14
 * @author Sentiger
 *
 */
Class UserController extends CommonController{
    /**
     * 用户列表
     */
    Public function lst() {
        $model = D('User');
        $data = $model->lst();
        $this->data = $data;
        $this->display();
    }


    Public function loginOut() {
        session_destroy();
        $this->redirect('/Admin/Login/login');
    }
}