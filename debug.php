<?php
if($_GET["pinfo"] == 1){phpinfo();}
else{
 require("global_config.php");
 $_db_connect = @mysqli_connect($_use_dbserver,$_use_username,$_use_userpwd);
 if(!$_db_connect){exit("오류 : DB 연결에 실패하였습니다.");}
?>
<pre>
서버 환경 정보입니다. (<a href="<?=$_SERVER["PHP_SELF"]?>?pinfo=1">PHP 정보 보기</a>)
Printed at <?=date("r")."\n"?>
============================
<?php
print "PHP version : ".phpversion()."\n";
print "MySQL character set : ".mysqli_character_set_name($_db_connect)."\n";
print "MySQL version : ".mysqli_get_server_info($_db_connect)."\n";
print "Host Address : ".$_SERVER["HTTP_HOST"]." (".$_SERVER["SERVER_ADDR"].")\n";
print "Remote Address : ".$_SERVER["REMOTE_ADDR"]." (".hexdec(bin2hex(inet_pton($_SERVER["REMOTE_ADDR"]))).")\n";
?>
============================
</pre>
<? } ?>