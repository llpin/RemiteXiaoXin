<?php
//ini_set("session.save_handler", "memcache");
//ini_set("session.save_path", "tcp://d02f7ef2dca84c46.m.cnszalist3pub001.ocs.aliyuncs.com:11211");
session_start();
error_reporting(E_ERROR);
date_default_timezone_set('Asia/Chongqing');
include './php/function.php';
include './php/database.class.php';
$config=include './php/config.php';
global $Db;
$Db=new database($config);
header('Access-Control-Allow-Origin:*');
$openid=$_SESSION['openid'];;
//防止未及时关闭测试


$type=$_REQUEST['a']?:'start';

function read($filename,$encode='utf-8'){
	$objReader = PHPExcel_IOFactory::createReader('Excel5');
	$objReader->setReadDataOnly(true);
	$objPHPExcel = $objReader->load($filename);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$highestRow = $objWorksheet->getHighestRow();
	$highestColumn = $objWorksheet->getHighestColumn();
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	$excelData = array();
	for ($row = 1; $row <= $highestRow; $row++) {
		for ($col = 0; $col < $highestColumnIndex; $col++) {
			$excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
		}
	}
	return $excelData;
}

try{
	/*--------课程内容添加--------*/
	//选择难度
	if($type == 'options'){
		$options		= $_REQUEST['options'];
		$data = $Db->getOne("select count(*) as num from quanrun_course where options='$options'");
		showsuc("options",array('num'=>$data['num']));
	}
	//添加课程和内容
	if($type == 'sub'){
		$options		= $_REQUEST['options'];
		$kc				= $_REQUEST['kc'];
		$content		= $_REQUEST['content'];
		$image			= $_REQUEST['image'];
		if($options =="小白"){
			$type  = 1;
		}
		if($options =="小咖"){
			$type  = 2;
		}
		if($options =="大师"){
			$type  = 3;
		}
		if($options =="专题"){
			$type  = 4;
		}
		$res  	 = $Db->getOne("SELECT distinct profile FROM quanrun_course where options='$options'");
		$profile = $res['profile'];
		$data = $Db->getOne("SELECT * FROM quanrun_course where type='$type' and kc='$kc'");
		if(!$data){
			$Db->add("quanrun_course",array('options'=>$options,'type'=>$type,'profile'=>$profile,'kc'=>$kc,'image'=>$image,'content'=>$content));
			showsuc("保存成功",array('status'=>1));
		}
	}
	/*--------			--------*/

	/*--------课程内容修改--------*/
	//选择课程
	if($type == 'course'){
		$kc				= $_REQUEST['kc'];
		$options		= $_REQUEST['options'];
		$info = $Db->getOne("SELECT content,image FROM quanrun_course where options='$options' and kc='$kc'");
		showsuc("内容",array('info'=>$info['content'],'image'=>$info['image']));
	}
	//修改简介
	if($type == 's'){
		$options		= $_REQUEST['options'];
		$profile		= $_REQUEST['profile'];
		$Db->update("quanrun_course",array('profile'=>$profile),"options='$options'");
		showsuc("修改成功",array('status'=>1));
	}
	//修改内容
	if($type == 'Submit'){
		$kc				= $_REQUEST['kc'];
		$options		= $_REQUEST['options'];
		$content		= $_REQUEST['content'];
		$image			= $_REQUEST['image'];
		$Db->update("quanrun_course",array('content'=>$content,'image'=>$image),"kc='$kc' and options='$options'");
		showsuc("修改成功",array('status'=>1));
	}
	/*--------			--------*/

	/*--------课程题库添加--------*/
	//选择难度
	if($type == 'xz'){
		$options		= $_REQUEST['options'];
		$data = $Db->getAll("select distinct kc from quanrun_course where options='$options'");
		$res  = $Db->getOne("SELECT distinct profile FROM quanrun_course where options='$options'");
		showsuc("课程",array('kc'=>$data,'profile'=>$res));
	}
	//选择课程
	if($type == 'kc'){
		$kc				= $_REQUEST['kc'];
		$options		= $_REQUEST['options'];
		if($options =="小白"){
			$type  = 1;
		}
		if($options =="小咖"){
			$type  = 2;
		}
		if($options =="大师"){
			$type  = 3;
		}
		if($options =="专题"){
			$type  = 4;
		}
		$data = $Db->getOne("SELECT count(*)+1 as num FROM `quanrun_question` where type='$type' and kc='$kc'");
		showsuc("题号",array('no'=>$data['num']));
	}
	//添加题库
	if($type == 'su'){
		$options		= $_REQUEST['options'];
		$kc				= $_REQUEST['kc'];
		$no				= $_REQUEST['no'];
		$Question		= $_REQUEST['Question'];
		$A				= $_REQUEST['A'];
		$B				= $_REQUEST['B'];
		$C				= $_REQUEST['C'];
		$D				= $_REQUEST['D'];
		$Answer			= $_REQUEST['Answer'];
		$image			= $_REQUEST['image'];
		$fs				= $_REQUEST['fs'];
		if($options =="小白"){
			$type  = 1;
		}
		if($options =="小咖"){
			$type  = 2;
		}
		if($options =="大师"){
			$type  = 3;
		}
		if($options =="专题"){
			$type  = 4;
		}
		$data = $Db->getOne("SELECT * FROM `quanrun_question` where type='$type' and kc='$kc' and no='$no'");
		if(!$data){
			$Db->add("quanrun_question",array('type'=>$type,'kc'=>$kc,'no'=>$no,'Question'=>$Question,'A'=>$A,'B'=>$B,'C'=>$C,'D'=>$D,'Answer'=>$Answer,'image'=>$image,'fs'=>$fs));
			showsuc("保存成功",array('status'=>1));
		}
	}
	/*--------			--------*/

	/*--------课程题库修改--------*/
	//选择课程
	if($type == 'xzkc'){
		$options		= $_REQUEST['options'];
		$kc				= $_REQUEST['kc'];
		if($options =="小白"){
			$type  = 1;
		}
		if($options =="小咖"){
			$type  = 2;
		}
		if($options =="大师"){
			$type  = 3;
		}
		if($options =="专题"){
			$type  = 4;
		}
		$info = $Db->getAll("SELECT * FROM quanrun_question where type='$type' and kc='$kc'");
//		$res  = $Db->getOne("SELECT count(*) as num FROM quanrun_question where type='$type' and kc='$kc'");
//		$info['num']=$res['num'];
		showsuc("题目",array('info'=>$info));
	}
	//修改题库
	if($type == 'title'){
		$options		= $_REQUEST['options'];
		$kc				= $_REQUEST['kc'];
		$no				= $_REQUEST['no'];
		$Question		= $_REQUEST['Question'];
		$A				= $_REQUEST['A'];
		$B				= $_REQUEST['B'];
		$C				= $_REQUEST['C'];
		$D				= $_REQUEST['D'];
		$Answer			= $_REQUEST['Answer'];
		$fs				= $_REQUEST['fs'];
		if($options =="小白"){
			$type  = 1;
		}
		if($options =="小咖"){
			$type  = 2;
		}
		if($options =="大师"){
			$type  = 3;
		}
		if($options =="专题"){
			$type  = 4;
		}
		$Db->update("quanrun_question",array('Question'=>$Question,'A'=>$A,'B'=>$B,'C'=>$C,'D'=>$D,'Answer'=>$Answer,'fs'=>$fs),"type='$type' and kc='$kc' and no='$no'");
		showsuc("保存成功",array('status'=>1));
	}

	if($type == 'sc'){
		$options		= $_REQUEST['options'];
		$kc				= $_REQUEST['kc'];
		$no				= $_REQUEST['no'];
		$image			= $_REQUEST['image'];
		if($options =="小白"){
			$type  = 1;
		}
		if($options =="小咖"){
			$type  = 2;
		}
		if($options =="大师"){
			$type  = 3;
		}
		if($options =="专题"){
			$type  = 4;
		}
		$Db->update("quanrun_question",array('image'=>$image),"type='$type' and kc='$kc' and no='$no'");
		showsuc("上传成功");
	}
	/*--------			--------*/

	//导入邀请码
	if($type == 'uploadExcel'){
//		printp($_FILES);
		include 'PHPExcel/PHPExcel.php';
		$tmp_file = $_FILES ['excel'] ['tmp_name'];
		$file_types = explode ( ".", $_FILES ['excel'] ['name'] );
		$file_type = $file_types [count ( $file_types ) - 1];
		/*判别是不是.xls文件，判别是不是excel文件*/
		if (strtolower ( $file_type ) != "xls")
		{
			showsuc("不是Excel文件，重新上传",array('status'=>0));
		}
		/*设置上传路径*/
		$arr	  = explode("/api1.php",$_SERVER['SCRIPT_NAME']) ;
		$savePath = './upfile/';
		/*以时间来命名上传的文件*/
		$str = date ( 'Ymdhis' );
		$file_name = $str . "." . $file_type;
		/*是否上传成功*/

		if (! copy ( $tmp_file, $savePath . $file_name ))
		{
			showsuc("上传失败",array('status'=>0));
		}
		/*
           *对上传的Excel数据进行处理生成编程数据,这个函数会在下面第三步的ExcelToArray类中
          注意：这里调用执行了第三步类里面的read函数，把Excel转化为数组并返回给$res,再进行数据库写入
        */
		$res = read ( $savePath . $file_name );
		/*
             重要代码 解决Thinkphp M、D方法不能调用的问题
             如果在thinkphp中遇到M 、D方法失效时就加入下面一句代码
         */
		//spl_autoload_register ( array ('Think', 'autoload' ) );
		/*对生成的数组进行数据库的写入*/
		foreach ( $res as $k => $v )
		{
			if ($k != 0)
			{
				$data			= array();
				$data ['code'] = $v [0];
				$data ['firm'] = $v [1];

				$tem 			= $Db->getOne("select * from quanrun_code where code='".$data ['code']."' and firm='".$data ['firm']."'");
				if(empty($tem)){
					$result		= $Db->add("quanrun_code",$data);
					if (! $result)
					{
						showsuc("上传失败",array('status'=>0));
					}
				}
			}
		}
		showsuc("上传成功",array('status'=>1));
	}

	//导出
	if($type == 'submitExcel'){

		// csv title
		$csv_str = '';
		$csv_str = chr(0xEF).chr(0xBB).chr(0xBF);
		$csv_str .= " 微信昵称,真实姓名,公司, 岗位,手机号码,邮箱,邀请码,难度, 课程, 分数, 时间  \n";
		$data		= $Db->getAll("select b.nickname,b.name,b.post,b.phone,b.email,b.code,b.firm,a.type,a.kc,a.score,a.create_time from quanrun_fs as a,quanrun_info as b
										where a.openid = b.openid and a.score is not null ORDER BY a.type asc ,a.kc asc, a.score DESC ");
		// 拼接csv
		foreach ($data as $key => $values) {
			if($values['type']  == 1){
				$values['type'] ="小白" ;
			}
			if($values['type']  == 2){
				$values['type'] ="小咖" ;
			}
			if($values['type']  == 3){
				$values['type'] ="大师" ;
			}
			if($values['type']  == 4){
				$values['type'] ="专题" ;
			}
			$csv_str .= "\"".
					$values['nickname']."\",\"".
					$values['name']."\",\"".
					$values['firm']."\",\"".
					$values['post']."\",\"".
					$values['phone']."\",\"".
					$values['email']."\",\"".
					$values['code']."\",\"".
					$values['type']."\",\"".
					$values['kc']."\",\"".
					$values['score']."\",\"".
					$values['create_time']."\",\n";
		}
		$filename = date('YmdHis').'.csv';

		header("Content-type:text/csv");
		header("Content-Type: applicationnd.ms-excel; charset=utf-8");
		header("Content-Disposition:attachment;filename=".$filename);
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		//$objWriter->save('php://output'); 
		echo $csv_str;

	}



}catch (Exception $e){
	showerr($e->getMessage());
}
?>