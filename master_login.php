<?php
session_start();
require("global_config.php");

if(isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"])){exit("이미 로그인되어 있습니다.");}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>관리자 로그인</title>
<link rel="stylesheet" type="text/css" href="./css/common.css" />
<link rel="stylesheet" type="text/css" href="./css/guestbook.css" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<script src="https://www.google.com/recaptcha/api.js?render=your-recaptcha-key"></script>
<script type="text/javascript">
<!--
grecaptcha.ready(function(){
 grecaptcha.execute("your-recaptcha-key",{action: "guestbook_admin"})
 .then(function(token) {
  document.getElementById("g-recaptcha-response").value = token;
 });
});
//-->
</script>
</head>
<body>
<form method="post" action="./master_login_process.php">
<table id="master_login_form">
<tr><td colspan="2" style="text-align: center;">관리자 로그인</td></tr>
<tr><td>ID</td><td><input type="text" name="master_uname" maxlength="20" size="15" required /></td></tr>
<tr><td>암호</td><td><input type="password" name="master_pwd" maxlength="20" size="15" required /></td></tr>
<tr><td colspan="2" style="text-align: center;">
<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
<span class="fonts_small">자동 입력 방지 적용중입니다.</span>
</td></tr>
<tr><td colspan="2" style="text-align: center;">
<input type="submit" value="로그인" />
</td></tr>
</table>
</form>
</body>
</html>