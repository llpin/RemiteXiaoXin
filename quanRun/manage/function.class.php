<?php
/////////////////////
//下午1:51:54
//@author:752097512@qq.com
////////////////////
function checklogin(){
	if(!$_SESSION['login']){
		header("Location:./login.php");
	}
}