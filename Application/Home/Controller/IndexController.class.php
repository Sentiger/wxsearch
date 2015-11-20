<?php
namespace Home\Controller;
use Think\Controller;
use Common\lib\Curl_Manager;
/**
 * 首页
 */
class IndexController extends Controller {
    public function index(){



        $this->display();
    }


    /**
     * 获取用户详细信息
     * @return [type] [description]
     */
    public function getUserInfo() {
    	$curl = new Curl_Manager();
        $appId = C('APP_ID');
        $appSecret = C('APP_SECRET');
        $options = array(
            'grant_type' => 'client_credential',
            'appid' => $appId,
            'secret' => $appSecret
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/token';
        $url = 'http://baidu.com';
        $curl->open();
        $res = $curl->get($url,$options);
        var_dump($res);die;
    }
}