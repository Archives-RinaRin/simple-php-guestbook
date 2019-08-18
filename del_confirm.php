<?php
session_start();
require("global_config.php");

if(!isset($_GET["id"])){exit("정상적인 접근이 아닙니다.");}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>방명록 글 지우기</title>
<link rel="stylesheet" type="text/css" href="./css/common.css" />
<link rel="stylesheet" type="text/css" href="./css/guestbook.css" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
</head>
<body>
<div id="del_confirm">
<form method="post" action="./del_process.php">
<input type="hidden" name="id" value="<?=$_GET["id"]?>" />
<? if(isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"])){ ?>
아래의 버튼을 누르시면 글이 삭제됩니다.<br />
<? }else{ ?>
암호를 입력하세요<br />
<input type="password" name="pass_in" maxlength="20" size="15" />
<? } ?>
<input type="submit" value="확인" />
</form>
</div>
</body>
</html>