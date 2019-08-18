<?php
session_start();
require("global_config.php");

$_db_connect = @mysqli_connect($_use_dbserver,$_use_username,$_use_userpwd);
if(!$_db_connect){exit("DB 연결에 실패하였습니다.");}

mysqli_select_db($_db_connect,$_use_dbname);

if(isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"])){
$_clean_query = "DELETE FROM ${_use_tablename} WHERE approved=0";
$_run_clean = mysqli_query($_db_connect,$_clean_query);
}else{exit("관리자로 로그인되어있지 않습니다.");}

header("Location: ./");
?>