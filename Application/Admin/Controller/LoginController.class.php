<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 用户登录控制器
 * Class LoginController
 * @package Admin\Controller
 */
class LoginController extends Controller {
    public function index() {
        $this->display();
    }

    public function doLogin() {
        $password = I('password','');
        $username = I('username','');

        $info = M('admin')->where(array('username'=>$username))->find();
        if($info){
            if($info['password'] == md5($password)){
                session('uid', $info['id']);
                $pri = explode(',', $info['privilege_list']);

                $pri = array_merge($pri, C('NO_CONFIRM_LIST'));
                session('privilege',$pri);
                session('role_id', $info['role_id']);

                session('username', $info['username']);
                $this->redirect('/Admin/Index/index');
            } else {
                $this->error('用户名或者密码错误');die;
            }
        }else{
            $this->error('用户名或者密码错误');die;
        }
    }
}