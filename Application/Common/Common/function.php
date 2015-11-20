<?php
/**
 * 打印函数
 * @param array $data
 */
function p($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}




/**
 * 将xml转换成数组
 * @param $xmlstring
 * @return array|bool|mix|mixed|stdClass|string
 */
function simplest_xml_to_array($xmlstring) {
    return json_decode(json_encode((array) simplexml_load_string($xmlstring)), true);
}

/*
 * http request tool
 */
/*
 * get method
 */
function get($url, $param=array()){
	if(!is_array($param)){
		throw new Exception("参数必须为array");
	}
	$p='';
	foreach($param as $key => $value){
		$p=$p.$key.'='.$value.'&';
	}
	if(preg_match('/\?[\d\D]+/',$url)){//matched ?c
		$p='&'.$p;
	}else if(preg_match('/\?$/',$url)){//matched ?$
		$p=$p;
	}else{
		$p='?'.$p;
	}
	$p=preg_replace('/&$/','',$p);
	$url=$url.$p;
	//echo $url;
	$httph =curl_init($url);
	curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($httph,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($httph, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
	
	curl_setopt($httph, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($httph, CURLOPT_HEADER,1);
	$rst=curl_exec($httph);
	curl_close($httph);
	return $rst;
}
/*
 * post method
 */
function post($url, $param=array()){
	if(!is_array($param)){
		throw new Exception("参数必须为array");
	}
	$httph =curl_init($url);
	curl_setopt($httph, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($httph, CURLOPT_SSL_VERIFYHOST, 1);
	curl_setopt($httph,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($httph, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
	curl_setopt($httph, CURLOPT_POST, 1);//设置为POST方式 
	curl_setopt($httph, CURLOPT_POSTFIELDS, $param);
	curl_setopt($httph, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($httph, CURLOPT_HEADER,1);
	$rst=curl_exec($httph);
	curl_close($httph);
	return $rst;
}


/**
 * curl
 * @var [type]
 */
function cUrl($url, $params, $type = 0) {
		$curl = new Common\lib\curl\Curl2;
        if ($type == 0 || $type == 'get') {
            return $curl->get($url, $params);
        } else if ($type == 1 || $type == 'post') {
            $params = http_build_query($params);
            return $curl->post($url, $params);
        } else if ($type == 2 || $type == 'json') {
            return $curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'))
                    ->post($url, $params);
        } else if ($type == 3 || $type == 'postimg') {
            return $curl->post($url, $params);
        } else {
            return false;
        }

    }






    /**
     * send http request
     * @param  array $rq http请求信息
     *                   url        : 请求的url地址
     *                   method     : 请求方法，'get', 'post', 'put', 'delete', 'head'
     *                   data       : 请求数据，如有设置，则method为post
     *                   header     : 需要设置的http头部
     *                   host       : 请求头部host
     *                   timeout    : 请求超时时间
     *                   cert       : ca文件路径
     *                   ssl_version: SSL版本号
     * @return string    http请求响应
     */
     function send($rq) {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $rq['url']);
        switch (true) {
            case isset($rq['method']) && in_array(strtolower($rq['method']), array('get', 'post', 'put', 'delete', 'head')):
                $method = strtoupper($rq['method']);
                break;
            case isset($rq['data']):
                $method = 'POST';
                break;
            default:
                $method = 'GET';
        }
        $header = isset($rq['header']) ? $rq['header'] : array();
        $header[] = 'Method:'.$method;
        // $header[] = 'User-Agent:'.Conf::getUA();
        isset($rq['host']) && $header[] = 'Host:'.$rq['host'];
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, $method);
        isset($rq['timeout']) && curl_setopt($curlHandle, CURLOPT_TIMEOUT, $rq['timeout']);
        isset($rq['data']) && in_array($method, array('POST', 'PUT')) && curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $rq['data']);
        $ssl = substr($rq['url'], 0, 8) == "https://" ? true : false;
        if( isset($rq['cert'])){
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER,true);
            curl_setopt($curlHandle, CURLOPT_CAINFO, $rq['cert']);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST,2);
            if (isset($rq['ssl_version'])) {
                curl_setopt($curlHandle, CURLOPT_SSLVERSION, $rq['ssl_version']);
            } else {
                curl_setopt($curlHandle, CURLOPT_SSLVERSION, 4);
            }
        }else if( $ssl ){
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER,false);   //true any ca
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST,1);       //check only host
            if (isset($rq['ssl_version'])) {
                curl_setopt($curlHandle, CURLOPT_SSLVERSION, $rq['ssl_version']);
            } else {
                curl_setopt($curlHandle, CURLOPT_SSLVERSION, 4);
            }
        }
        $ret = curl_exec($curlHandle);
        curl_close($curlHandle);
        return $ret;
    }