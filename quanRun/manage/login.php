<?php 
//php初始化
include '../php/function.php';
include '../php/database.class.php';
$config=include '../php/config.php';
global $Db;
$Db=new database($config);
$error=0;
if($_POST){
	session_start();
	error_reporting(E_ERROR);
	define('NAME', 'admin');
	define('PASS', 'admin_2017');

	$name			= $_REQUEST['name'];
	$pass			= $_REQUEST['pass'];

		if($pass==PASS && $name==NAME) {
			$_SESSION['login'] 		= true;
			header('Location:./index.php');

		}else{
			$error=1;
		}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>后台管理系统</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="css/jquery.gritter.css" />
<!-- 
<link 	href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800'	rel='stylesheet' type='text/css'>
-->
</head>
<body>

	<div class="row-fluid">
	
		<div class="container " >
			<form style="margin: 300px auto;width:300px;" id="login" method="post" action="">
				<div class="form-group">
					<label>用户名</label><input	type="text" class="form-control" id="name" name="name" placeholder="用户名">
				</div>
				<div class="form-group">
					<label>密码</label> <input
						type="password" class="form-control" id="pass"
						placeholder="密码" name="pass">
				</div>				
				<p style="padding:0 80px;"><button type="button" class="btn btn-success">登陆</button></p>
			</form>
		</div>
	</div>


	<!--Footer-part-->

	<div class="row-fluid">
		<div id="footer" class="span12">2017 &copy;后台管理系统</div>
	</div>

	<!--end-Footer-part-->

	<script src="js/excanvas.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script>
			$(".btn").click(function(){
				var name=$("#name").val()
				var pass=$("#pass").val()
				if(!name){
					$("#name").focus();
					return false;
					}
				if(!pass){
					$("#pass").focus();
					return false;
					}
				$("#login").submit();
				})
			<?php 
			if($error==1){
				echo "alert('用户名或密码错误');";
			}
		?>
	</script>

</body>
</html>
