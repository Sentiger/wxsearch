<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 基类控制器
 * Class CommonController
 * @package Home\Controller
 */
class CommonController extends Controller {

    /**
     * 获取微信token
     * @return mixed|string
     */
    public function getAccessToken() {
        if(S('access_token')) return S('access_token');
        $appId = C('APP_ID');
        $appSecret = C('APP_SECRET');
        $options = array(
            'grant_type' => 'client_credential',
            'appid' => $appId,
            'secret' => $appSecret
        );
        $url = 'https://api.weixin.qq.com/cgi-bin/token';
        $res = cUrl($url,$options);
        $res = json_decode($res,true);
        S('access_token', $res['access_token'], 7000);
        return S('access_token');
    }


}