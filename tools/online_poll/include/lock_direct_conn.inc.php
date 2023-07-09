<?
// 인클루드 되는 파일에 공통으로 사용되는 파일(외부접근방지)
// 현재파일을 직접 접근할 수 없도록 함
if (VG_OP_INCLUDE != "YES") die("<font color=red><b>비정상적인 접근 입니다.<br>" . date("Y-m-d H:i:s", time()) . " 현재시간, IP 기록됨 : $_SERVER[REMOTE_ADDR]</b></font>");
?>