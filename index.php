<?php
session_start();
require("global_config.php");

$_db_connect = @mysqli_connect($_use_dbserver,$_use_username,$_use_userpwd);
if(!$_db_connect){exit("오류 : DB 연결에 실패하였습니다.");}

mysqli_select_db($_db_connect,$_use_dbname);

mysqli_query($_db_connect,"set names utf8");

$_query = "SELECT * FROM ${_use_tablename} ORDER BY id DESC";

$_result = mysqli_query($_db_connect,$_query);
$_count = mysqli_affected_rows($_db_connect);

$_pagelength = 5;

// 테이블이 없을 시 자동 생성
if($_count < 0){
$_query_firstrun = <<<END
CREATE TABLE ${_use_tablename} (
id int(11) UNSIGNED NOT NULL auto_increment,
name varchar(40),
pass varchar(40),
home varchar(40),
mail varchar(35),
comment text,
useraddr varchar(17),
rdate datetime,
approved tinyint(1),
PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;
END;

$_run_create = mysqli_query($_db_connect,$_query_firstrun);

if($_run_create == false){exit("테이블 생성 실패!!");}

}

$_pagerevision = date("YmdHis",filemtime(basename($_SERVER["PHP_SELF"]))).".".substr(sha1_file(basename($_SERVER["PHP_SELF"])),0,8);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>방명록</title>
<link rel="stylesheet" type="text/css" href="./css/common.css" />
<link rel="stylesheet" type="text/css" href="./css/guestbook.css" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<!-- 구글 recaptcha 실행 부분 (아래 주소의 'your-recaptcha-key' 부분에 자신이 발급받은 키를 입력한다) -->
<script src="https://www.google.com/recaptcha/api.js?render=your-recaptcha-key"></script>
<script type="text/javascript">
<!--
// 구글 recaptcha 실행 부분 ('your-recaptcha-key' 부분에 자신이 발급받은 키를 입력한다)
grecaptcha.ready(function(){
 grecaptcha.execute("your-recaptcha-key",{action: "guestbook"})
 .then(function(token) {
  document.getElementById("g-recaptcha-response").value = token;
 });
});
//-->
</script>
</head>
<body id="guestbook">

<p style="text-align: center; margin-top: 4.5em;" class="w3-large"><b>방명록 게시판</b></p>

<p style="text-align: center;">
하실 말을 자유롭게 남기고 가세요.<br />
</p>


<p style="text-align: right; margin: 0.5em;" class="fonts_small">
<? if(isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"])){ ?>
<a href="./master_logout.php">관리자 로그아웃</a>
<? }else{ ?>
<a href="./master_login.php">관리자 로그인</a>
<? } ?>
<br />
버전 <?=$_pagerevision?>
</p>

<hr style="width: 100%; margin-top: 1.5em; margin-bottom: 1.5em;" />

<div id="guestbook_body">
<form method="post" action="./insert.php">
<table id="guestbook_form">
<? if(!(isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"]))){ ?>
<tr><td class="field_name req_field">이름</td><td class="form_field"><input type="text" name="name" class="guestbook_input_a" maxlength="20" size="8" required /></td></tr>
<tr><td class="field_name req_field">비밀번호</td><td class="form_field"><input type="password" name="pass" class="guestbook_input_a" maxlength="20" size="8" required /></td></tr>
<tr><td class="field_name req_field">메일</td><td class="form_field" colspan="3"><input type="email" name="mail" class="guestbook_input_a" maxlength="35" size="8" required /></td></tr>
<tr><td class="field_name">홈페이지</td><td class="form_field"><input type="url" name="home" class="guestbook_input_b" maxlength="40" size="27" /></td></tr>
<? } ?>
<tr><td class="field_name req_field" colspan="2" style="text-align: center;">내용</td></tr>
<tr>
<td class="field_name" colspan="2">
<div id="comment_content">
<textarea name="content" id="post_content" required></textarea>
</div>
</tr>
<tr>
<td class="field_name req_field">자동입력방지</td>
<td class="form_field">
<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
<span class="fonts_small">자동 입력 방지 적용중입니다. (<a href="http://hisweek.net/221403505415">자세히 알아보기</a>)</span>
</tr>
<tr>
<td class="field_name" colspan="2">
<input type="submit" class="post_buttons" value="쓰기" />&nbsp;<input type="reset" class="post_buttons" value="내용 초기화" />
</td>
</tr>
</table>
</form>

<hr style="width: 100%; margin-top: 1.5em; margin-bottom: 1.5em;" />

<div id="post_list" style="margin-top: 2em; font-size: 90%;">
<?php
if(!isset($_GET["from"])){$_start = 0;}
else{$_start = $_GET["from"];}

if($_count > 0){
 for($i=$_start;$i<=$_start+$_pagelength;$i++){
 if($i < $_count){
  mysqli_data_seek($_result,$i);
  $_rows = mysqli_fetch_array($_result);

  $content_comment = str_replace("\n","<br />",stripslashes($_rows["comment"]));

  $is_v4 = preg_match("/^([0-9]{1,3}\.){3}[0-9]{1,3}$/",$_rows["useraddr"]);
  $is_v6 = preg_match("/^[0-9a-f]{1,4}:([0-9a-f]{0,4}:){1,6}[0-9a-f]{1,4}$/",$_rows["useraddr"]);

  if($is_v4){$_privacy_addr = preg_replace("/\.\d\.\d*$/",".***.***",$_rows["useraddr"]);}
  elseif($is_v6){$_privacy_addr = preg_replace("/[\da-f]*:[\da-f]*$/","****:****",$_rows["useraddr"]);}
?>
<table class="post_info">
<tr><td width="12%" class="post_num">No. <?=$_count-$i?><br /><span class="fonts_small">(ID : <?=$_rows["id"]?>)</span></td>
<td width="33%" class="post_user">글쓴이 : <a href="<?=(strlen($_rows["home"]) > 0) ? $_rows["home"] : "#"?>"><?=(strlen($_rows["name"]) > 0) ? $_rows["name"] : "(익명)"?></a><br /><span class="fonts_small">[IP 주소 : <?=$_privacy_addr?>]</span></td>
<td class="post_time">작성 시간 : <?=$_rows["rdate"]?></td>
<td class="post_del"><? if(isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"]) && $_rows["approved"] == 0){ ?><a href="master_approve.php?id=<?=$_rows["id"]?>">승인</a>&nbsp;<? } ?><a href="del_confirm.php?id=<?=$_rows["id"]?>">삭제</a></td></tr>
<tr>
<td colspan="4">
<div class="guestbook_posts" id="gpost_<?=$_rows["id"]?>">
<?php
if($_rows["approved"] == 1){print (strlen($content_comment) > 0) ? $content_comment : "(내용 없음)";}
else{
?>
<div class="non_approved" style="color: #AABBCC;">(관리자의 승인을 기다리고 있는 글입니다)</div>
<?php
}
?>
</div>
</td>
</tr>
</table>
<?php
  }
 }
}else{
?>
<div style="text-align: center;" class="post_info">포스트가 없습니다.</div>
<?php
}

$_prev = $_start-$_pagelength;
$_next = $_start+$_pagelength;
?>
<div style="text-align: center;">
<? if($_prev >= 0){ ?>
<span id="go_prev"><a href="<?=$_SERVER["PHP_SELF"]?>?from=<?=$_prev?>">이전</a></span>
<?php
}

if($_next < $_count){
?>
&nbsp;<span id="go_next"><a href="<?=$_SERVER["PHP_SELF"]?>?from=<?=$_next?>">다음</a></span>
<?php
}

if(isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"])){
?>
[<a href="master_clean.php">승인되지 않은 모든 글 삭제</a>]
<? } ?>
</div>
</div>
</div>
</body>
</html>