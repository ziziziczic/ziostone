<?
if ($flag != $_SERVER[HTTP_HOST]) die("���������� �Է��� ������ �ʽ��ϴ�.");
include "include/manager_header.inc.php";
include "{$vg_mailing_dir_info['include']}post_var_filter.inc.php";

$mail_from_name = stripslashes($from_name);
$mail_from_mail = stripslashes($from_mail);
$mail_subject = stripslashes($subject);

// ���� ���� �ҷ�����
$mail_file = $vg_mailing_dir_info[contents] . $contents_file;
if (!file_exists($mail_file)) $lh_common->die_msg("�����Ͻ� ������ ã�� �� �����ϴ�. �ٽ� Ȯ���� �ּ���. <a href='javascript:history.back()'>[�ڷΰ���]</a>");
$fp = fopen ($mail_file, "r");
if (!$fp) die("���� ���� ���� ����!!");
$mail_contents = fread($fp, 10000);
fclose ($fp);

if ($is_preview == 'P') {
	echo("<b>���� : $mail_subject</b><br><br>");
	echo($mail_contents);
	echo("<br><br><a href='javascript:history.back()'>[���ư���]</a>");
	exit;
}

$name_list_array = $email_list_array = $sended_emails = array();
$query = urldecode($sch_query);
$result = $lh_common->querying($query);
while ($value = mysql_fetch_array($result)) {
	$name_list_array[] = $value[$vg_mailing_field_name[name]];
	$email_list_array[] = $value[$vg_mailing_field_name[email]];
}
$total_email_num = sizeof($email_list_array);
echo "<font size=2>";
echo("<p>�� $total_email_num ���� �߼����Դϴ�..<br>");
echo "<p><b>{$vg_mailing_setup[send_pack]} �Ǿ� ������ {$vg_mailing_setup[send_term]} �ʸ� ���ϴ�.</b> <font color=#CC3300>[��] �̶�� �ܾ ������ ������ �߰��� �������� ���ʽÿ�!</font><br><br>";
$cnt = 0;
for ($i=0; $i<count($email_list_array); $i++) {
	$email = trim($email_list_array[$i]);
	$name = trim($name_list_array[$i]);
	// �׽�Ʈ �ΰ�� �α����� ����� �̸��Ϸ� �׽�Ʈ
	if ($is_preview == 'T') $email = $vg_mailing_setup[test_email];
	$cm = ereg("[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*", $email);
	if ($cm == true) {	// �ùٸ� ���� �ּҸ�		
		$cnt++;
		if ($name == '') $name = $vg_mailing_setup[default_name];		
		$send_subject = str_replace("%MAILTONAME%", $name, $mail_subject);
		$send_contents = str_replace("%MAILTONAME%", $name, $mail_contents);
		$mail_ok = $lh_common->mailer($mail_from_name, $mail_from_mail, $email, $send_subject, $send_contents, 1, '', "EUC-KR", '', '', "mail_skin.html", '', 'N', $name, 'N');
		if ($mail_ok) echo 'O : ';
		else echo 'X : ';
		flush();
		echo("$name $email <br>"); // ������
		$sended_emails[] = $email;
		if ($cnt % $vg_mailing_setup[send_pack] == 0) {
			// ��) 100�뾿 ������ �� �ʰ� ��.
			sleep($vg_mailing_setup[send_term]); 
			echo "------------------- $cnt -----------------<br>";
		}
	} else {
		echo($email);
	}
	if ($is_preview == 'T') break;	// �׽�Ʈ�� 1ȸ�� �߼�
}
$T_time = $GLOBALS[w_time];
$sh_subject = addslashes($mail_subject);
$sh_contents = addslashes($send_contents);
$sh_receivers = implode($vg_mailing_setup[divider], $sended_emails);
$query = "insert $vg_tax_db_tables[history] set sh_subject='$sh_subject', sh_contents='$sh_contents', sh_receivers='$sh_receivers', sign_date='$T_time'";
$result = $lh_common->querying($query);
echo "<p>{$cnt} �� �߼�<p><font color=red><b>[��]</b> <a href='javascript:history.back()'>[���ϸ� Ȩ����]</a>";
echo "</font>";
?>