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
    const ACCESS_CODE_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/access_token';  //用户获取用户授权时的信息
    const R_ACCESS_CODE_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/refresh_token';   //用户用户授权时获取的用户信息，重新刷新access_token
    const GET_USER_INFO_URL = 'https://api.weixin.qq.com/sns/userinfo'; //拉取用户的详细信息


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

    /**
     * 通过code换取网页授权access_token
     * @param $code
     * @return array|bool|\mix|mixed|\stdClass|string
     */
    public function getCodeAccessToken($code, $isRef = false) {
       $url = self::ACCESS_CODE_TOKEN_URL;
        $options = array(
            'appid' => C('APP_ID'),
            'secret' => C('APP_SECRET'),
            'code' => $code,
            'grant_type' => 'authorization_code'
        );
        $res = cUrl($url,$options);
        $res = json_decode($res,true);
        if($isRef)
            $res = $this->getRefreshCodeAccessToken($res);

        return $res;
    }

    /**
     * 刷新access_token
     * @param $res array
     * @return array|bool|\mix|mixed|\stdClass|string
     */
    public function getRefreshCodeAccessToken($res) {
        $url = self::R_ACCESS_CODE_TOKEN_URL;
        $options = array(
            'appid'=> C('APP_ID'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $res['refresh_token']
        );
        $res = cUrl($url,$options);
        $res = json_decode($res,true);
        return $res;
    }

    /**
     * 拉取用户信息(需scope为 snsapi_userinfo)
     * @param $res
     * @return array|bool|\mix|mixed|\stdClass|string
     */
    public function getUserInfo($res) {
        $url = self::GET_USER_INFO_URL;
        $options = array(
            'access_token' => $res['access_token'],
            'openid' => $res['openid'],
            'lang' => 'zh_CN '
        );
        $res = cUrl($url,$options);
        $res = json_decode($res,true);
        return $res;
    }


}