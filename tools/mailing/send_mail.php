<?
if ($flag != $_SERVER[HTTP_HOST]) die("비정상적인 입력은 허용되지 않습니다.");
include "include/manager_header.inc.php";
include "{$vg_mailing_dir_info['include']}post_var_filter.inc.php";

$mail_from_name = stripslashes($from_name);
$mail_from_mail = stripslashes($from_mail);
$mail_subject = stripslashes($subject);

// 메일 내용 불러오기
$mail_file = $vg_mailing_dir_info[contents] . $contents_file;
if (!file_exists($mail_file)) $lh_common->die_msg("선택하신 파일을 찾을 수 없습니다. 다시 확인해 주세요. <a href='javascript:history.back()'>[뒤로가기]</a>");
$fp = fopen ($mail_file, "r");
if (!$fp) die("메일 내용 파일 오류!!");
$mail_contents = fread($fp, 10000);
fclose ($fp);

if ($is_preview == 'P') {
	echo("<b>제목 : $mail_subject</b><br><br>");
	echo($mail_contents);
	echo("<br><br><a href='javascript:history.back()'>[돌아가기]</a>");
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
echo("<p>총 $total_email_num 명에게 발송중입니다..<br>");
echo "<p><b>{$vg_mailing_setup[send_pack]} 건씩 보내고 {$vg_mailing_setup[send_term]} 초를 쉽니다.</b> <font color=#CC3300>[끝] 이라는 단어가 나오기 전에는 중간에 중지하지 마십시오!</font><br><br>";
$cnt = 0;
for ($i=0; $i<count($email_list_array); $i++) {
	$email = trim($email_list_array[$i]);
	$name = trim($name_list_array[$i]);
	// 테스트 인경우 로그인한 담당자 이메일로 테스트
	if ($is_preview == 'T') $email = $vg_mailing_setup[test_email];
	$cm = ereg("[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*", $email);
	if ($cm == true) {	// 올바른 메일 주소만		
		$cnt++;
		if ($name == '') $name = $vg_mailing_setup[default_name];		
		$send_subject = str_replace("%MAILTONAME%", $name, $mail_subject);
		$send_contents = str_replace("%MAILTONAME%", $name, $mail_contents);
		$mail_ok = $lh_common->mailer($mail_from_name, $mail_from_mail, $email, $send_subject, $send_contents, 1, '', "EUC-KR", '', '', "mail_skin.html", '', 'N', $name, 'N');
		if ($mail_ok) echo 'O : ';
		else echo 'X : ';
		flush();
		echo("$name $email <br>"); // 디버깅용
		$sended_emails[] = $email;
		if ($cnt % $vg_mailing_setup[send_pack] == 0) {
			// 예) 100통씩 보내고 몇 초간 쉼.
			sleep($vg_mailing_setup[send_term]); 
			echo "------------------- $cnt -----------------<br>";
		}
	} else {
		echo($email);
	}
	if ($is_preview == 'T') break;	// 테스트는 1회만 발송
}
$T_time = $GLOBALS[w_time];
$sh_subject = addslashes($mail_subject);
$sh_contents = addslashes($send_contents);
$sh_receivers = implode($vg_mailing_setup[divider], $sended_emails);
$query = "insert $vg_tax_db_tables[history] set sh_subject='$sh_subject', sh_contents='$sh_contents', sh_receivers='$sh_receivers', sign_date='$T_time'";
$result = $lh_common->querying($query);
echo "<p>{$cnt} 건 발송<p><font color=red><b>[끝]</b> <a href='javascript:history.back()'>[메일링 홈으로]</a>";
echo "</font>";
?>