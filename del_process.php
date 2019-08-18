<?php
session_start();
require("global_config.php");

if($_SERVER["REQUEST_METHOD"] != "POST"){exit("정상적인 접근이 아닙니다.");}

$_pwd_in = (isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"])) ? "" : $_POST["pass_in"];
$_post_id = $_POST["id"];

$_request_query = "SELECT pass FROM ${_use_tablename} WHERE id=${_post_id}";

$_db_connect = @mysqli_connect($_use_dbserver,$_use_username,$_use_userpwd);
if(!$_db_connect){exit("DB 연결에 실패하였습니다.");}

mysqli_select_db($_db_connect,$_use_dbname);

$_result = mysqli_query($_db_connect,$_request_query);

if(!$_result){exit("오류가 발생하였습니다.");}

$_row = mysqli_fetch_array($_result);

if($_row["pass"] == $_pwd_in || (isset($_SESSION["gb_master_uname"]) && isset($_SESSION["gb_master_key"]))){
$_delete_query = "DELETE FROM guestbook WHERE id=${_post_id}";
$_run_delete = mysqli_query($_db_connect,$_delete_query);
}else{exit("암호가 올바르지 않습니다.");}

header("Location: ./");
?>