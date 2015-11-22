<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 基类控制器
 * Class CommonController
 * @package Home\Controller
 */
class CommonController extends Controller {
    const ACCESS_TOKEN_URL = 'https://api.weixin.qq.com/cgi-bin/token'; //获取微信access_token
    const ACCESS_CODE_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/access_token';

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
        $url = self::ACCESS_TOKEN_URL;
        $res = cUrl($url,$options);
        $res = json_decode($res,true);
        S('access_token', $res['access_token'], 7000);
        return S('access_token');
    }


    public function getCodeAccessToken($code) {
       $url = self::ACCESS_CODE_TOKEN_URL;
        $options = array(
            'appid' => C('APP_ID'),
            'secret' => C('APP_SECRET'),
            'code' => $code,
            'grant_type' => 'authorization_code'
        );
        $res = cUrl($url,$options);
        $res = json_decode($res,true);
        return $res;
    }


}