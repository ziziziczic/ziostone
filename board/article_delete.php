<?
/*----------------------------------------------------------------------------------
 * ���� : �λ���Ʈ �Խù� ���� ���α׷�
 * �߿� ����:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */

include "../include/verify_input.inc.php";	// ���������� �Է� ����

$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";

$board_info = $lib_fix->get_board_info($_POST[board]);
$board_name = "{$DB_TABLES[board]}_{$board_info[name]}";

$article_value = $GLOBALS[lib_common]->get_data($board_name, "serial_num", $article_num);
$article_auth_info = $lib_insiter->get_article_auth($board_info, $article_value, $user_info, "delete");
if ($article_auth_info != 'O') $GLOBALS[lib_common]->alert_url("��й�ȣ�� Ʋ�Ȱų� ������ �� �ִ� ������ �����ϴ�.");

$article_fid = $article_value[fid];
$article_thread = $article_value[thread];
$reply_delete = false;

if ($input_method == "1") include "user_input_comment.inc.php";	// ����� �Է� ������

	######### �����ϰ��� �ϴ� ���� �亯���� �ϳ��� �ް� ������ ������ �� ������ �Ѵ�. ##########

if(!$reply_delete) {
	$query = "SELECT thread FROM $board_name WHERE fid = $article_fid AND length(thread) = length('$article_thread')+1 AND locate('$article_thread',thread) = 1 ORDER BY thread DESC LIMIT 1";
	$result = $GLOBALS[lib_common]->querying($query);
	$rows = mysql_num_rows($result);
	if($rows) $GLOBALS[lib_common]->alert_url("�亯���� �ִ� �Խù��Դϴ�. �亯���� ���� ������ �ּ���.");
}

$saved_files = explode(";", $article_value[user_file]);
for ($i=0; $i<sizeof($saved_files); $i++) {
	$saved_file = "{$DIRS[design_root]}upload_file/$board_info[name]/$saved_files[$i]";
	if (file_exists($saved_file) && ($saved_files[$i] != "")) unlink($saved_file);		
}
if ($user_input_query != "") {
	include "user_input_query.inc.php";	// ����� ��������
} else {
	$query = "DELETE FROM $board_name WHERE fid=$article_fid AND thread = '$article_thread'";
}
$result = $GLOBALS[lib_common]->querying($query, "�Խù� ���� ���� ������ �����߻�");

// ó���� �̵��� ������ �� ���� �� ��ũ��Ʈ ����
$after_msg = "���������� ���� �Ǿ����ϴ�.";
$change_vars = array("design_file"=>'');
$move_page_link_tail = $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
if ($after_db_msg == 'Y') {
	echo("
		<script language='javascript1.2'>
			<!--
				alert('$after_msg');
			//-->
		</script>
	");
}
if ($after_db_script == '') {
	$move_page_link = "{$root}{$site_info[index_file]}?design_file={$board_info[list_page]}&{$move_page_link_tail}";
	$GLOBALS[lib_common]->alert_url('', 'E', $move_page_link);
} else {
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