<?
// ȸ�����̺� ����
$query = "update $DB_TABLES[member] set rec_date='$current_time' where serial_num='$T_user_info[serial_num]'";
$result = $GLOBALS[lib_common]->querying($query, "�ֱ� �α��νð� ���� ���� ������ �����߻�");
$query = "update $DB_TABLES[member] set visit_num=visit_num+1 where  serial_num='$T_user_info[serial_num]'";
$result = $GLOBALS[lib_common]->querying($query, "�湮ȸ�� ���� ������ �����߻�");

// �α��ηα� �ۼ�
$query = "select * from $DB_TABLES[member_visit] where serial_member='{$T_user_info[serial_num]}' order by visit_date desc limit 1";	// ���� �ֱٷα��� ��������
$result = $GLOBALS[lib_common]->querying($query);
$recent_login_info = mysql_fetch_array($result);

if ($recent_login_info[visit_term] > 0) $visit_term = $GLOBALS[w_time] - $recent_login_info[visit_date];		// �� �α��� �ð�
else $visit_term = $GLOBALS[VI][login_term];

if ($visit_term >= $GLOBALS[VI][login_term]) {
	$record_info = array();
	$record_info[serial_member] = $T_user_info[serial_num];
	$record_info[visit_total] = $recent_login_info[visit_total] + 1;			// �� ���� �����湮�� (�̹� �α��� ����)
	$record_info[visit_date] = $GLOBALS[w_time];
	$record_info[visit_term] = $visit_term;
	$record_info[visit_ip] = $_SERVER[REMOTE_ADDR];
	$GLOBALS[lib_common]->input_record($DB_TABLES[member_visit], $record_info);
}
?>