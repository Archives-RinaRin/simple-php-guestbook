<?php
session_start();
require("global_config.php");

$_post_id = $_GET["id"];

$_request_query = "SELECT pass FROM ${_use_tablename} WHERE id=${_post_id}";

$_db_connect = @mysqli_connect($_use_dbserver,$_use_username,$_use_userpwd);
if(!$_db_connect){exit("DB 연결에 실패하였습니다.");}

mysqli_select_db($_db_connect,$_use_dbname);

$_result = mysqli_query($_db_connect,$_request_query);

if(!$_result){exit("오류가 발생하였습니다.");}

$_row = mysqli_fetch_array($_result);

if(isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"])){
$_approve_query = "UPDATE guestbook SET approved=1 WHERE id=${_post_id}";
$_run_approve = mysqli_query($_db_connect,$_approve_query);
}else{exit("관리자로 로그인되어있지 않습니다.");}

header("Location: ./");
?>