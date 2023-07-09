<?
/*----------------------------------------------------------------------------------
 * ���� : �λ���Ʈ �Խ��� ���� ���� ���α׷�
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

if (trim($board_info[filter]) != '') $filter_chars = explode(',', $board_info[filter]);
include "{$DIRS[include_root]}form_input_filter.inc.php";

$article_value = $GLOBALS[lib_common]->get_data($board_name, "serial_num", $article_num);
$article_auth_info = $lib_insiter->get_article_auth($board_info, $article_value, $user_info, "modify");
if ($article_auth_info != 'O') $GLOBALS[lib_common]->alert_url("��й�ȣ�� Ʋ�Ȱų� ������ �� �ִ� ������ �����ϴ�.");

if ($input_method == "1") include "user_input_comment.inc.php";	// ����� �Է� ������

$file_ext = explode(',', $board_info[extensions]);
$save_dir = "design/upload_file/$board";
if ($move_article == "Y") {	 // �Խù� �ֻ��� �̵��̸�(�켱 ������ ���� �Ѿ��)
	$query = "SELECT max(serial_num), max(fid) FROM $board_name";
	$result = $GLOBALS[lib_common]->querying($query, "�ִ� �Ϸù�ȣ ���� ������ ����");
	$new_serial_num = mysql_result($result, 0, 0) + 1;
	$new_fid = mysql_result($result, 0, 1) + 1;
	$query = "update $board_name set serial_num=$new_serial_num, fid=$new_fid where serial_num='$article_num'";
	$GLOBALS[lib_common]->querying($query, "�Ϸù�ȣ ���� ������ ����");
} else {
	// ���� ���ε��
	$upload_file_name_array = explode(';', $article_value[user_file]);
	for ($i=1; $i<=10; $i++) {																		// �ִ� 10������ ���� ���ε� ����.
		$box_name = "user_file";																	// �Է»����̸�
		$user_files = "{$box_name}_" . $i;												// �ӽ�����
		if (!isset($_FILES[$user_files][tmp_name])) continue;		// �Է»��ڰ� �������� ������ �ǳʶ�
		$saved_user_files = "saved_{$box_name}_" . $i;				// ���������
		$is_delete = "delete_file_{$box_name}_" . $i;						// ���ϻ���üũ���ڸ�
		if ($$is_delete == 'Y') {																		// ��������ϻ���
			$delete_file_full = "{$root}{$save_dir}/{$upload_file_name_array[$i-1]}";
			if (!@unlink($delete_file_full)) echo("<script>alert('��������($delete_file_full) ��������')</script>");
			else $upload_file_name_array[$i-1] = '';
		}
		switch ($board_info[file_name_method]) {
			case 'N' :
				$new_file_name = $article_value[serial_num] . "_" . $i;
			break;
			case 'T' :
				$new_file_name = $GLOBALS[w_time] . "_" . $i;
			break;
			default :
				$new_file_name = '';
			break;
		}
		$upload_file_name_array[$i-1] = $GLOBALS[lib_common]->file_upload($user_files, $$saved_user_files, $file_ext, $board_info[extensions_mode], $save_dir, $new_file_name);
	}
	$upload_files = implode(';', $upload_file_name_array);
	$input_value = array();
	if (isset($writer_name)) $input_value[writer_name] = $writer_name;
	if (isset($email)) $input_value[email] = $email;
	if (isset($phone)) $input_value[phone] = $phone;
	if (isset($homepage)) $input_value[homepage] = $homepage;
	if (isset($subject)) $input_value[subject] = $subject;
	if (isset($comment_1)) $input_value[comment_1] = $comment_1;
	if (isset($comment_2)) $input_value[comment_2] = $comment_2;
	if (isset($chg_passwd) && $chg_passwd != '') $input_value[passwd] = "[MYSQL]=password('$chg_passwd')";
	if (isset($reply_answer)) $input_value[reply_answer] = $reply_answer;
	if (isset($upload_files)) $input_value[user_file] = $upload_files;
	if (isset($upload_files_size)) $input_value[file_size] = $upload_files_size;
	if (isset($category_1)) $input_value[category_1] = $category_1;
	if (isset($category_2)) $input_value[category_2] = $category_2;
	if (isset($category_3)) $input_value[category_3] = $category_3;
	if (isset($category_4)) $input_value[category_4] = $category_4;
	if (isset($category_5)) $input_value[category_5] = $category_5;
	if (isset($category_6)) $input_value[category_6] = $category_6;
	if (isset($type)) $input_value[type] = $type;
	$input_value[is_view] = $is_view;
	$input_value[is_notice] = $is_notice;
	$input_value[is_html] = $is_html;
	$input_value[is_private] = $is_private;
	if (isset($relation_table)) $input_value[relation_table] = $relation_table;
	if (isset($relation_serial)) $input_value[relation_serial] = $relation_serial;
	if (isset($etc_1)) $input_value[etc_1] = $etc_1;
	if (isset($etc_2)) $input_value[etc_2] = $etc_2;
	if (isset($etc_3)) $input_value[etc_3] = $etc_3;
	if (isset($sign_date)) $input_value[sign_date] = $sign_date;
	if (isset($modify_date)) $input_value[modify_date] = $modify_date;
	else $input_value[modify_date] = $GLOBALS[w_time];
	if (isset($writer_id)) $input_value[writer_id] = $writer_id;
	$GLOBALS[lib_common]->modify_record($board_name, "serial_num", $article_num, $input_value);
	include "user_input_query.inc.php";	// ����� ��������
}

// ó���� �̵��� ������ �� ���� �� ��ũ��Ʈ ����
$after_msg = "���� ���� �Ǿ����ϴ�. �����մϴ�.";
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