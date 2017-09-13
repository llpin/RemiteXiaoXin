$(function(){

	function getCookie(objName){
		var arrStr = document.cookie.split("; "); 
		for(var i = 0;i < arrStr.length;i ++){ 
		var temp = arrStr[i].split("="); 
		if(temp[0] == objName) return unescape(temp[1]); 
		} 
	} 

	function isWeixin() {
	    var a = navigator.userAgent.toLowerCase();
	    return "micromessenger" == a.match(/MicroMessenger/i) ? !0 : !1
	}

	if(isWeixin()){
		var CookieOpenId = getCookie("openid");
		if(!CookieOpenId){
	   	  alert("登陆信息失效，请重新登陆");
	   	  // window.location.href="weixin_prev.php";
	   	  window.location.href="weixin.php";
	   }
	}else{
		var cookiePhone = getCookie("cookiePhone");
	   if(!cookiePhone){
	   	  alert("登陆信息失效，请重新登陆");
	   	  window.location.href="login.html";
	   }
	}

});