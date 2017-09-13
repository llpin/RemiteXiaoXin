<?php
session_start();
error_reporting(E_ERROR);
date_default_timezone_set('Asia/Chongqing');
include './php/function.php';
//include './php/database.class.php';
$config=include './php/config.php';
//$Db=new database($config);
header('Access-Control-Allow-Origin:*');
$openid=$_SESSION['openid'];
//防止未及时关闭测试
if(empty($openid) && $config['debug']){
    $openid='oGnSIwEQZcR__4hq6FBAsQ9maOo0';
}

$type=$_REQUEST['a']?:'start';

//if(empty($openid)){
//    showerr('未获取到用户openid');
//}

try{
    if($type=='upload_base64') {


            if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg")
                    || ($_FILES["file"]["type"] == "image/pjpeg") || $_FILES["file"]["type"] == "image/png") && ($_FILES["file"]["size"] < 25842700)) {
                if ($_FILES["file"]["error"] > 0)
                {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                }else {
//				echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//				echo "Type: " . $_FILES["file"]["type"] . "<br />";
//				echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//				echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
                    $array = explode('.',$_FILES["file"]["name"]);
                    $filename		= time().rand(1000,2000).'.'.$array[1];
                    if (file_exists("./upload/" . $filename))
                    {
                        echo $_FILES["file"]["name"] . " already exists. ";
                    } else{
                        move_uploaded_file($_FILES["file"]["tmp_name"],"./upload/" . $filename);
                        showsuc('成功',array('url'=>"./upload/" . $filename));
                    }
                }
            } else {
                echo "Invalid file";
            }
        }
} catch(Exception $e) {
    showerr($e->getMessage());
}