<?php
session_start ();
set_time_limit ( 0 );
error_reporting ( E_ERROR );
include './../php/function.php';
include './../php/database.class.php';
$config = include './../php/config.php';
global $Db;
$Db = new database ( $config );
$page = $_REQUEST ['page'] ?  : 1;
$keyword = $_REQUEST ['keyword'];
if(empty($_SESSION['login'])){
	header("Location:./login.php");
}
//$page_num	= ceil($num['num']/20);
//if(empty($_REQUEST['page'])){
//	$page	= 1;
//}else{
//	$page	= $_REQUEST['page'];
//	if($page+0 <= 0){
//		$page	=1;
//	}elseif($page+0 >$page_num){
//		$page 	= $page_num;
//	}else{
//		$page	= $page;
//	}
//}
//echo $page;
//$first_page		= ($page-1)*20;
//$data 	= $Db->getAll("select * from draw_info order by id asc limit $first_page,20");

	
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
	<style>
		input[type="text"]{
			width: 150px;
		}
	</style>
</head>
<body>

<!--Header-part-->
<div id="header">
	<h1>
		<a href="#">成绩管理</a>
	</h1>
</div>
<!--close-Header-part-->


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
	<ul class="nav">
		<li class=""><a title="" href="login.php"><i
						class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
	</ul>
</div>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
</div>
<div id="sidebar">

	<ul>
		<li class="active"><a href="index.php"><i class="icon icon-home"></i>
				<span>课程内容设置</span></a></li>
		<li class="active"><a href="bank.php"><i class="icon icon-home"></i>
				<span>课程题库设置</span></a></li>
		<li class="active"><a href="code.php"><i class="icon icon-home"></i>
				<span>邀请码设置</span></a></li>
		<li class="active"><a href="export.php"><i class="icon icon-home"></i>
				<span>成绩管理</span></a></li>
	</ul>

</div>

	<!--sidebar-menu-->

	<!--main-container-part-->
	<div id="content">
		<!--breadcrumbs-->
		<div id="content-header">
		</div>
		<!--End-breadcrumbs-->
		<div class="widget-box span9" style="width:1200px;">
			<div class="widget-title">
				<span class="icon"> <i class="icon-th"></i>
				</span>
			</div>
			<div class="widget-content nopadding" style="min-height: 800px;">

			<form id="maxnum" method="post" action="" enctype="multipart/form-data">
				<table class="table table-bordered table-striped">
					<div style="height:10px;"></div>
				</table>
				<table class="table table-bordered table-striped">
					<div style="height:10px;"></div>
					<tr>
						<td><h4>成绩管理</h4></td>

					</tr><tr>
						<td >
							&nbsp;&nbsp;&nbsp;&nbsp;<button><a  href="../api1.php?a=submitExcel" >成绩导出</a></button>
						</td>

					</tr>
				</table>

				</div>

			</div> 

		</div>

		<!--end-main-container-part-->

		<!--Footer-part-->

		<div class="row-fluid">
			<div id="footer" class="span12">2017 &copy; H5后台管理系统</div>
		</div>

		<!--end-Footer-part-->

		<script src="js/excanvas.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.ui.custom.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.flot.min.js"></script>
		<script src="js/jquery.flot.resize.min.js"></script>
		<script src="js/jquery.peity.min.js"></script>
		<script src="js/fullcalendar.min.js"></script>
		<script src="js/matrix.js"></script>
		<script src="js/matrix.dashboard.js"></script>
		<script src="js/jquery.gritter.min.js"></script>
		<script src="js/matrix.interface.js"></script>
		<script src="js/matrix.chat.js"></script>
		<script src="js/jquery.validate.js"></script>
		<script src="js/matrix.form_validation.js"></script>
		<script src="js/jquery.wizard.js"></script>
		<script src="js/jquery.uniform.js"></script>
		<script src="js/select2.min.js"></script>
		<script src="js/matrix.popover.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/matrix.tables.js"></script>

	<!--	<script type="text/javascript">
			$("#submitExcel").click(function(){
				$.ajax({
					cache: true,
					type: "POST",
					url:"../api1.php?a=submitExcel",

					success: function(data) {
//						window.location.href =("data/"+data.info);
					}
				});
			})

		</script>-->

</body>
</html>
