<?php
session_start();
require("global_config.php");

if($_SERVER["REQUEST_METHOD"] != "POST"){exit("정상적인 접근이 아닙니다.");}

if(isset($_POST["g-recaptcha-response"])){$_captcha = $_POST["g-recaptcha-response"];}
if(!$_captcha){exit("자동등록방지 검증에 실패하였습니다.");}

$_clientaddr = $_SERVER["REMOTE_ADDR"];

$_ch = curl_init();
curl_setopt($_ch,CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify?secret=".$_seckey."&response=".$_captcha."&remoteip=".$_clientaddr);
curl_setopt($_ch,CURLOPT_RETURNTRANSFER,true);

$_response = curl_exec($_ch);

$_captcha_response = json_decode($_response,true);

if($_captcha_response["success"]){}
else{exit("비정상적인 등록 시도가 감지되었습니다.");}

$_username = addslashes(htmlspecialchars($_POST["name"]));
$_userpwd = addslashes($_POST["pass"]);
$_userhome = addslashes(htmlspecialchars(strip_tags($_POST["home"])));
$_usermail = addslashes($_POST["mail"]);
$_post_content = addslashes(htmlspecialchars(strip_tags($_POST["content"])));
$_useraddr = addslashes($_SERVER["REMOTE_ADDR"]);

$_valid_url_pattern = "%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu";

if((strlen($_userhome) > 0) && (preg_match($_valid_url_pattern,$_userhome) === false)){$_userhome = "";}

$_db_connect = @mysqli_connect($_use_dbserver,$_use_username,$_use_userpwd);
if(!$_db_connect){exit("DB 연결에 실패하였습니다.");}

mysqli_select_db($_db_connect,$_use_dbname);

mysqli_query($_db_connect,"set names utf8");

if(isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"])){
$_is_admin = 1;
$_username = $_master_displayname;
$_userpwd = $_master_pwd;
$_usermail = $_master_mail;
$_userhome = $_master_website;
}else{$_is_admin = 0;}

$_content_query = "INSERT INTO ${_use_tablename} (name, pass, home, mail, comment, useraddr, rdate, approved) VALUES ";
$_content_query .= "('${_username}','${_userpwd}','${_userhome}','${_usermail}','${_post_content}','${_useraddr}',now(),${_is_admin});";

$_result = mysqli_query($_db_connect,$_content_query);

if(!$_result){exit("오류가 발생하였습니다.");}

header("Location: ./");
?>