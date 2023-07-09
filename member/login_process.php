<?
include "../include/verify_input.inc.php";	// 비정상적인 입력 방지
$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "{$DIRS[include_root]}form_input_filter.inc.php";

if ($user_id_second != '') $user_id = $user_id_second;
if ($user_pw_second != '') $user_passwd = $user_pw_second;

$file_login_level = "user_define/login_level.inc.php";
if (file_exists($file_login_level)) include $file_login_level;			// 레벨별로 로그인 프로그램을 구현해야 하는경우 해당 파일 사용자정의
include "login_process.inc.php";																// 로그인 프로세스 수행
include "login_log.inc.php";																		// 로그인 로그작성	

// 아이디저장
if ($save_user_id == 'Y') setcookie("VG_save_user_id", $T_user_info[id], time()+60*60*24*30*$site_info[life_month_cookie], '/', ".{$PU_host[host]}");
else setcookie("VG_save_user_id", $T_user_info[id], time()-3600, '/', ".{$PU_host[host]}");
// 비밀번호저장
if ($save_user_passwd == 'Y') setcookie("VG_save_user_passwd", $user_passwd, time()+60*60*24*30*$site_info[life_month_cookie], '/', ".{$PU_host[host]}");
else setcookie("VG_save_user_passwd", $pw, time()-3600, '/', ".{$PU_host[host]}");

// 처리후 이동할 페이지 및 수행 할 스크립트 설정
if ($after_db_msg == 'Y') {
	echo("
		<script language='javascript1.2'>
			<!--
				alert('로그인 되었습니다.');
			//-->
		</script>
	");
}
if ($after_db_script == '') {
	if ($http_referer == '') $move_page_link = "{$root}{$site_info[index_file]}?design_file=home.php";
	else $move_page_link = $http_referer;
	$GLOBALS[lib_common]->alert_url('', 'E', $move_page_link);
} else {
	$change_vars = array("design_file"=>'');
	$move_page_link_tail = $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	$after_db_script = stripslashes($after_db_script);
	$after_db_script = stripslashes($after_db_script);
	$after_db_script = str_replace("%LINK%", $move_page_link_tail, $after_db_script);
	echo("
		<script language='javascript1.2'>
			<!--
				$after_db_script
			//-->
		</script>
	");	
}
?>