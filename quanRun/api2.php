<?php
ini_set("session.save_handler", "memcache");
ini_set("session.save_path", "tcp://d02f7ef2dca84c46.m.cnszalist3pub001.ocs.aliyuncs.com:11211");
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
//if(empty($openid) ){
//	$openid='oSckZwl3fTEDdeZDVavcOly-w9qE';
//}

$type=$_REQUEST['a']?:'start';
$user_info = $_SESSION['userinfo'];

// if(empty($openid)){
//showerr('未获取到用户openid');
//}
 
try{
	//登录
	if($type == 'login'){
		$phone= $_REQUEST['phone'];					//电话
		$password= $_REQUEST['password'];			//原密码
		$res = $Db->getOne("select * from quanrun_info where phone='$phone'");	//查询数据是否存在
		if($res){
			if($password==$res['password']){
				showsuc("登录成功");
			}else{
				showerr("原密码不正确");
			}
		}else{
			showerr("手机号码不正确");
		}
	}
	//个人中心
	if($type == 'data'){
		$phone= $_REQUEST['phone'];
		$res = $Db->getOne("select * from quanrun_info where phone='$phone'");
		if(empty($res['password'])){
			showsuc("个人中心" ,array('info' => $res,'password' =>1));
		}else{
			showsuc("个人中心" ,array('info' => $res,'password' =>0));
		}
	}
	//修改密码
	if($type == 'modify'){
		$phone= $_REQUEST['phone'];					//电话
		$password= $_REQUEST['password'];			//原密码
		$new_password= $_REQUEST['new_password'];	//新密码
		$res = $Db->getOne("select * from quanrun_info where phone='$phone' ");
		if($res){
			if($password==$res['password']){
				$Db->update("quanrun_info", array('password' =>$new_password),"phone='$phone'");
				showsuc("修改成功");
			}else{
				showerr("原密码不正确");
			}
		}else{
			showerr("手机号码不正确");
		}
	}
	//完善资料
	if($type == 'perfect'){
		$name= $_REQUEST['name'];    				//姓名
		$firm= $_REQUEST['firm'];					//公司
		$post= $_REQUEST['post'];					//岗位
		$phone= $_REQUEST['phone'];					//电话
		$code= $_REQUEST['code'];					//邀请码
		$email= $_REQUEST['email'];					//邮箱
		$password= $_REQUEST['password'];			//密码
		if(empty($password)){
			$Db->update("quanrun_info", array('name'=>$name,'firm'=>$firm,'post'=>$post,'code'=>$code,'email'=>$email),"phone='$phone'");
			showsuc("修改成功");
		}else{
			$Db->update("quanrun_info", array('name'=>$name,'firm'=>$firm,'post'=>$post,'code'=>$code,'email'=>$email,'password'=>$password),"phone='$phone'");
			showsuc("提交成功");
		}
	}
	//查看成绩
	if($type == 'score'){
		$phone= $_REQUEST['phone'];   //手机号码
		$res = $Db->getOne("select * from quanrun_info where phone='$phone'");
		$openid =$res['openid'];
		$data = $Db->getAll("select type,kc,max(score) from quanrun_fs where openid = '$openid' and score is not null group by type,kc");
		foreach ($data as $key => $values) {
			if($values['type']  == 1){
				$data[$key]['type'] ="小白" ;
			}
			if($values['type']  == 2){
				$data[$key]['type'] ="小咖" ;
			}
			if($values['type']  == 3){
				$data[$key]['type'] ="大师" ;
			}
			if($values['type']  == 4){
				$data[$key]['type'] ="专题" ;
			}
			$data[$key]['score']=$data[$key]['max(score)'];
		}
		showsuc("我的成绩" ,array('info' => $data));
	}

	//答题开始
	if($type == 'start'){
		$type 	 = $_REQUEST['type'];    //难度类型：1：小咖，2：大咖，3：大师，4：专家
		$phone	 = $_REQUEST['phone'];   //手机号码
		$profile = $Db->getAll("select * from quanrun_course where type='$type'");			//课程简介
		$res 	 = $Db->getAll("select * from quanrun_question where type='$type'");			//课程题目

		foreach($profile as $key=>$val){
			$number = $Db->getOne("SELECT count(*) as number FROM quanrun_fs WHERE type='$type' and kc='{$val['kc']}'"); //学习数
			$profile[$key]['number'] = $number['number'];
		}

		$rank = $Db->getOne("select * from quanrun_info where phone='$phone'");
		$code = $Db->getOne("select * from quanrun_code where firm='{$rank['firm']}' and code='{$rank['code']}'");
		if($type==4){
			if($code){
				showsuc("所有课程",array('profile'=>$profile));
			}else{
				showerr("您输入的邀请码不对或邀请码和公司不匹配");
			}
		}else{
			showsuc("所有课程",array('profile'=>$profile));
		}
//		$arr	= array();
//		$arr2	= $profile['profile'];
//			foreach($info as $key=>$val){
//				$arr[$key]['kc']				= $val['kc'];		    //课程
//				$arr[$key]['content']			= $val['content']; 		//内容
//				$arr[$key]['image']				= $val['image']; 		//图片
//				$arr[$key]['num']				= $val['num']; 			//课程关注数
//				$arr[$key]['help']				= $val['help']; 		//点赞数
//				$title=$Db->getAll("select * from quanrun_question where type='$type' and kc='{$val['kc']}'");
//				$number = $Db->getOne("SELECT count(*) as number FROM quanrun_fs WHERE type='$type' and kc='{$val['kc']}'");
//				$arr[$key]['number']				= $number['number']; 			//学习数
//				$arr1=array();
//				foreach($title as $k=>$v){
//					$arr1[$k]['image']			= $v['image'];			//图片
//					$arr1[$k]['no']				= $v['no'];				//题号
//					$arr1[$k]['Question']		= $v['Question'];		//题目
//					$arr1[$k]['A']				= $v['A'];				//选项
//					$arr1[$k]['B']				= $v['B'];
//					$arr1[$k]['C']				= $v['C'];
//					$arr1[$k]['D']				= $v['D'];
//					$arr1[$k]['Answer']			= $v['Answer'];			//答案
//					$arr1[$k]['fs']				= $v['fs'];				//分数
//				}
//				$arr[$key]['title'] =$arr1;
//			}
//		$rank = $Db->getOne("select * from quanrun_info where phone='$phone'");
//		$code = $Db->getOne("select * from quanrun_code where firm='{$rank['firm']}' and code='{$rank['code']}'");
//		if($type==4){
//			if($code){
//				showsuc("$arr2", array('info' => $arr));
//			}else{
//				showerr("您输入的邀请码不对或邀请码和公司不匹配");
//			}
//		}else{
//			showsuc("$arr2", array('info' => $arr));
//		}
	}
	//所有题目
	if($type=='content'){
		$type	=$_REQUEST['type'];		//难度类型：1：小咖，2：大咖，3：大师，4：专家
		$kc		=$_REQUEST['kc'];		//课程
		$phone	= $_REQUEST['phone'];   //手机号码
		$rank 	= $Db->getOne("select * from quanrun_info where phone='$phone'");
		$openid = $rank['openid'];
		$res	=$Db->getOne("select * from quanrun_fs where openid='$openid' and type='$type' and kc='$kc'");
		$number = $Db->getOne("SELECT count(*) as number FROM quanrun_question WHERE type='$type' and kc='$kc'");
		$rank = $Db->getOne("SELECT * FROM quanrun_course WHERE type='$type' and kc='$kc'");
		if(!$res){
			$info=$Db->getAll("select * from quanrun_question where type='$type' and kc='$kc'");
		}else{
			$info=$Db->getAll("select * from quanrun_question where type='$type' and kc='$kc' and no>'{$res['question_num']}'");
		}
		showsuc("所有题目",array('content'=>$info,'question_num'=>$res['question_num'],'number'=>$number['number'],'score'=>$res['score'],'help'=>$rank['help']));
	}
	//填写邀请码
	if($type == 'code'){
		$code = $_REQUEST['code'];	  //邀请码
		$phone= $_REQUEST['phone'];   //手机号码
		$Db->update("quanrun_info",array('code'=>$code),"phone='$phone'");
		$rank = $Db->getOne("select * from quanrun_info where phone='$phone'");
		$info = $Db->getOne("select * from quanrun_code where code='$code' and firm='{$rank['firm']}'");
		if($info){
			showsuc("填写邀请码成功，邀请码与公司匹配");
		}else{
			showsuc("填写邀请码成功，邀请码与公司不匹配");
		}
	}

	//答题结束
	if($type == 'stop'){
		$type = $_REQUEST['type'];    //难度类型：1：小咖，2：大咖，3：大师，4：专家
		$kc = $_REQUEST['kc']; 		  //课程
		$question_num=$_REQUEST['ques_num'];
		$score = $_REQUEST['score'];  //分数
		$create_time = date('Y-m-d H-i-s');
		$phone	= $_REQUEST['phone'];   //手机号码
		$rank 	= $Db->getOne("select * from quanrun_info where phone='$phone'");
		$openid = $rank['openid'];
		$res  	= $Db->getOne("select * from quanrun_fs where openid='$openid' and type='$type' and kc='$kc'");
		if(!$res){
			$Db->add("quanrun_fs",array('openid'=>$openid,'type'=>$type,'kc'=>$kc,'question_num'=>$question_num,'score'=>$score,'create_time'=>$create_time));
		}else{
			$score=$res['score']+$score;
			$Db->update("quanrun_fs",array('score'=>$score,'question_num'=>$question_num,'create_time'=>$create_time),
					"openid='$openid' and type='$type' and kc='$kc'");
		}
		showsuc("保存成功");
	}
	//重新答题
	if($type == 'new'){
		$type 	= $_REQUEST['type'];      //难度类型：1：小咖，2：大咖，3：大师，4：专家
		$kc   	= $_REQUEST['kc']; 		  //课程
		$phone	= $_REQUEST['phone'];     //手机号码
		$rank 	= $Db->getOne("select * from quanrun_info where phone='$phone'");
		$openid = $rank['openid'];
		$Db->delete("quanrun_fs","openid='$openid' and type='$type' and kc='$kc'");
		showsuc("操作成功");
	}
	//关注数
	if($type == 'num'){
		$type = $_REQUEST['type'];    	  //难度类型：1：小咖，2：大咖，3：大师，4：专家
		$kc   = $_REQUEST['kc']; 		  //课程
		$info = $Db->getOne("SELECT * FROM quanrun_course WHERE type='$type' and kc='$kc'");
		$num  = $info['num']+1;
		$Db->update("quanrun_course",array('num'=>$num),"type='$type' and kc='$kc'");
		showsuc("关注数", array('num' =>$num));
	}
	//点赞数
	if($type == 'help'){
		$type = $_REQUEST['type'];    	  //难度类型：1：小咖，2：大咖，3：大师，4：专家
		$kc   = $_REQUEST['kc']; 		  //课程
		$info = $Db->getOne("SELECT * FROM quanrun_course WHERE type='$type' and kc='$kc'");
		$help = $info['help']+1;
		$Db->update("quanrun_course",array('help'=>$help),"type='$type' and kc='$kc'");
		showsuc("点赞数", array('help' =>$help));
	}

}catch (Exception $e){
	showerr($e->getMessage());
}
?>