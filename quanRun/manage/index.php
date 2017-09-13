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
$data	= $Db->getAll("select * from quanrun_course ");

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
	<style>
		.sale_img_src{    max-width: 300px;
			max-height: 100px;}
	</style>
</head>
<body>

	<!--Header-part-->
	<div id="header">
		<h1>
			<a href="#">课程内容设置</a>
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
		<div class="widget-box span9" >
			<div class="widget-title">
				<span class="icon"> <i class="icon-th"></i>
				</span>
			</div>
			<div class="widget-content nopadding" style="min-height: 800px;">
				<form id="maxnum" method="post" action="../api1.php?a=Submit" enctype="multipart/form-data">
					<table class="table table-bordered table-striped">
						<div style="height:10px;"></div>
					</table>
					<table class="table table-bordered table-striped">
						<div style="height:10px;"></div>
						<tr>
							<td><h4>课程内容修改</h4><button type="button" id="add" value="添加">添加</button></td>
						</tr>
						<td style="width: 150px;display: inline-block;">难度：
							<select style="width: 80px;display: inline-block;" id="nanduSelect">
								<option  value="" >请选择</option>
								<option  value="小白" >小白</option>
								<option  value="小咖" >小咖</option>
								<option  value="大师" >大师</option>
								<option  value="专题" >专题</option>
							</select>
						</td>
						<tr>
							<td style="width: 80%" >简介: <input style="width:90%" type="text" class="profile" name="profile" value=""></td>
							<td ><button type="button" class="sub"  value="修改">修改</button></td>
						</tr>
					</table>

					<table class="table table-bordered table-striped">
						<div style="height:10px;"></div>
						<td style="width: 200px;display: inline-block;">课程：
							<select style="width: 80px;display: inline-block;" id="kcSelect">
								<option  value="" >请选择</option>
							</select>
						</td>
						<tr>
							<td>
								商品图片:<input  id="sale_img"  type="file" name="img"  value=""/>

								<img src=""  class="sale_img_src"  />
							</td>
						</tr>
						<tr>
							<td style="width: 80%" >课程介绍: <input style="width:90%" type="text" class="content" name="content" value=""></td>
							<td ><button type="button" class="submit"  value="修改">修改</button></td>
						</tr>
					</table>
			</div>
			</form>

			</div>
		</div>
	</div>
		<!--end-main-container-part-->

		<!--Footer-part-->

		<div class="row-fluid">
			<div id="footer" class="span12">2017 &copy; 后台管理系统</div>
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

	<script>
		function readFile(obj){
			var file = obj.files[0];
			//判断类型是不是图片
			if(!/image\/\w+/.test(file.type)){
				alert("请确保文件为图像类型");
				return false;
			}
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function(e){
//					console.log(this.result); //就是base64
				$(".sale_img_src").prop("src",this.result);
			}
		}
		var files,file;
		$("#sale_img").change(function(){
			readFile(this);
			files = event.target.files;
		});

		//课程内容修改
		$(".submit").click(function(){
			var sale_img	= $(".sale_img_src").prop("src");
			var options     = $("#nanduSelect").val();
			var kc     		= $("#kcSelect").val();
			var content		= $(".content").val();
			if(options == null || options == "" || options == "请选择"){
				alert("请选择难度！！！");
				return false;
			}
			if(kc == null || kc == ""|| kc == "请选择"){
				alert("请选择课程！！！");
				return false;
			}
			if(content == null || content == ""|| content == " "){
				alert("请填写内容！！！");
				return false;
			}
			if (files && files.length > 0) {
				file = files[0];    //file就是图片file
				var fd = new FormData();
				fd.append('file', file);
				$.ajax({
					type: "POST",
					url: "../upload.php?a=upload_base64",
					data: fd,
					processData: false,  // 不处理数据
					contentType: false,   // 不设置内容类型
					success: function (data) {
						var sale_img = data.data.url;
						$.ajax({
							cache: true,
							type: "POST",
							url: "../api1.php?a=Submit",
							data: {'options': options, 'kc': kc, 'content': content, 'image': sale_img},
							success: function (data) {
								alert(data.info);
								if (data.data.status == 1) {
									window.location.reload();
								}
							}
						})
					}
				});
			}
		});

		//课程简介修改
		$(".sub").click(function(){
			var options     = $("#nanduSelect").val();
			var profile		= $(".profile").val();
			if(options == null || options == "" || options == "请选择"){
				alert("请选择难度！！！");
				return false;
			}
			if(profile == null || profile == ""|| profile == " "){
				alert("请填写简介！！！");
				return false;
			}
			$.ajax({
				cache: true,
				type: "POST",
				url:"../api1.php?a=s",
				data:{'options':options,'profile':profile},
				success: function(data) {
					alert(data.info);
					if(data.data.status == 1 ){
						window.location.reload();
					}
				}
			})
		});

		//选择难度
		$("#nanduSelect").change(function () {
			var options = $(this).children('option:selected').val();
			$(".content").val("");
			if(options == null || options == ""){
				return false;
			}
			$.ajax({
				cache: true,
				type: "POST",
				url:"../api1.php?a=xz",
				data:{'options':options},
				success: function(data) {
					$(".profile").val(data.data.profile.profile);
					var html = "";
					html += '<option  value="" >请选择</option>';
					$.each(data.data.kc,function(k,v){
						html += '<option  value="'+v.kc+'" >'+v.kc+'</option>';
					});
					$("#kcSelect").html(html);
				}
			})
		});
		//选择课程
		$("#kcSelect").change(function () {
			var kc = $(this).children('option:selected').val();
			if(kc == null || kc == ""){
				$(".content").val("");
				return false;
			}
			var options     = $("#nanduSelect").val();
			$.ajax({
				cache: true,
				type: "POST",
				url:"../api1.php?a=course",
				data:{'kc':kc,'options':options},
				success: function(data) {
					console.log(data);
					$(".content").val(data.data.info);
					$("img").attr("src",'../'+data.data.image);
				}
			})
		});

		$("#add").click(function() {
			window.location.href="addindex.php";
		});
	</script>

</body>
</html>