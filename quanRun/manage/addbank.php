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
		<a href="#">课程题库添加</a>
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
			<form id="maxnum" method="post" action="" enctype="multipart/form-data">
				<table class="table table-bordered table-striped">
					<div style="height:10px;"></div>
				</table>
				<table class="table table-bordered table-striped">
					<div style="height:10px;"></div>
					<tr>
						<td><h4>课程题库添加</h4>
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
					<td style="width: 200px;display: inline-block;">课程：
						<select style="width: 80px;display: inline-block;" id="kcSelect">
							<option  value="" >请选择</option>
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;第 <input style="width:15px;" readonly="readonly" type="text" class="no" name="no" value=""> 题
					</td>
				</table>
				<table class="table table-bordered table-striped">
					<div style="height:10px;"></div>
					<tr>
						<td>
							题目图片:<input  id="sale_img" type="file" name="img"  />
							<img src=""  class="sale_img_src" />
						</td>
					</tr>
					<tr>
						<td >题目:<input  style="width:280px;" type="text" class="Question" name="Question" >
						</td>
						<td >选项:A <input style="width:120px;" type="text" class="A" name="A" ></td>
						<td >B <input style="width:120px;" type="text" class="B" name="B" ></td>
						<td >C <input style="width:120px;" type="text" class="C" name="C" ></td>
						<td >D <input style="width:120px;" type="text" class="D" name="D" ></td>
						<td >答案: <input list="pasta" style="width:45px;" type="text" class="Answer" name="Answer" ></td>
						<datalist id="pasta">
							<option>A</option>
							<option>B</option>
							<option>C</option>
							<option>D</option>
						</datalist>
						<td >分数: <input style="width:35px;" type="text" class="fs" name="fs" ></td>
						<td ><button type="button" class="submit"  value="添加">添加</button></td>
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
	//题目图片
	function readFile(obj){
		var file = obj.files[0];	//判断类型是不是图片
		if(!/image\/\w+/.test(file.type)){
			alert("请确保文件为图像类型");
			return false;
		}
		var reader = new FileReader();
		reader.readAsDataURL(file);
		reader.onload = function(e){
			$(".sale_img_src").prop("src",this.result);
		}
	}
	var files,file;
	$("#sale_img").change(function(){
		readFile(this);
		files = event.target.files;
	});
	//添加
	$(".submit").click(function(){
		var sale_img	= $(".sale_img_src").prop("src");
		var options     = $("#nanduSelect").val();
		var kc			= $("#kcSelect").val();
		var no			= $(".no").val();
		var Question	= $(".Question").val();
		var A			= $(".A").val();
		var B			= $(".B").val();
		var C			= $(".C").val();
		var D			= $(".D").val();
		var Answer		= $(".Answer").val();
		var fs			= $(".fs").val();
		if(options == null || options == "" || options == "请选择"){
			alert("请选择难度！！！");
			return false;
		}
		if(kc == null || kc == ""|| kc == "请选择"){
			alert("请选择课程！！！");
			return false;
		}
		if(Question == null || Question == " "|| Question == ""){
			alert("请填写题目！！！");
			return false;
		}
		if(A == null || A == " "|| A == "" || B == null || B == " "|| B == "" || C == null || C == " "|| C == "" || D == null || D == " "|| D == ""){
			alert("请填写选项！！！");
			return false;
		}
		if(Answer == null || Answer == " "|| Answer == ""){
			alert("请填写答案！！！");
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
						url: "../api1.php?a=su",
						data: {
							'image': sale_img,
							'options': options,
							'kc': kc,
							'no': no,
							'Question': Question,
							'A': A,
							'B': B,
							'C': C,
							'D': D,
							'Answer': Answer,
							'fs': fs
						},
						success: function (data) {
							alert(data.info);
							window.location.reload();
						}
					});
				}
			});
		}
	});

	//选择难度
	$("#nanduSelect").change(function () {
		var options = $(this).children('option:selected').val();
		if(options == null || options == ""){
			return false;
		}
		$.ajax({
			cache: true,
			type: "POST",
			url:"../api1.php?a=xz",
			data:{'options':options},
			success: function(data) {
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
			return false;
		}
		var options     = $("#nanduSelect").val();
		$.ajax({
			cache: true,
			type: "POST",
			url:"../api1.php?a=kc",
			data:{'kc':kc,'options':options},
			success: function(data) {
				$(".no").val(data.data.no);
			}
		})
	});

</script>

</body>
</html>