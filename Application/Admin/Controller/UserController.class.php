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
        $user = M('User')->field(array('company_name','mobile','openid','address','nickname','real_name','job','sex','province','city'))->group('openid')->select();
        $title = array('公司名称','手机号','微信openid','详细地址','微信昵称','姓名','职务','性别/1男，2女，0保密','省份','城市');

        exportexcel($user, $title, '用户列表');die; 
    }

    /**
     * 修改用户名或密码
     */
    public function setPassword() {
        if(IS_POST) {
            $data = array(
                'username'=>I('username'),
                'password'=>I('password','','md5')
            );

            $id = session('uid');

            if(M('admin')->where(array('id'=>$id))->save($data) !== false) {
                $this->ajax(200,'修改成功','','closeCurrent');
            } else {
                $this->ajax(300,'修改失败');
            }

        }

        $this->data = M('admin')->find(session('uid'));

        $this->display();
    }


    public function del() {
        $id = I('get.id',0,'intval');
        $tables = M('user')->where(array('id'=>$id))->getField('table_name');
        $tables = explode(',',$tables);
//        p($tables);die;
        foreach($tables as $k=>$v) {
            M($v)->where(array('uid'=>$id))->delete();
        }
        if(M('user')->where(array('id'=>$id))->delete()) {
            $this->ajax(200,'删除成功','Admin_User_lst');
        }else{
            $this->ajax(300,'修改失败');
        }

    }


    Public function loginOut() {
        session_destroy();
        $this->redirect('/Admin/Login/index');
    }
}