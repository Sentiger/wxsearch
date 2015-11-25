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
    const JS_TICK_URL = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket';

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



    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);
echo $url;die;
        $signPackage = array(
            "appId"     => C('APP_ID'),
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    //获取随机字符串
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    //获取ticket
    private function getJsApiTicket() {
        if(S('access_token')) return S('access_token');

        $accessToken = $this->getAccessToken();
        // 如果是企业号用以下 URL 获取 ticket
        // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
        $url = self::JS_TICK_URL;
        $options = array(
            'type'=>'jsapi',
            'access_token'=>$accessToken
        );
        $res = cUrl($url,$options);
        $res = json_decode($res, true);
        $ticket = $res['ticket'];
        S('access_token',$ticket,7000);

        return $ticket;
    }

}