<?
include "../include/verify_input.inc.php";	// ���������� �Է� ����
$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "{$DIRS[include_root]}form_input_filter.inc.php";

if ($user_id_second != '') $user_id = $user_id_second;
if ($user_pw_second != '') $user_passwd = $user_pw_second;

$file_login_level = "user_define/login_level.inc.php";
if (file_exists($file_login_level)) include $file_login_level;			// �������� �α��� ���α׷��� �����ؾ� �ϴ°�� �ش� ���� ���������
include "login_process.inc.php";																// �α��� ���μ��� ����
include "login_log.inc.php";																		// �α��� �α��ۼ�	

// ���̵�����
if ($save_user_id == 'Y') setcookie("VG_save_user_id", $T_user_info[id], time()+60*60*24*30*$site_info[life_month_cookie], '/', ".{$PU_host[host]}");
else setcookie("VG_save_user_id", $T_user_info[id], time()-3600, '/', ".{$PU_host[host]}");
// ��й�ȣ����
if ($save_user_passwd == 'Y') setcookie("VG_save_user_passwd", $user_passwd, time()+60*60*24*30*$site_info[life_month_cookie], '/', ".{$PU_host[host]}");
else setcookie("VG_save_user_passwd", $pw, time()-3600, '/', ".{$PU_host[host]}");

// ó���� �̵��� ������ �� ���� �� ��ũ��Ʈ ����
if ($after_db_msg == 'Y') {
	echo("
		<script language='javascript1.2'>
			<!--
				alert('�α��� �Ǿ����ϴ�.');
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