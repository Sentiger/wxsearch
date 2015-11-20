<?php
namespace Home\Controller;
use Think\Controller;
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
        $appId = C('APP_ID');
        $appSecret = C('APP_SECRET');
        $options = array(
            'grant_type' => 'client_credential',
            'appid' => $appId,
            'secret' => $appSecret
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appId.'&secret='.$appSecret;
        // $url = 'http://baidu.com';
        // $res = get($url,$options);
        $arr = array(
            'url'=>$url,
            'method'=>'get'
        );
        $res = send($arr);
        
        $res = json_decode($res);
        var_dump($res);
        print_r($res);die;
    }
}