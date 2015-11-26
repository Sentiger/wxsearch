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

    /**
     * 导出用户到excel
     * @return [type] [description]
     *   `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
     */
    public function doExportExcel() {
        $user = M('User')->select();
        // $title = array('公司名称,'手机号','微信openid','详细地址','微信昵称','经度','纬度');
        exportexcel($user, $title,'用户列表');
    }

    Public function loginOut() {
        session_destroy();
        $this->redirect('/Admin/Login/login');
    }
}