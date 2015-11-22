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
    const ACCESS_CODE_URL = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb383ceff8cdf7068&redirect_uri=http://wxsearch.sentiger.com/index.php/Home/Index/index&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';  //获取微信授权code

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

   /* public function getWXCode() {

        $url = self::ACCESS_CODE_URL;
        $appId = C('APP_ID');
        $appSecret = C('APP_SECRET');
        $redirectUri = 'http://wxsearch.sentiger.com/index.php/Home/Index/index';
        $scope = 'snsapi_base';
        $options = array(
            'appid' => $appId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => $scope,
            '#wechat_redirect'=>''
        );

    }*/


}