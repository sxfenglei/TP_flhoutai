<?php
return array(
	//'配置项'=>'配置值'
	//显示调试信息
	'SHOW_PAGE_TRACE'=>true,
	'PAGE_NUM'=>20,
	'UPLOAD_PATH'=>'Public/uploads/',

	//定义静态变量
	'TMPL_PARSE_STRING'=>array(
		'__PLUGIN__'=>__ROOT__.'/Plugin',
	),

	//数据库配置 
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => 'localhost', // 服务器地址
	'DB_NAME'   => 'fl_houtai', // 数据库名
	'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '1234', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'fl_', // 数据库表前缀 
	'DB_CHARSET'=> 'utf8', // 字符集
	'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增
	  
	//权限验证设置
	'AUTH_CONFIG'=>array(
        'AUTH_ON' => true, 		//认证开关
        'AUTH_TYPE' => 1, 		// 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'fl_auth_group', 				//用户组数据表
        'AUTH_GROUP_ACCESS' => 'fl_auth_group_access', 	//用户组拥有的权限表
        'AUTH_RULE' => 'fl_auth_rule', 					//权限规则表
        'AUTH_USER' => 'fl_admin'						//用户信息表
    ),
    //指定拥有全部权限的超级管理员id.可以设置多个值,如array('1','2','3'),
    'ADMINISTRATOR'=>array('1'),
);