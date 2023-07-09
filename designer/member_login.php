<?
include "header_proc.inc.php";
include "{$root}member/login_process.inc.php";		// 로그인 수행 프로세스
$GLOBALS[lib_common]->alert_url("로그인되었습니다", 'E', "../index.html");
?>