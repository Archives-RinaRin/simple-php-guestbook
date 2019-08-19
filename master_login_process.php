<?php
require("global_config.php");

if($_SERVER["REQUEST_METHOD"] != "POST"){exit("정상적인 접근이 아닙니다.");}
if($_POST["master_uname"] != $_master_uname || $_POST["master_pwd"] != $_master_pwd){exit("관리자 ID 혹은 암호가 일치하지 않습니다.");}

if(isset($_POST["g-recaptcha-response"])){$_captcha = $_POST["g-recaptcha-response"];}
if(!$_captcha){exit("자동입력방지 검증에 실패하였습니다.");}

$_clientaddr = $_SERVER["REMOTE_ADDR"];

$_ch = curl_init();
curl_setopt($_ch,CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify?secret=".$_seckey."&response=".$_captcha."&remoteip=".$_clientaddr);
curl_setopt($_ch,CURLOPT_RETURNTRANSFER,true);

$_response = curl_exec($_ch);

$_captcha_response = json_decode($_response,true);

if($_captcha_response["success"]){}
else{exit("비정상적인 로그인 시도가 감지되었습니다.");}

session_start();
$_SESSION["gb_master_uname"] = $_POST["master_uname"];
$_SESSION["gb_master_key"] = hash("sha256",$_POST["master_pwd"]);

header("Location: ./");
?>