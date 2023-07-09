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

$article_auth_info = $lib_insiter->get_article_auth($board_info, '', $user_info, "reply");
if ($article_auth_info != 'O') $GLOBALS[lib_common]->alert_url("����� ����� ������ �����ϴ�.");

if (trim($board_info[filter]) != '') $filter_chars = explode(",", $board_info[filter]);
include "{$DIRS[include_root]}form_input_filter.inc.php";

if ($input_method == "1") include "user_input_comment.inc.php";	// ����� �Է� ������

$query = "SELECT max(serial_num), max(fid) FROM $board_name";
$result = $GLOBALS[lib_common]->querying($query, "�ִ� fid ���� ������ ����");

$max_serial_num = mysql_result($result, 0, 0);
if ($max_serial_num) $new_serial_num = $max_serial_num + 1;
else $new_serial_num = 1;

$max_fid = mysql_result($result, 0, 1);
if ($max_fid) $new_fid = $max_fid + 1;
else $new_fid = 1;

if ($sign_date == -1 || $sign_date == "") $sign_date = time();

// ���� ���ε��
$file_ext = explode(',', $board_info[extensions]);
$save_dir = "design/upload_file/$board";	
$upload_file_name_array = array();
$upload_file_size_array = array();
for ($i=1; $i<=10; $i++) {														// �ִ� 10������ ���� ���ε� ����.
	$upload_file_name = $file_size = '';								// ���ε� ���ϰ��� ���������κ�
	$user_files = "user_file_" . $i;											// �ӽ�����
	$saved_user_files = "saved_user_file_" . $i;			// ���������
	if ($board_info[file_name_method] == 'N') $new_file_name = $new_serial_num . "_" . $i;
	else $new_file_name = '';
	$upload_file_name = $GLOBALS[lib_common]->file_upload($user_files, $$saved_user_files, $file_ext, $board_info[extensions_mode], $save_dir, $new_file_name);
	$upload_file_name_array[$i] = $upload_file_name;
}
$upload_files = implode(";", $upload_file_name_array);

// �Է°�����
$input_value = array();

if ($passwd == '') $input_value[passwd] = $sign_date;
else $input_value[passwd] = "[MYSQL]=password('$passwd')";

// ���̵� ����, ���� �Էµ� ���̵� ���� ��츸 ���Ǿ��̵� ����
if ($writer_id == '') $input_value[writer_id] = $user_info[id];
else $input_value[writer_id] = $writer_id;

if ($user_input_query != '') {
	include "user_input_query.inc.php";	// ����� ��������
} else {
	$input_value[serial_num] = $new_serial_num;
	$input_value[fid] = $new_fid;
	$input_value[writer_name] = $writer_name;
	$input_value[email] = $email;
	$input_value[phone] = $phone;
	$input_value[homepage] = $homepage;
	$input_value[subject] = $subject;
	$input_value[comment_1] = $comment_1;
	$input_value[comment_2] = $comment_2;
	$input_value[sign_date] = $sign_date;
	$input_value[count] = '1';
	$input_value[thread] = $new_thread;
	$input_value[reply_answer] = $reply_answer;
	$input_value[user_ip] = $_SERVER[REMOTE_ADDR];
	$input_value[user_file] = $upload_files;
	$input_value[file_size] = $upload_files_size;
	$input_value[vote] = '0';
	$input_value[category_1] = $category_1;
	$input_value[category_2] = $category_2;
	$input_value[category_3] = $category_3;
	$input_value[category_4] = $category_4;
	$input_value[category_5] = $category_5;
	$input_value[category_6] = $category_6;
	$input_value[type] = $type;
	$input_value[is_view] = $is_view;
	$input_value[is_notice] = $is_notice;
	$input_value[is_html] = $is_html;
	$input_value[is_private] = $is_private;
	$input_value[relation_table] = $relation_table;
	$input_value[relation_serial] = $relation_serial;
	$input_value[etc_1] = $etc_1;
	$input_value[etc_2] = $etc_2;
	$input_value[etc_3] = $etc_3;
	$GLOBALS[lib_common]->input_record($board_name, $input_value);
}

$send_test_email = "N";
$send_test_sms = "N";

$host_info = $lib_fix->get_user_info($site_info[site_id]);
// ������ �뺸����� �����Ǿ� �ִ°��
if (($board_info[notice_email] == 'Y' || $board_info[notice_sms] == 'Y') && $user_info[id] != $site_info[site_id]) {
	// �̸��� ������ Ȱ��ȭ�� ���
	if ($host_info[email] != '' && $board_info[notice_email] == 'Y') {
		if ($is_html != 'Y') $contents = nl2br(htmlspecialchars(stripslashes($comment_1)));
		else $contents = stripslashes($comment_1);
		if ($send_test_email == "Y") {
			echo($contents);
		} else {
			if ($writer_name != '') $from_name = $writer_name;
			else $from_name = $host_info[name];
			if ($email != '') $from_email = $email;
			else $from_email = $host_info[email];
			if ($host_info[phone_mobile] != '') $mobile_phone = ", $host_info[phone_mobile]";
			if ($host_info[email] != '') $email = ", $host_info[email]";
			if ($host_info[homepage] != '') $homepage = ", $host_info[homepage]";
			$send_mail_etc_info[footer] = "
				��ȣ : $site_info[site_name] / $host_info[address]<br>
				����ó : {$host_info[phone]}{$mobile_phone}{$email}{$homepage}
			";
			$GLOBALS[lib_common]->mailer($host_info[name], $from_email, $host_info[email], "{$site_info[site_name]},{$board_info[alias]}�� ��� ���.", $contents, '1', '', "EUC-KR", '', '', "{$DIRS[design_root]}skin/mail.html", '', 'Y', $host_info[name], 'Y', $send_mail_etc_info);
		}
	}
	// SMS ������ Ȱ��ȭ�� ���
	if ($host_info[phone_mobile] != "" && $board_info[notice_sms] == "Y") {
		// SMS ���뼳���κ�		
		$sms_site_id = $site_info[site_id];
		$sms_phone = $host_info[phone_mobile];	// �������� ������
		$sms_send_phone = $phone;
		$sms_message = "{$site_info[site_name]},{$board_info[alias]}�Խ��Ǵ�۵��,$subject";
		$sms_message = $GLOBALS[lib_common]->str_cutstring($sms_message, 80, "");
		$lib_insiter->send_sms($sms_site_id, $sms_phone, $sms_send_phone, $sms_message, $send_test_sms);
	}
}

// �亯�� �뺸����� �����Ǿ� �ִ°��
if (($board_info[notice_user_email] == 'Y' || $board_info[notice_user_sms] == 'Y')) {
	$query = "select * from $input_value[relation_table] where serial_num='$relation_serial'";
	$result = $GLOBALS[lib_common]->querying($query);
	$src_article_info = mysql_fetch_array($result);
	// �̸��� ������ Ȱ��ȭ�� ��� ���� �ۼ��ڿ��� �̸��� �߼�(�̸����� ������츸 �߼۵�)
	if ($src_article_info[email] != '' && $board_info[notice_user_email] == 'Y') {
		if (strlen($comment_1) == strlen(strip_tags($comment_1))) $contents = nl2br(htmlspecialchars(stripslashes($comment_1)));
		else $contents = stripslashes($comment_1);
		if ($send_test_email == "Y") {
			echo($html_contents);
		} else {
			if ($host_info[phone_mobile] != '') $mobile_phone = ", $host_info[phone_mobile]";
			if ($host_info[email] != '') $T_email = ", $host_info[email]";
			if ($host_info[homepage] != '') $homepage = ", $host_info[homepage]";
			$send_mail_etc_info[footer] = "
				��ȣ : $site_info[site_name] / $host_info[address]<br>
				����ó : {$host_info[phone]}{$mobile_phone}{$T_email}{$homepage}
			";
			$GLOBALS[lib_common]->mailer($site_info[site_name], $email, $src_article_info[email], "{$site_info[site_name]}�� ����Ͻ� ���뿡 ���� ��� �Դϴ�.", $contents, '1', '', "EUC-KR", '', '', "{$DIRS[design_root]}skin/mail.html", '', 'Y', $src_article_info[name], 'Y', $send_mail_etc_info);
		}
	}

	// SMS ������ Ȱ��ȭ�� ���(�ڵ����� ���� ��츸 �߼۵�)
	if ($src_article_info[phone] != '' && $board_info[notice_user_sms] == 'Y') { 
		// SMS ���뼳���κ�		
		$sms_site_id = $site_info[site_id];
		$sms_phone = $src_article_info[phone];	// �������� ���� �۾���
		$sms_send_phone = $phone;
		$sms_message = "{$site_info[site_name]}����ϵȳ��뿡���Ѵ�۵�ϵ�=>http://{$_SERVER[HTTP_HOST]}";
		$sms_message = $GLOBALS[lib_common]->str_cutstring($sms_message, 80, "");
		$lib_insiter->send_sms($sms_site_id, $sms_phone, $sms_send_phone, $sms_message, $send_test_sms);
	}
}
if ($send_test_email == 'Y' || $send_test_sms == 'Y') exit;

// ó���� �̵��� ������ �� ���� �� ��ũ��Ʈ ����
$after_msg = "���� ��� �Ǿ����ϴ�. �����մϴ�.";
$change_vars = array();
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
	$move_page_link = "{$root}{$site_info[index_file]}?{$move_page_link_tail}";
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