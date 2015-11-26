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
        p($info);die;

        if($info){
            if($info['password'] == md5($password)){
                session('uid', $info['id']);
                $this->redirect('/Admin/Index/index');
            } else {
                $this->error('用户名或者密码错误');die;
            }
        }else{
            $this->error('用户名或者密码错误');die;
        }
    }
}