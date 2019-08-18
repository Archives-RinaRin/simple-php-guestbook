<?php
## 이 파일을 자신의 환경에 알맞게 수정하여 사용해주시기 바랍니다 ##

$_use_dbserver = "your.db.serveraddr"; // DB 서버 주소
$_use_username = "your.db.username"; // DB 사용자명
$_use_userpwd = "your.db.password"; // DB 비밀번호
$_use_dbname = $_use_username; // DB 이름
$_use_tablename = "guestbook"; // 테이블 이름

$_master_uname = "admin"; // 관리자 사용자명
$_master_pwd = "your.password"; // 관리자 비밀번호
$_master_timeout = 1800; // 세션 만료시간 (초 단위)
$_master_displayname = "관리자"; // 관리자 닉네임
$_master_mail = "admin@example.com"; // 관리자 이메일
$_master_website = "http://example.com"; // 관리자 웹사이트

$_seckey = "your-recaptcha-secret"; // 구글 recaptcha api 비밀키
?>