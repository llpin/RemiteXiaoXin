window.onload = function() { 	
	// $("#p1Button").find("li").show().addClass('animated bounceIn');
  $("#loading").fadeOut(500,function(){
		$("#p1Button").find("li").show().addClass('animated bounceIn');
	});
}; 


$(function(){


var $p1 = $(".page1"),
	$p2 = $(".page2"),
	$p3 = $(".page3"),
	$p4 = $(".page4"),
	$p5 = $(".page5"),
	$p7 = $(".page7"),
	$p8 = $(".page8"),
	$p9 = $(".page9"),
	regPhone = /^1[34578]\d{9}$/,
	regMail = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/,
	regPassword = /^[0-9a-zA-Z!@#$^]{6,18}$/,
	judge = 0,
	loginInfo = 0,
	fourth = 0,		
	gradeName = window.location.pathname,
	$progress_tips = $(".progress_tips"),
	$likeNum = $("#likeNum"),
	$shareLike = $("#shareLike"),
	$likeRightTips = $("#likeRightTips"),
	$courseBox = $(".course_box"),
	$page3cut = $("#page3cut"),
	$msg = $("#msg"),
	$answerUl = $(".answer_ul"),
	$TiSwiperBox = $("#TiSwiperBox"),
	$answerSubmit = $("#answerSubmit"),
	$login_button = $(".login_button"),
	$loginTips =$(".popup_login_details"); 

function getQueryString(key){
        var reg = new RegExp("(^|&)"+key+"=([^&]*)(&|$)");
        var result = window.location.search.substr(1).match(reg);
        return result?decodeURIComponent(result[2]):null;
      }
var inNum = getQueryString("in"),
	tInNum = getQueryString("tin"),
	aInNum = getQueryString("ain"),
	courseNum = getQueryString("course"),
	getKC = getQueryString("kc");


function isWeixin() {
    var a = navigator.userAgent.toLowerCase();
    return "micromessenger" == a.match(/MicroMessenger/i) ? !0 : !1
}
function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Mobi/i.test(navigator.userAgent) ||
                    window.innerWidth < 500;
 }

function Percentage(number1, number2) { 
    return (Math.round(number1 / number2 * 10000) / 100 + "%");// 小数点后两位百分比   
}


function setCookie(cname, cvalue, exdays) {
 var d = new Date();
 d.setTime(d.getTime() + 30*60*1000);
 // d.setTime(d.getTime() + (exdays*24*60*60*1000));
 var expires = "expires="+d.toUTCString();
 document.cookie = cname + "=" + cvalue + "; " + expires;
}

 function getCookie(objName){
	var arrStr = document.cookie.split("; "); 
	for(var i = 0;i < arrStr.length;i ++){ 
	var temp = arrStr[i].split("="); 
	if(temp[0] == objName) return unescape(temp[1]); 
	} 
} 

function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

// delCookie("openid");
// delCookie("headimgurl");

var CookieOpenId = getCookie("openid"),
	headImgUrl =  getCookie("headimgurl"),
	cookiePhone = getCookie("cookiePhone");
// //console.log("是不是微信："+isWeixin());
// //console.log("是不是手机："+isMobile());
// //console.log("COOKIE里的openid："+CookieOpenId);
// //console.log("电脑端有手机号码："+cookiePhone);

// //console.log("头像是："+headImgUrl);






if(isWeixin()){

	// 点击4个按钮
	$("#p1Button").on("click","li",function(){
		var buttonIn = $(this).data("in");

		if(!CookieOpenId){//如果没填资料
			
			pageIn($loginTips);		
			$loginTips.on("click",function(){
				window.location.href="weixin.php";
			});						

		}else{	//如果填过资料了

			// //console.log("有资料了");

			//4个按钮
		$.ajax({
			url:"api.php?a=start",
			type:"post",
			dataType:"json",
			data:{type:buttonIn},
			success:function(data){
				// //console.log(data);
				if(buttonIn == 4 && data.error == 1){					
					tips("验证失败！<br>请核对邀请码与公司名称",5000);
					//邀请码错误
					pageIn($p7);
					$(".oneSubmit").on("click",function(){
						var oneCode = $("#oneCode").val();
						if(oneCode){
							$.ajax({
								url:"api.php?a=code",
								type:"post",
								dataType:"json",
								data:{code:oneCode},
								success:function(data){
									// //console.log(data);
									if(data.error == 0){
										tips("邀请码错误或不匹配，<br>请完善个人信息",3000);
										pageOut($p7);
									}else{
										tips(data.info,3000);
										// pageOut($p7);
									}
									
								}
							});
							
						}else{
							tips("请填写邀请码",3000);
						}
						
					});
					return false;
				}else{
					window.location.href="catalog.html?in="+buttonIn;
				}


			}
		});
		//4个按钮结束



			

		}		
		
	});
	// 点击4个按钮结束


// 微信题目目录
if(inNum){
	$.ajax({
		url:"api.php?a=start",
		type:"post",
		dataType:"json",
		data:{type:inNum},
		success:function(data){
			// //console.log(data);
			var Data = data.data.profile,
				inHtml = "";
			$.each(Data,function(k,v){
				inHtml +=' <div class="catalog_li">';
				inHtml +=' 	<a href="task.html?tin='+inNum+'&course='+k+'">';
				inHtml +=' 	<h1>'+v.kc+'</h1>';
				inHtml +=' 	<div class="page_view">';
				inHtml +=' 	关注：'+v.num+'  &nbsp;&nbsp; | &nbsp;&nbsp;  学习：'+v.number+'';
				inHtml +=' 	</div>';
				inHtml +=' 	<div class="catalog_li_content">';
				inHtml +=' 	<img src="'+v.image+'" alt="">';
				inHtml +=' 	<div class="catalog_li_description">';
				inHtml +=' 	'+v.content+'';
				inHtml +=' 	</div>';
				inHtml +=' 	</div>';
				inHtml +=' 	</a>';
				inHtml +=' 	</div>';
			});
			$(".catalog_box").append(inHtml);

			


		}
	});
}
// 微信题目目录结束

// 微信课题介绍
if(tInNum){

	$.ajax({
			url:"api.php?a=start",
			type:"post",
			dataType:"json",
			data:{type:tInNum},
			success:function(data){
				// //console.log(data);
				//console.log("课题介绍的");
				var tData = data.data.profile[courseNum];
				$("#taskBanner").prop("src",tData.image);
				$("#taskH1").text(tData.kc);
				$(".task_introduce").html("介绍："+tData.content);
				// $("#taskSubmitUrl").prop("href","answer.html?ain="+tInNum+"&course="+courseNum);
				var GoToCourseNum = parseInt(courseNum)+1;
				$("#taskSubmitUrl").on("click",function(){
					window.location.href="answer.html?ain="+tInNum+"&course="+ GoToCourseNum+"&kc="+tData.kc;
				});

				$likeNum.text(tData.help);
				$shareLike.on("click",function(){					
					$(this).off();
					$.ajax({
						url:"api.php?a=help",
						type:"post",
						dataType:"json",
						data:{type:tInNum,kc:data.data.profile[courseNum].kc},
						success:function(data){
							//console.log(data);
							if(data.error == 0){
								$likeNum.text( parseInt(tData.help)+1 );
								$likeRightTips.show().addClass("animated fadeOutUp");
							}
						}
					});
				});



				var thisUrlCode = encodeURIComponent(window.location.href);
				//微博分享
				$("#shareWeibo").on("click",function(){
					window.location.href="http://service.weibo.com/share/share.php?url="+thisUrlCode+"&title="+tData.kc+"："+tData.content+"&pic="+tData.image;
				});


				$.ajax({
					url:"api.php?a=num",
					type:"post",
					dataType:"json",
					data:{type:tInNum,kc:data.data.profile[courseNum].kc},
					success:function(data){
						//console.log(data);
					}
				});



			}
	});


}

//微信答题
if(aInNum){

// 分数
function allFenShu(){
    $.ajax({
		url:"api.php?a=content",
		type:"post",
		dataType:"json",
		data:{type:aInNum,kc:getKC},
		success:function(data){
			var progressScore = data.data.score;
			if(data.data.score == null){
				progressScore = 0;
			}
			$progress_tips.find("u").text("-总分："+progressScore);
		}
	});
  
}


	$.ajax({
		url:"api.php?a=content",
		type:"post",
		dataType:"json",
		data:{type:aInNum,kc:getKC},
		success:function(data){
			//console.log(data);
			//console.log("题目的");
			var likeNumber = data.data.help;

			$likeNum.text(likeNumber);
			$shareLike.on("click",function(){					
				$(this).off();
				$.ajax({
					url:"api.php?a=help",
					type:"post",
					dataType:"json",
					data:{type:aInNum,kc:getKC},
					success:function(data){
						//console.log(data);
						if(data.error == 0){
							$likeNum.text( parseInt(likeNumber)+1 );
							$likeRightTips.show().addClass("animated fadeOutUp");
						}
					}
				});
			});


			var progressAllNum = data.data.number,
				progressQNum = parseInt(data.data.question_num)+1;
				
			if(data.data.question_num == null){
				progressQNum = 1;
			}
			if(data.data.number == data.data.question_num){
				progressQNum = data.data.number;
			}
			
			allFenShu();

			var progressPercentage = Percentage(progressQNum,progressAllNum );
			
			$progress_tips.find("i").text("P"+progressQNum+"/"+progressAllNum+"-"+progressPercentage);
			// $progress_tips.find("u").text("-总分："+progressScore);
			$(".progress-bar").css("width",progressPercentage);

				var aInData = data.data.content,
					// aInDataInfo = data.data.info[courseNum],
					startRightA = [],
					startFen = [],
					aInHtml = "";
			if(aInData.length == 0 && data.data.question_num >0){

				$("#answerSwiper").html('<div class="answer_li answer_num answer_null">'+
					'<div class="answer_box">'+
					'<div class="answer_ul"><h3>恭喜你！当前课程已完成</h3>'+
					'<img src="images/chongzuo.png" class="reform">'+
					'</div>'+
					'</div>'+
					'</div>'
					);

				
			    $(".reform").on("click",function(){
			    	if(window.confirm('确定重学一遍么？之前的学习记录将不被保存！')){
			    		$.ajax({
							url:"api.php?a=new",
							type:"post",
							dataType:"json",
							data:{type:aInNum,kc:getKC},
							success:function(data){
								//console.log(data);
								if(data.error == 0){
									window.location.reload();
								}
								
							}
						});
					    return true;
					 }else{
					    return false;
					 }
					
				});				    
				    
				
			}else if(aInData.length == 0 && data.data.question_num == null){
				$(".answer_progress_bar").remove();
				$("#answerSwiper").html('<div class="answer_li answer_num answer_null">'+
					'<div class="answer_box">'+
					'<div class="answer_ul"><h3>本课程完善中....</h3>'+

					'</div>'+
					'</div>'+
					'</div>'
					);

			}else{

				$.each(aInData,function(kk,vv){

					startRightA.push(vv.Answer);
					startFen.push(vv.fs);

					aInHtml +='<div class="swiper-slide">';
					aInHtml +='<div class="answer_li answer_num swiper_slide'+kk+'">';
					aInHtml +='<div class="answer_box">';
					aInHtml +='<div class="answer_ul">';
					aInHtml +='<img src="'+vv.image+'" alt="">';
					aInHtml +='<h1>'+vv.no+'、'+vv.Question+'</h1>';
					aInHtml +='<div class="subject" data-qa="A" data-on="0">';
					aInHtml +=' A：'+vv.A+' ';
					aInHtml +='<div class="choose"></div>';
					aInHtml +='</div>';

					aInHtml +='<div class="subject" data-qa="B" data-on="0">';
					aInHtml +='B：'+vv.B+' ';
					aInHtml +='<div class="choose"></div>';
					aInHtml +='</div>';

					aInHtml +='<div class="subject" data-qa="C" data-on="0">';
					aInHtml +='C：'+vv.C+' ';
					aInHtml +='<div class="choose"></div>';
					aInHtml +='</div>';

					aInHtml +='<div class="subject" data-qa="D" data-on="0">';
					aInHtml +='D：'+vv.D+' ';
					aInHtml +='<div class="choose"></div>';
					aInHtml +='</div>';

					aInHtml += '<img src="images/confirm_button.png" alt="" class="answer_confirm_button answer_button_submit" data-key="'+kk+'" data-no="'+vv.no+'" data-fenshu="'+vv.fs+'">';
					aInHtml += '<img src="images/next_ti.png" alt="" class="answer_confirm_button answer_button_next"  data-no="'+vv.no+'" >';

					aInHtml +='<div class="answer_tips"></div>';	


					aInHtml +='</div>';

					aInHtml +='</div>';
					aInHtml +='</div>';

					aInHtml +='</div>';


				});
				// $(".catalog_box").prepend(aInHtml);
				$("#answerSwiper").prepend(aInHtml);

				var $answer_button_next = $(".answer_button_next"),
				$answer_button_submit = $(".answer_button_submit");
				var swiperTi = new Swiper('.swiper-container', {
		        pagination: '.swiper-pagination',
		        paginationClickable: true,
		        autoHeight: true,
		        spaceBetween: 30,
		        effect : 'flip',
		        onlyExternal : true,		        

				  onSlideChangeEnd:function(swiperTi){
				  	swiperTi.update();
				  		document.getElementsByTagName('body')[0].scrollTop = 0;
					   	 //切换完成,如果是最后一页
					   	 if(swiperTi.isEnd){
					   	 	$answer_button_next.remove();
					   	 	
	                      }
					   },

		        // direction: 'vertical'
		    	});

				

					//分享
				var thisUrlCode = encodeURIComponent(window.location.href);
				//微博分享
				$("#shareWeibo").on("click",function(){
					window.location.href="http://service.weibo.com/share/share.php?url="+thisUrlCode+"&title="+data.data.info[courseNum].kc+"："+data.data.info[courseNum].content+"&pic="+data.data.info[courseNum].image;
				});



				//点击答案
				$(".answer_ul").on("click",".subject",function(){
					var	$this = $(this);
					$this.data("on","1").addClass("Checked").siblings().removeClass("Checked").data("on","0");		
				});

				var progressScoreNext = 0;

				//提交答案
			$answer_button_submit.on("click",function(){
				var numN = "",
					_this = $(this),
					tiKey = _this.data("key"),
					quesNum = _this.data("no"),
					quesFenShu = _this.data("fenshu");
             	//console.log(swiperTi.activeIndex);
             	//console.log("这是第"+quesNum+"题");

				_this.parents(".answer_ul").find(".subject").each(function(){
					if($(this).data("on") == 1){
						numN = $(this).data("qa");			
					}
				});

				if(numN){
					//console.log("选中了："+numN);
					var on = startRightA[tiKey],//正确答案
						deFen = 0;

					if(numN == startRightA[tiKey]){
						deFen = quesFenShu;
					}

					if( swiperTi.slides.length-1 == swiperTi.activeIndex ){
						_this.siblings(".answer_tips").html("您的回答："+numN+"，参考答案："+startRightA[tiKey]+"<br>~本次课程到此结束~").addClass("answer_tips_bg answer_tips_over").fadeIn();


					}else{
						_this.siblings(".answer_tips").html("您的回答："+numN+"，参考答案："+startRightA[tiKey]).addClass("answer_tips_bg").fadeIn();
					}					

					$answer_button_next.show();
					_this.hide();

					
					

					//保存答题					
					$.ajax({
						url:"api.php?a=stop",
						type:"post",
						dataType:"json",
						data:{type:aInNum,
							kc:getKC,
							ques_num:quesNum,
							score:deFen
						},
						success:function(data){
							//console.log("保存答题");
							//console.log(data);
							allFenShu();
						}
					});
					//保存答题结束




					return false;
				}else{						
					tips("请勾选您的答案",1000);
				}
			});

			//点击下一页翻页
		     $answer_button_next.click(function(){
		     	//console.log("123");
				swiperTi.slideNext();
				$answer_button_next.hide();
				// _this.siblings(".answer_tips");
				var thisQuesNum = $(this).data("no"),
					progressQNumNext = parseInt(thisQuesNum)+1,
					progressPercentageNext = Percentage(progressQNumNext,progressAllNum );
					//console.log("P"+progressQNumNext);
				// $(".progress_tips").text("P"+progressQNumNext+"/"+progressAllNum+"-"+progressPercentageNext);
				$progress_tips.find("i").text("P"+progressQNumNext+"/"+progressAllNum+"-"+progressPercentageNext);
				allFenShu();
				$(".progress-bar").css("width",progressPercentageNext);
			 });
			        

			// }
			
		
			 
			}
			//如果有数据结束

		}
		//success结束
	});
}
 

//微信我的成绩
if(gradeName.indexOf("/my_grade.html") >= 0 ){
	$.ajax({
		url:"api.php?a=score",
		type:"post",
		dataType:"json",
		success:function(data){
			//console.log(data);
			var scoreData = data.data.info,
				scoreHtml = "";
			$.each(scoreData,function(kkk,vvv){
				scoreHtml+='<tr>';
	             scoreHtml+='<td>'+vvv.type+'-'+vvv.kc+'</td>';
	             scoreHtml+='<td class="box_table_score">'+vvv.score+'</td>';
               scoreHtml+='</tr>';               
			});
			$("#myGradeBox").append(scoreHtml);
		}
	});
}
//微信我的成绩结束

	// if(CookieOpenId && headImgUrl){
	if(CookieOpenId){
		//如果有openid就进入个人信息
		$login_button.prop("src","images/user_info.jpg").on("click",function(){
			window.location.href="user_info.html";		    
		});
		//console.log("有openId是："+CookieOpenId);

		//登陆
		$.ajax({
			url:"api.php?a=login",
			type:"post",
			dataType:"json",
			success:function(data){
				//console.log(data);
			}
		});

		//个人中心
		$.ajax({
			url:"api.php?a=data",
			type:"post",
			dataType:"json",
			success:function(data){
				//console.log(data);
				var Data = data.data.info;
				if(Data.headimgurl){
					$(".avatar_pic").prop("src",Data.headimgurl);
				}else{
					$(".avatar_pic").remove();
				}	
				if(Data.name){
					$("#infoName").text(Data.name);	
					$("#changeInfoNmae").val(Data.name)	;			
				}	
				if(Data.nickname)	{
					$("#infoNickName").text(Data.nickname);					
				}	
				if(Data.phone)	{
					$("#infoPhone").text(Data.phone);
					$("#changePWDphone").val(Data.phone);	
					$("#changeInfoPhone").val(Data.phone).attr("readonly","readonly");	
				}
				if(Data.firm)	{
					$("#infoLtd").text(Data.firm);	
					$("#changeInfoLTD").val(Data.firm);	

				}	
				if(Data.post)	{
					$("#infoPost").text(Data.post);					
					$("#changeInfoPost").val(Data.post);					
				}
				if(Data.email){				
					$("#changeInfoMall").val(Data.email);					
				}
				// if(Data.sex){				
				// 	$("#changeInfoSex").val(Data.sex);					
				// }
				if(Data.code){				
					$("#changeInfoCode").val(Data.code);					
				}
				var passwordMobileNum = data.data.password;
				//console.log("里面的是0还是1："+passwordMobileNum);
				if(passwordMobileNum == 0){
					$("#changeInfoPwdBox").remove();
					$("#changeInfoPwdTooBox").remove();
				}
				//完善资料
				$("#changeInfoSubmit").on("click",function(){
					var changeInfoNmae = $("#changeInfoNmae").val(),
						changeInfoLTD = $("#changeInfoLTD").val(),
						changeInfoPost = $("#changeInfoPost").val(),
						changeInfoPhone = $("#changeInfoPhone").val(),
						changeInfoCode = $("#changeInfoCode").val(),
						// changeInfoSex = $("#changeInfoSex").val(),
						changeInfoMall = $("#changeInfoMall").val(),
						changeInfoPwd = $("#changeInfoPwd").val(),
						changeInfoPwdToo = $("#changeInfoPwdToo").val();

					if(passwordMobileNum == 1){
						// 如果没写过密码就提交密码
						if(!changeInfoNmae){
							tips("请输入姓名",3000);
							return false;
						}else if(!changeInfoLTD){			
							tips("请输入公司名",3000);
							return false;
						}else if(!changeInfoPost){
							tips("请输入岗位",3000);
							return false;
						}else if(!( regPhone.test(changeInfoPhone) ) ){
							tips("请输入正确的手机号码",3000);
							return false;
						}else if( !(regMail.test(changeInfoMall) ) ){
							tips("请输入正确的邮箱",3000);
							return false;				
						}else if( !(regPassword.test(changeInfoPwd)) ){
							tips("请输入6-18位<br>（数字或字母组成）的新密码",5000);
							return false;
						}else if(changeInfoPwd !== changeInfoPwdToo){
							tips("两次密码输入不匹配",5000);
							return false;
						}else{
							//console.log("可以提交");				
							$.ajax({
								url:"api.php?a=perfect",
								type:"post",
								dataType:"json",
								data:{
									name:changeInfoNmae,
									firm:changeInfoLTD,
									post:changeInfoPost,
									phone:changeInfoPhone,
									code:changeInfoCode,
									// sex:changeInfoSex,
									email:changeInfoMall,
									password:changeInfoPwd
								},
								success:function(data){
									//console.log(data);
									if(data.error == 1){
										tips("提交失败，"+data.info,3000);
									}else{
										tips("提交成功",3000);
										location.replace(location.href);
									}
								}
							});

							
						}


					}else{
						//如果填写过密码
						if(!changeInfoNmae){
							tips("请输入姓名",3000);
							return false;
						}else if(!changeInfoLTD){			
							tips("请输入公司名",3000);
							return false;
						}else if(!changeInfoPost){
							tips("请输入岗位",3000);
							return false;
						}else if(!( regPhone.test(changeInfoPhone) ) ){
							tips("请输入正确的手机号码",3000);
							return false;
						}else if( !(regMail.test(changeInfoMall) ) ){
							tips("请输入正确的邮箱",3000);
							return false;				
						}else{
							//console.log("可以提交");				
							$.ajax({
								url:"api.php?a=perfect",
								type:"post",
								dataType:"json",
								data:{
									name:changeInfoNmae,
									firm:changeInfoLTD,
									post:changeInfoPost,
									phone:changeInfoPhone,
									code:changeInfoCode,
									// sex:changeInfoSex,
									email:changeInfoMall
								},
								success:function(data){
									//console.log(data);
									if(data.error == 1){
										tips("提交失败，请核对邀请码",3000);
									}else{
										tips("提交成功",3000);
										
									}
								}
							});

							
						}
						//填过密码的 结束


					}
					


				});
				//完善资料结束
				
			}
		});
		//个人中心结束

		//修改密码
		$("#changePWDsubmit").on("click",function(){
			var changePWDphone = $("#changePWDphone").val();
				changePWDoldPwd = $("#changePWDoldPwd").val(),
				changePWDnewsPwd = $("#changePWDnewsPwd").val(),
				changePWDnewsPwdToo = $("#changePWDnewsPwdToo").val();
			//console.log("为何手机不对："+changePWDphone);
			if(!changePWDoldPwd){
				tips("请输入原密码",5000);
				return false;
			}else if( !(regPassword.test(changePWDnewsPwd)) ){
				tips("请输入6-18位<br>（数字或字母组成）的新密码",5000);
				return false;
			}else if(changePWDnewsPwd !== changePWDnewsPwdToo){
				tips("请重新核对新密码",5000);
				return false;
			}else{
				//console.log("全部输入正确了");
				$.ajax({
					url:"api.php?a=modify",
					type:"post",
					dataType:"json",
					data:{
						phone:changePWDphone,
						password:changePWDoldPwd,
						new_password:changePWDnewsPwd
					},
					success:function(data){
						//console.log(data);
						if(data.error == 1){
							tips(data.info,5000);
							return false;
						}else if(data.error == 0){
							tips(data.info,1000);
							hrefURL("user_info.html",1000);
						}
					}
				});

			}
			
		});
		//修改密码结束



	}else{
		//如果没openId
		$login_button.on("click",function(){
			window.location.href="weixin.php";
		});
		//console.log("没openId是："+CookieOpenId);
	}

	$("#shareWeixin").on("click",function(){
		$(".weixin_tips_box").show(0,function(){
			$(this).on("click",function(){
				$(this).hide();
			});
		});
	});	



	//分享

    //游戏链接地址目录
    var gameUrl = 'http://'+window.location.host+'/xl_game/quanRun/weixin.php';
    //分享到朋友数据
    var sharedata = {
        title: "荃润",
        desc: "杭州荃润信息技术有限公司",
        link: gameUrl,
        imgUrl:"http://"+window.location.host+"/xl_game/quanRun/images/share.jpg"
    };


    //分享到朋友圈数据 默认和分享朋友一样
    var timelinedata = {
        title: sharedata.title,
        link: sharedata.link,
        imgUrl: sharedata.imgUrl
    }


 wx.config({
        debug: false,
        appId: wx_config['appId'],
        timestamp: wx_config['timestamp'],
        nonceStr: wx_config['nonceStr'],
        signature: wx_config['signature'],
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareQZone',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onVoiceRecordEnd',
            'playVoice',
            'onVoicePlayEnd',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard'
        ]
    });

    sharedata.trigger = function (res) {};
    sharedata.cancel = function (res) {};
    sharedata.fail = function (res) {};
    sharedata.success = function (res) {
    };

    timelinedata.trigger = function (res) {};
    timelinedata.cancel = function (res) {};
    timelinedata.fail = function (res) {};
    timelinedata.success = function (res) {
        //分享朋友圈成功

    };

    wx.ready(function () {
        //type: 'link',//分享类型，music、video、link，默认是link
        //dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        wx.onMenuShareAppMessage(sharedata);

        // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
        wx.onMenuShareTimeline(timelinedata);





        //console.log("初始化wx分享成功！");
    });




}else{
	// 不是微信
	// 微信注册

  


$("#loginWeixinReg").on("click",function(){	
	 pageIn($(".popup_qr"));
});

$("#shareWeixin").on("click",function(){	
	 pageIn($(".popup_qr"));
});




// 点击4个按钮
$("#p1Button").on("click","li",function(){
	var buttonIn = $(this).data("in");

	if(!cookiePhone){//如果没填资料
		
		pageIn($loginTips);		
		$loginTips.on("click",function(){
			window.location.href="login.html";
		});						

	}else{	//如果填过资料了

		//console.log("有资料了");

		//4个按钮
		$.ajax({
			url:"api2.php?a=start",
			type:"post",
			dataType:"json",
			data:{type:buttonIn,phone:cookiePhone},
			success:function(data){
				//console.log(data);
				if(buttonIn == 4 && data.error == 1){					
					tips("验证失败！<br>请核对邀请码与公司名称",5000);
					//邀请码错误
					pageIn($p7);
					$(".oneSubmit").on("click",function(){
						var oneCode = $("#oneCode").val();
						if(oneCode){
							$.ajax({
								url:"api2.php?a=code",
								type:"post",
								dataType:"json",
								data:{code:oneCode,phone:cookiePhone},
								success:function(data){
									//console.log(data);
									if(data.error == 0){
										tips("邀请码错误或不匹配，<br>请完善个人信息",3000);
										pageOut($p7);
									}else{
										tips(data.info,3000);
										// pageOut($p7);
									}
									
								}
							});
							
						}else{
							tips("请填写邀请码",3000);
						}
						
					});
					return false;
				}else{
					window.location.href="catalog.html?in="+buttonIn;
				}


			}
		});
		//4个按钮结束



		

	}		
	
});
// 点击4个按钮结束


// 电脑题目目录
if(inNum){
	$.ajax({
		url:"api2.php?a=start",
		type:"post",
		dataType:"json",
		data:{type:inNum,phone:cookiePhone},
		success:function(data){
			//console.log(data);
			var Data = data.data.profile,
				inHtml = "";
			$.each(Data,function(k,v){
				inHtml +=' <div class="catalog_li">';
				inHtml +=' 	<a href="task.html?tin='+inNum+'&course='+k+'">';
				inHtml +=' 	<h1>'+v.kc+'</h1>';
				inHtml +=' 	<div class="page_view">';
				inHtml +=' 	关注：'+v.num+'  &nbsp;&nbsp; | &nbsp;&nbsp;  学习：'+v.number+'';
				inHtml +=' 	</div>';
				inHtml +=' 	<div class="catalog_li_content">';
				inHtml +=' 	<img src="'+v.image+'" alt="">';
				inHtml +=' 	<div class="catalog_li_description">';
				inHtml +=' 	'+v.content+'';
				inHtml +=' 	</div>';
				inHtml +=' 	</div>';
				inHtml +=' 	</a>';
				inHtml +=' 	</div>';
			});
			$(".catalog_box").append(inHtml);



		}
	});
}
// 电脑题目目录结束

// 电脑课题介绍
if(tInNum){

	$.ajax({
			url:"api2.php?a=start",
			type:"post",
			dataType:"json",
			data:{type:tInNum,phone:cookiePhone},
			success:function(data){
				//console.log(data);
				//console.log("课题介绍的");
				var tData = data.data.profile[courseNum];
				$("#taskBanner").prop("src",tData.image);
				$("#taskH1").text(tData.kc);
				$(".task_introduce").html("介绍："+tData.content);
				// $("#taskSubmitUrl").prop("href","answer.html?ain="+tInNum+"&course="+courseNum);
				var GoToCourseNum = parseInt(courseNum)+1;
				$("#taskSubmitUrl").on("click",function(){
					window.location.href="answer.html?ain="+tInNum+"&course="+GoToCourseNum+"&kc="+tData.kc;
				});
				$likeNum.text(tData.help);
				$shareLike.on("click",function(){					
					$(this).off();
					$.ajax({
						url:"api2.php?a=help",
						type:"post",
						dataType:"json",
						data:{type:tInNum,kc:data.data.profile[courseNum].kc,phone:cookiePhone},
						success:function(data){
							//console.log(data);
							if(data.error == 0){
								$likeNum.text( parseInt(tData.help)+1 );
								$likeRightTips.show().addClass("animated fadeOutUp");
							}
						}
					});
				});

				var thisUrlCode = encodeURIComponent(window.location.href);
				//微博分享
				$("#shareWeibo").on("click",function(){
					window.location.href="http://service.weibo.com/share/share.php?url="+thisUrlCode+"&title="+tData.kc+"："+tData.content+"&pic="+tData.image;
				});


				$.ajax({
					url:"api2.php?a=num",
					type:"post",
					dataType:"json",
					data:{type:tInNum,kc:data.data.profile[courseNum].kc,phone:cookiePhone},
					success:function(data){
						//console.log(data);
					}
				});



			}
	});


}

//电脑答题
if(aInNum){

// 电脑分数
function allFenShu(){
    $.ajax({
		url:"api2.php?a=content",
		type:"post",
		dataType:"json",
		data:{type:aInNum,kc:getKC,phone:cookiePhone},
		success:function(data){
			//console.log(data);
			var progressScore = data.data.score;
			if(data.data.score == null){
				progressScore = 0;
			}
			$progress_tips.find("u").text("-总分："+progressScore);
		}
	});
  
}


	$.ajax({
		url:"api2.php?a=content",
		type:"post",
		dataType:"json",
		data:{type:aInNum,kc:getKC,phone:cookiePhone},
		success:function(data){
			//console.log(data);
			//console.log("题目的");
			var likeNumber = data.data.help;

			$likeNum.text(likeNumber);
			$shareLike.on("click",function(){					
				$(this).off();
				$.ajax({
					url:"api2.php?a=help",
					type:"post",
					dataType:"json",
					data:{type:aInNum,kc:getKC,phone:cookiePhone},
					success:function(data){
						//console.log(data);
						if(data.error == 0){
							$likeNum.text( parseInt(likeNumber)+1 );
							$likeRightTips.show().addClass("animated fadeOutUp");
						}
					}
				});
			});


			var progressAllNum = data.data.number,
				progressQNum = parseInt(data.data.question_num)+1;
				
			if(data.data.question_num == null){
				progressQNum = 1;
			}
			if(data.data.number == data.data.question_num){
				progressQNum = data.data.number;
			}
			
			allFenShu();

			var progressPercentage = Percentage(progressQNum,progressAllNum );
			
			$progress_tips.find("i").text("P"+progressQNum+"/"+progressAllNum+"-"+progressPercentage);
			// $progress_tips.find("u").text("-总分："+progressScore);
			$(".progress-bar").css("width",progressPercentage);

				var aInData = data.data.content,
					// aInDataInfo = data.data.info[courseNum],
					startRightA = [],
					startFen = [],
					aInHtml = "";
			if(aInData.length == 0 && data.data.question_num >0){

				$("#answerSwiper").html('<div class="answer_li answer_num answer_null">'+
					'<div class="answer_box">'+
					'<div class="answer_ul"><h3>恭喜你！当前课程已完成</h3>'+
					'<img src="images/chongzuo.png" class="reform">'+
					'</div>'+
					'</div>'+
					'</div>'
					);

				
			    $(".reform").on("click",function(){
			    	if(window.confirm('确定重学一遍么？之前的学习记录将不被保存！')){
			    		$.ajax({
							url:"api2.php?a=new",
							type:"post",
							dataType:"json",
							data:{type:aInNum,kc:getKC,phone:cookiePhone},
							success:function(data){
								//console.log(data);
								if(data.error == 0){
									window.location.reload();
								}
								
							}
						});
					    return true;
					 }else{
					    return false;
					 }
					
				});				    
				    
				
			}else if(aInData.length == 0 && data.data.question_num == null){
				$(".answer_progress_bar").remove();
				$("#answerSwiper").html('<div class="answer_li answer_num answer_null">'+
					'<div class="answer_box">'+
					'<div class="answer_ul"><h3>本课程完善中....</h3>'+

					'</div>'+
					'</div>'+
					'</div>'
					);

			}else{

				$.each(aInData,function(kk,vv){

					startRightA.push(vv.Answer);
					startFen.push(vv.fs);

					aInHtml +='<div class="swiper-slide">';
					aInHtml +='<div class="answer_li answer_num swiper_slide'+kk+'">';
					aInHtml +='<div class="answer_box">';
					aInHtml +='<div class="answer_ul">';
					aInHtml +='<img src="'+vv.image+'" alt="">';
					aInHtml +='<h1>'+vv.no+'、'+vv.Question+'</h1>';
					aInHtml +='<div class="subject" data-qa="A" data-on="0">';
					aInHtml +=' A：'+vv.A+' ';
					aInHtml +='<div class="choose"></div>';
					aInHtml +='</div>';

					aInHtml +='<div class="subject" data-qa="B" data-on="0">';
					aInHtml +='B：'+vv.B+' ';
					aInHtml +='<div class="choose"></div>';
					aInHtml +='</div>';

					aInHtml +='<div class="subject" data-qa="C" data-on="0">';
					aInHtml +='C：'+vv.C+' ';
					aInHtml +='<div class="choose"></div>';
					aInHtml +='</div>';

					aInHtml +='<div class="subject" data-qa="D" data-on="0">';
					aInHtml +='D：'+vv.D+' ';
					aInHtml +='<div class="choose"></div>';
					aInHtml +='</div>';

					aInHtml += '<img src="images/confirm_button.png" alt="" class="answer_confirm_button answer_button_submit" data-key="'+kk+'" data-no="'+vv.no+'" data-fenshu="'+vv.fs+'">';
					aInHtml += '<img src="images/next_ti.png" alt="" class="answer_confirm_button answer_button_next"  data-no="'+vv.no+'" >';

					aInHtml +='<div class="answer_tips"></div>';	


					aInHtml +='</div>';

					aInHtml +='</div>';
					aInHtml +='</div>';

					aInHtml +='</div>';


				});
				// $(".catalog_box").prepend(aInHtml);
				$("#answerSwiper").prepend(aInHtml);

				var $answer_button_next = $(".answer_button_next"),
				$answer_button_submit = $(".answer_button_submit");
				var swiperTi = new Swiper('.swiper-container', {
		        pagination: '.swiper-pagination',
		        paginationClickable: true,
		        autoHeight: true,
		        spaceBetween: 30,
		        effect : 'flip',
		        onlyExternal : true,		        

				  onSlideChangeEnd:function(swiperTi){
				  	swiperTi.update();
				  		document.getElementsByTagName('body')[0].scrollTop = 0;
					   	 //切换完成,如果是最后一页
					   	 if(swiperTi.isEnd){
					   	 	$answer_button_next.remove();
					   	 	
	                      }
					   },

		        // direction: 'vertical'
		    	});

				

					//分享
				var thisUrlCode = encodeURIComponent(window.location.href);
				//微博分享
				$("#shareWeibo").on("click",function(){
					window.location.href="http://service.weibo.com/share/share.php?url="+thisUrlCode+"&title="+data.data.info[courseNum].kc+"："+data.data.info[courseNum].content+"&pic="+data.data.info[courseNum].image;
				});



				//点击答案
				$(".answer_ul").on("click",".subject",function(){
					var	$this = $(this);
					$this.data("on","1").addClass("Checked").siblings().removeClass("Checked").data("on","0");		
				});

				var progressScoreNext = 0;

				//提交答案
			$answer_button_submit.on("click",function(){
				var numN = "",
					_this = $(this),
					tiKey = _this.data("key"),
					quesNum = _this.data("no"),
					quesFenShu = _this.data("fenshu");
             	//console.log(swiperTi.activeIndex);
             	//console.log("这是第"+quesNum+"题");

				_this.parents(".answer_ul").find(".subject").each(function(){
					if($(this).data("on") == 1){
						numN = $(this).data("qa");			
					}
				});

				if(numN){
					//console.log("选中了："+numN);
					var on = startRightA[tiKey],//正确答案
						deFen = 0;

					if(numN == startRightA[tiKey]){
						deFen = quesFenShu;
					}

					if( swiperTi.slides.length-1 == swiperTi.activeIndex ){
						_this.siblings(".answer_tips").html("您的回答："+numN+"，参考答案："+startRightA[tiKey]+"<br>~本次课程到此结束~").addClass("answer_tips_bg answer_tips_over").fadeIn();


					}else{
						_this.siblings(".answer_tips").html("您的回答："+numN+"，参考答案："+startRightA[tiKey]).addClass("answer_tips_bg").fadeIn();
					}					

					$answer_button_next.show();
					_this.hide();

					
					

					//保存答题					
					$.ajax({
						url:"api2.php?a=stop",
						type:"post",
						dataType:"json",
						data:{type:aInNum,
							kc:getKC,
							ques_num:quesNum,
							score:deFen,phone:cookiePhone
						},
						success:function(data){
							//console.log("保存答题");
							//console.log(data);
							allFenShu();
						}
					});
					//保存答题结束




					return false;
				}else{						
					tips("请勾选您的答案",1000);
				}
			});

			//点击下一页翻页
		     $answer_button_next.click(function(){
		     	//console.log("123");
				swiperTi.slideNext();
				$answer_button_next.hide();
				// _this.siblings(".answer_tips");
				var thisQuesNum = $(this).data("no")
					progressQNumNext = parseInt(thisQuesNum)+1,
					progressPercentageNext = Percentage(progressQNumNext,progressAllNum );
					//console.log("P"+progressQNumNext);
				// $(".progress_tips").text("P"+progressQNumNext+"/"+progressAllNum+"-"+progressPercentageNext);
				$progress_tips.find("i").text("P"+progressQNumNext+"/"+progressAllNum+"-"+progressPercentageNext);
				allFenShu();
				$(".progress-bar").css("width",progressPercentageNext);
			 });
			        

			// }
			
		
			 
			}
			//如果有数据结束




		}
		//success结束
	});
}

//我的成绩

//console.log(gradeName);
//console.log(gradeName.indexOf("my_grade.html"));
if(gradeName.indexOf("my_grade.html") >= 0 ){
	$.ajax({
		url:"api2.php?a=score",
		type:"post",
		dataType:"json",
		data:{phone:cookiePhone},
		success:function(data){
			//console.log(data);
			var scoreData = data.data.info,
				scoreHtml = "";
			$.each(scoreData,function(kkk,vvv){
				scoreHtml+='<tr>';
	             scoreHtml+='<td>'+vvv.type+'-'+vvv.kc+'</td>';
	             scoreHtml+='<td class="box_table_score">'+vvv.score+'</td>';
               scoreHtml+='</tr>';               
			});
			$("#myGradeBox").append(scoreHtml);
		}
	});
}
//我的成绩结束
$(".poput_bg").on("click",function(){
	pageOut($(".popup_qr"));
});
	
	if(cookiePhone){
		//如果有手机号码
		$login_button.prop("src","images/user_info.jpg").on("click",function(){
			window.location.href="user_info.html";			    
		});

		$("#userInfoTitle").append('<i id="exitLogin">退出登陆</i>');
		$("#exitLogin").on("click",function(){
			delCookie("cookiePhone");
			alert("退出成功!");
			window.location.href="index.html";
		});


		//个人中心
		$.ajax({
			url:"api2.php?a=data",
			type:"post",
			dataType:"json",
			data:{phone:cookiePhone},
			success:function(data){
				//console.log(data);
				var Data = data.data.info;
				if(Data.headimgurl){
					$(".avatar_pic").prop("src",Data.headimgurl);
				}else{
					$(".avatar_pic").remove();
				}	
				if(Data.name){
					$("#infoName").text(Data.name);	
					$("#changeInfoNmae").val(Data.name)	;			
				}	
				if(Data.nickname)	{
					$("#infoNickName").text(Data.nickname);					
				}	
				if(Data.phone)	{
					$("#infoPhone").text(Data.phone);
					$("#changePWDphone").val(Data.phone);	
					$("#changeInfoPhone").val(Data.phone).attr("readonly","readonly");	
				}	
				if(Data.firm)	{
					$("#infoLtd").text(Data.firm);	
					$("#changeInfoLTD").val(Data.firm);	

				}	
				if(Data.post)	{
					$("#infoPost").text(Data.post);					
					$("#changeInfoPost").val(Data.post);					
				}
				if(Data.email){				
					$("#changeInfoMall").val(Data.email);					
				}
				// if(Data.sex){				
				// 	$("#changeInfoSex").val(Data.sex);					
				// }
				if(Data.code){				
					$("#changeInfoCode").val(Data.code);					
				}
				//是否有过密码，0是有
				// if(data.data.password == 0){
				// 	passwordPcNum = 0;
				// }
				var passwordPcNum = data.data.password;
				//console.log("里面的是0还是1："+passwordPcNum);
				if(passwordPcNum == 0){
					$("#changeInfoPwdBox").remove();
					$("#changeInfoPwdTooBox").remove();
				}
				//完善资料
				$("#changeInfoSubmit").on("click",function(){
					var changeInfoNmae = $("#changeInfoNmae").val(),
						changeInfoLTD = $("#changeInfoLTD").val(),
						changeInfoPost = $("#changeInfoPost").val(),
						changeInfoPhone = $("#changeInfoPhone").val(),
						changeInfoCode = $("#changeInfoCode").val(),
						// changeInfoSex = $("#changeInfoSex").val(),
						changeInfoMall = $("#changeInfoMall").val(),
						changeInfoPwd = $("#changeInfoPwd").val(),
						changeInfoPwdToo = $("#changeInfoPwdToo").val();

					if(passwordPcNum == 1){
						// 如果没写过密码就提交密码
						if(!changeInfoNmae){
							tips("请输入姓名",3000);
							return false;
						}else if(!changeInfoLTD){			
							tips("请输入公司名",3000);
							return false;
						}else if(!changeInfoPost){
							tips("请输入岗位",3000);
							return false;
						}else if(!( regPhone.test(changeInfoPhone) ) ){
							tips("请输入正确的手机号码",3000);
							return false;
						}else if( !(regMail.test(changeInfoMall) ) ){
							tips("请输入正确的邮箱",3000);
							return false;				
						}else if( !(regPassword.test(changeInfoPwd)) ){
							tips("请输入6-18位<br>（数字或字母组成）的新密码",5000);
							return false;
						}else if(changeInfoPwd !== changeInfoPwdToo){
							tips("两次密码输入不匹配",5000);
							return false;
						}else{
							//console.log("可以提交");				
							$.ajax({
								url:"api2.php?a=perfect",
								type:"post",
								dataType:"json",
								data:{
									name:changeInfoNmae,
									firm:changeInfoLTD,
									post:changeInfoPost,
									phone:changeInfoPhone,
									code:changeInfoCode,
									// sex:changeInfoSex,
									email:changeInfoMall,
									password:changeInfoPwd
								},
								success:function(data){
									//console.log(data);
									if(data.error == 1){
										tips("提交失败，请核对邀请码",3000);
									}else{
										tips("提交成功",3000);
										location.replace(location.href);
									}
								}
							});

							
						}


					}else{
						//如果填写过密码
						if(!changeInfoNmae){
							tips("请输入姓名",3000);
							return false;
						}else if(!changeInfoLTD){			
							tips("请输入公司名",3000);
							return false;
						}else if(!changeInfoPost){
							tips("请输入岗位",3000);
							return false;
						}else if(!( regPhone.test(changeInfoPhone) ) ){
							tips("请输入正确的手机号码",3000);
							return false;
						}else if( !(regMail.test(changeInfoMall) ) ){
							tips("请输入正确的邮箱",3000);
							return false;				
						}else{
							//console.log("可以提交");				
							$.ajax({
								url:"api2.php?a=perfect",
								type:"post",
								dataType:"json",
								data:{
									name:changeInfoNmae,
									firm:changeInfoLTD,
									post:changeInfoPost,
									phone:changeInfoPhone,
									code:changeInfoCode,
									// sex:changeInfoSex,
									email:changeInfoMall
								},
								success:function(data){
									//console.log(data);
									if(data.error == 1){
										tips("提交失败，请核对邀请码",3000);
									}else{
										tips("提交成功",3000);
										
									}
								}
							});

							
						}
						//填过密码的 结束


					}
					


				});
				//完善资料结束




			}
		});
		//个人中心结束

		//修改密码
		$("#changePWDsubmit").on("click",function(){
			var changePWDphone = $("#changePWDphone").val();
				changePWDoldPwd = $("#changePWDoldPwd").val(),
				changePWDnewsPwd = $("#changePWDnewsPwd").val(),
				changePWDnewsPwdToo = $("#changePWDnewsPwdToo").val();

			if(!changePWDoldPwd){
				tips("请输入原密码",5000);
				return false;
			}else if( !(regPassword.test(changePWDnewsPwd)) ){
				tips("请输入6-18位<br>（数字或字母组成）的新密码",5000);
				return false;
			}else if(changePWDnewsPwd !== changePWDnewsPwdToo){
				tips("请重新核对新密码",5000);
				return false;
			}else{
				//console.log("全部输入正确了");
				$.ajax({
					url:"api2.php?a=modify",
					type:"post",
					dataType:"json",
					data:{
						phone:cookiePhone,
						password:changePWDoldPwd,
						new_password:changePWDnewsPwd
					},
					success:function(data){
						//console.log(data);
						if(data.error == 1){
							tips(data.info,5000);
							return false;
						}else if(data.error == 0){
							tips(data.info,1000);
							hrefURL("user_info.html",1000);
						}
					}
				});

			}
			
		});
		//修改密码结束




	}else{
		//如果没手机号码就登陆
		$login_button.on("click",function(){
			window.location.href="login.html";
		});

		// 登陆
		$("#loginSubmit").on("click",function(){
			var loginPhone = $("#loginPhone").val(),
				loginPassWord = $("#loginPassWord").val();
			if( !(regPhone.test(loginPhone)) ){
				tips("请输入正确的手机号码",5000);
				return false;
			}else if(!loginPassWord){
				tips("请输入密码",5000);
				return false;
			}else{

				$.ajax({
					url:"api2.php?a=login",
					type:"post",
					dataType:"json",
					data:{phone:loginPhone,password:loginPassWord},
					success:function(data){
						//console.log(data);
						if(data.error == 1){
							tips(data.info,5000);
						}else if(data.error == 0){
							setCookie("cookiePhone",loginPhone, 1);
							tips(data.info,5000);
							//console.log( getCookie("cookiePhone") ) ;
							hrefURL("index.html",1000);
						}
					}
				})

			}
		});
		//如果没手机号码就登陆 结束



	}


}







function pageIn(boxIn){
	if(!boxIn.is(":animated")){
		boxIn.show().animate({
			top:"0"
		});
	}
	
}

function pageOut(boxOut){
	if(!boxOut.is(":animated")){
		boxOut.animate({
			top:"100%"
		},function(){
			boxOut.hide();
		});
	}
}

function pageShow(boxShow){
	boxShow.fadeIn();
}

function tips(msgContent,msgTime){
	if( !$msg.is(":animated") ){
		$msg.html(msgContent).fadeIn(500,function(){
			setTimeout('$("#msg").fadeOut()',msgTime);
		});
	}
	
}


function hrefURL(URLlinks,TimeHref){	
	setTimeout(function LINKurl(){
		window.location.href=URLlinks;
	},TimeHref);		
}

$("input").focus(function() {
	$msg.hide();
});

	function removeDou(){
		$page3cut.removeClass("doudong");
	}
	function shaking(){
		$page3cut.addClass("doudong");
		setTimeout(removeDou,500);
	}

	setInterval(shaking,2500);




	 function is_weixin(){
        var ua = navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i)=="micromessenger") {
            return true;
        } else {
            return false;
        }
    }















});