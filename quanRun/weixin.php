<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>
<?php
error_reporting(E_ERROR);
date_default_timezone_set('Asia/Chongqing');
include './php/WeixinAction.php';
include './php/database.class.php';
include './php/function.php';
$config				= require './php/config.php';
session_start ();
if(empty($_SESSION['_GET'])){
	$_SESSION['_GET']=$_GET;//所有url的参数都放入session里面
}

$Db					= new database($config);
$weixin 			= new WeixinAction ($config,$Db);
$weixin->_getAccessToken();

if($_SESSION['openid']){
	$sql 			= "select * from userinfo where openid='" . $_SESSION ['openid'] . "'";
	$userinfo 		= $Db->getAll ( $sql );
}
if (! $_SESSION ['openid'] || empty($userinfo[0])) {
	// openid不存在或者找不到相关用户记录
	if (! $_REQUEST ['code']) {
		$weixin->_getWeixinCode ();
	} else {
		$code 		= $_REQUEST ['code'];
		$user_info 	= $weixin->_getWeixinUserInfo ( $code );
		if ($user_info ['openid']) {
			// 将openid保存到session中
			$_SESSION ['openid'] = $user_info ['openid'];
			$sql 		= "select * from userinfo where openid='" . $user_info ['openid'] . "'";
			$users 		= $Db->getAll ( $sql );
			$nickname 	= removeEmoji($user_info ['nickname']); // 昵称
			$openid 	= $user_info ['openid'];
			$headimgurl = $user_info ['headimgurl']; // 头像地址
			$sex 		= $user_info ['sex']; // 性别
			$province 	= $user_info ['province']; // 用户个人资料填写的省份
			$city 		= $user_info ['city']; // 普通用户个人资料填写的城市
			$country 	= $user_info ['country']; // 国家，如中国为CN
			
			if ($users) {
				$id 	= $users [0] ['id'];
				$sql 	= "update userinfo set nickname='{$nickname}',openid='{$openid}',headimgurl='{$headimgurl}',sex='{$sex}',province='{$province}',city='{$city}',country='{$country}' where id='{$id}'";
				$Db->execute ( $sql );
			} else {
				$sql 	= "insert into userinfo(nickname,openid,headimgurl,sex,province,city,country) values('{$nickname}','{$openid}','{$headimgurl}','{$sex}','{$province}','{$city}','{$country}')";
				$Db->execute ( $sql );
			}
			$_SESSION['userinfo']=$user_info;
		}elseif ($_SESSION['openid']){
			$sql 		= "select * from userinfo where openid='" . $_SESSION['openid'] . "'";
			$users 		= $Db->getAll ( $sql );
			if ($users) {
				
			} else {
				$sql 	= "insert into userinfo(openid) values('{$_SESSION['openid']}')";
				$Db->execute ( $sql );
			}
		}
	}
}else{
	$_SESSION['userinfo']=$userinfo[0];
}
$name 				= $userinfo [0] ['nickname']?$userinfo [0] ['nickname']:$nickname;
$openid 			= $userinfo [0] ['openid']?:$_SESSION['openid'];
$sex 				= $userinfo [0] ['sex']?:$sex;
$city 				= $userinfo [0] ['city']?:$city;
$country 			= $userinfo [0] ['country']?:$country;
$imgURL 			= $userinfo [0] ['headimgurl']?:$headimgurl;

##获取token
$appId              = $config['appid'];
$access				= $Db->getOne("select * from access where appid='{$appId}' limit 1");
$_SESSION['access'] = $access;
 
// echo "<script>window.localStorage.setItem('name','$name');</script>";
// echo "<script>window.localStorage.setItem('sex','$sex');</script>";
// echo "<script>window.localStorage.setItem('city','$city');</script>";
// echo "<script>window.localStorage.setItem('country','$country');</script>";
// echo "<script>window.localStorage.setItem('openid','$openid');</script>";
// echo "<script>window.localStorage.setItem('imgURL','$imgURL');</script>";
//所有get参数都放如localStorage 里面，方便前段调用
setcookie('name',$name,time()+600);
setcookie('openid',$openid,time()+600);
setcookie('imgURL',$imgURL,time()+600);
//所有get参数都放如localStorage 里面，方便前段调用
foreach ($_SESSION['_GET'] as $k=>$v){
	// echo "<script>window.localStorage.setItem('$k','$v');</script>";
	setcookie($k,$v,time()+600);
}

unset($_SESSION['_GET']);
##根据链接分配公众号授权
$Db->close();

header("Location:index.html");
// echo "<script>window.location='page5_subme.html'</script>";
die();
?>


</body>
</html>
