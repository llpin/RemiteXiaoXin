<?php
class WeixinAction{
	
	private $appid;
	private $secret;
	
	
	public function __construct($config,$db){
		$this->appid = $config['appid'];
		$this->secret = $config['secret'];
		$this->isonlyopenid=$config['isonlyopenid'];
		$this->db=$db;
	}
	
	public function _getAccessToken(){
		//判断session中是否存在
		if($_SESSION['WX_ACCESS_TOKEN']&&$_SESSION['WX_JSAPI_TICKET']&&($_SESSION['WX_CREATE_TIME']+$_SESSION['WX_EXPIRES_IN']>time())){
			//存在值，直接返回
	
		}else{
			//session中没有值，读取数据库
			//判断access_token是否失效
			//$arr=M("access")->find();
			$sql = "select * from access where appid='{$this->appid}' limit 1";
			$arr1 = $this->db->getAll($sql);
			if($arr1[0]['create_time']+$arr1[0]['expires_in']>time()){
				$arr=$arr1[0];
			}else{
				$rs1=file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->secret);
				$arr=json_decode($rs1,true);
				if($arr['access_token']){
					$rs2=file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$arr['access_token'].'&type=jsapi');
					$arr2=json_decode($rs2,true);
					if($arr2['errcode']==0){
						$create_time=time();
						$ticket=$arr2['ticket'];
						$access_token = $arr['access_token'];
						$expires_in = $arr['expires_in'];
						if($arr1[0]['appid']){
							$sql = "update access set access_token='$access_token',ticket='$ticket',create_time='$create_time',expires_in='$expires_in' where appid='{$this->appid}'";
						}else{
							$sql = "insert into  access (access_token,ticket,create_time,expires_in,appid) values('$access_token','$ticket','$create_time','$expires_in','{$this->appid}')";													
						}
						//echo $sql;
						$d = $this->db->execute($sql);
						if($d){
	
						}else{
							exit("ERROR0:很抱歉，页面已失效！");
						}
						
					}else{
						exit("ERROR1:很抱歉，页面已失效！");
					}
				}else{
					exit("ERROR2:很抱歉，页面已失效！");
				}
			}
			$_SESSION['WX_ACCESS_TOKEN'] = $arr['access_token'];
			$_SESSION['WX_CREATE_TIME'] = $arr['create_time'];
			$_SESSION['WX_EXPIRES_IN'] = $arr['expires_in'];
			$_SESSION['WX_JSAPI_TICKET'] = $arr['ticket'];
		}
	}
	
	//重定向获取微信用户code
	public function _getWeixinCode(){
		$url='https://open.weixin.qq.com/connect/oauth2/authorize?';
		$url.='appid='.$this->appid;
		$url.='&redirect_uri='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$url.='&response_type=code';
		if($this->isonlyopenid){
			$url.='&scope=snsapi_base';
		}else{
			$url.='&scope=snsapi_userinfo';
		}
		$url.='&state=STATE#wechat_redirect';
		header('location:'.$url);
		exit();
	}
	
	//根据用户code获取用户信息
	public function _getWeixinUserInfo($code){
		$rs=file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->secret.'&code='.$code.'&grant_type=authorization_code');
		$arr=json_decode($rs,true);
		if($arr['openid']){
			$_SESSION['openid']=$arr['openid'];
		}
		$rs1=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$arr['access_token'].'&openid='.$arr['openid'].'&lang=zh_CN');
		$userinfo = json_decode($rs1,true);
		return $userinfo;
	}

}


















?>