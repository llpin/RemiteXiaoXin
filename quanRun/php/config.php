<?php

$config		= array(
	##数据库配置
	'dbhost'		=> 'localhost',	//数据库地址
	'dbname'		=> 'quanrun_school',		//数据库名
	'dbport'		=> '3306',			//数据库端口
	'dbuser'		=> 'root',			//数据库用户名
	'dbpass'		=> 'www.quanrun.com@llpin',	//数据库密码
	'isonlyopenid'	=> false,			//是否静默方式只获取用户opendid（true，false；）
	'debug'			=> false,			//是否开启debug模式
);

##根据链接分配公众号授权
	##ar案例公众号
	$config['appid']	= "wxd06b6d098e94c0d7";
	$config['secret']	= "59e9db8ab10a8418393531e0a03218b9";

return $config;
