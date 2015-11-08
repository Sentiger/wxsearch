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
);