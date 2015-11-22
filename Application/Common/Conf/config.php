<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库配置 */
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'wxsearch',
    'DB_USER' => 'root',
    'DB_PWD' => '',
    'DB_PORT' => '3306',
    'DB_PREFIX' => 'wx_',

    'MODULE_ALLOW_LIST' => array('Admin', 'Home'),
    'DEFAULT_MODULE' => 'Admin',
//    'DEFAULT_CONTROLLER' => 'Index', // 默认控制器名称
    'DEFAULT_ACTION' => 'index', // 默认操作名称


    //微信配置
    'APP_ID' => 'wxb383ceff8cdf7068',
    'APP_SECRET' => '219f2567cc628f344a37812957aee96a',

    //获取用户基本信息code的url
    'ACCESS_USER_INFO_URL' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb383ceff8cdf7068&redirect_uri=http://wxsearch.sentiger.com/index.php/Home/Index/index&response_type=code&scope=snsapi_base &state=STATE#wechat_redirect',
    //获取网页授权确认code
    'ACCESS_FULL_USER_INFO_URL' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb383ceff8cdf7068&redirect_uri=http://wxsearch.sentiger.com/index.php/Home/Index/index&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect',



);