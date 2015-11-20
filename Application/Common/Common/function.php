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



    function getAccessToken(){  
     $AppId = '1232assad13213123';  
     $AppSecret = '2312312321adss3123213';  
     $getUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$AppId.'&secret='.$AppSecret;  
     $ch = curl_init();  
     curl_setopt($ch, CURLOPT_URL, $getUrl);  
     curl_setopt($ch, CURLOPT_HEADER, 0);  
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
     curl_setopt($ch, CURL_SSLVERSION_SSL, 2);  
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
     $data = curl_exec($ch);  
     $response = json_decode($data);  
     return $response->access_token;  
 } 