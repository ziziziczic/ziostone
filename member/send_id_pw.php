<?
$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "{$DIRS[include_root]}verify_input.inc.php";
include "{$DIRS[include_root]}form_input_filter.inc.php";

$query="select * from $DB_TABLES[member] where name='$mb_name' and email='{$email_1}@{$email_2}'";
$result = $GLOBALS[lib_common]->querying($query, "����� ���� ���� ���� ������ �����߻�");
$total = mysql_num_rows($result);

if ($total == 1) {
	$member_info = mysql_fetch_array($result);
	$send_id = $member_info[id];
	$send_pw = substr($GLOBALS[w_time], 0, 6);
	
	// ��й�ȣ �ʱ�ȭ
	$query = "update $DB_TABLES[member] set passwd=password('$send_pw') where serial_num='{$member_info[serial_num]}'";
	$GLOBALS[lib_common]->querying($query);

	switch ($recv_method) {
		case 'H' :
			$msg = "[{$site_info[site_name]}]\n���̵�:{$send_id}\n��й�ȣ:{$send_pw}";
			$lib_insiter->send_sms($site_info[site_id], $member_info[phone_mobile], $host_info[phone], $msg);
			$result_msg = "��û�Ͻ� ���̵�� �ӽú�й�ȣ�� \\n\\n�޴���({$member_info[phone_mobile]}) ���� ������Ƚ��ϴ�.\\n\\n�����մϴ�.";
		break;
		case 'E' :
			$msg = "
				���̵� : $send_id <br>
				�ӽú�й�ȣ : $send_pw <br><br>
				�ӽ� ��й�ȣ�� �α��� �Ͻ��� �� ��й�ȣ�� ������ �ֽñ� �ٶ��ϴ�.<br>
				�׻� �ּ��� ���ϴ� $site_info[site_name] �� �ǰڽ��ϴ�.<br>
				�����մϴ�.
			";
			$log_info = array("owner"=>"{$member_info[id]}", "link"=>"findidpw");
			$GLOBALS[lib_common]->mailer($site_info[site_name], $site_info[site_email], $member_info[email], "��û�Ͻ� ID�� ��й�ȣ �Դϴ�.", $msg, 1, '', "EUC-KR", '', '', $GLOBALS[VI][mail_form], $log_info, 'Y', $member_info[name]);	// Ȯ�θ��� �߼�
			$result_msg = "��û�Ͻ� ���̵�� �ӽú�й�ȣ��\\n\\n�̸���({$member_info[email]}) �� ������Ƚ��ϴ�.\\n\\n�����մϴ�..";
		break;
	}
} else {
	if($total == 0) {
		$result_msg = "��ġ�ϴ� ȸ�������� �����ϴ�.\\n\\n��˻� �Ŀ��� �Ȱ��� ��Ȳ�� �߻��� ���\\n\\n�����ڿ��� ������ �ּ���";
	} else if ($total > 1) {
		$result_msg = "��ġ�ϴ� ȸ�������� �θ� �̻��Դϴ�.\\n\\n�����ڿ��� ������ �ּ���";
	}
}
$GLOBALS[lib_common]->alert_url($result_msg, 'E', $link);
?>