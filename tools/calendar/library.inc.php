<?
///////////////////////////////////////////////////
// �λ����� Ķ���� ��� - library.inc.php
///////////////////////////////////////////////////

require_once "{$root}include/db.php";		// DB ���Ӻ�

$CD_root = "{$root}tools/calendar/";
$CD_table_name = "TCBOARD_1131";		// DB table ��

// $user_info = ... ����� ���� ���� $user_info[id], $user_info[user_level] �������� �α��� ���� Ȥ�� ��Ű���� �����´�.
// ����� ������ 1 : ������, 2~7 : �����, 8 : �湮�� ���·� ����, Ȥ�� �Լ� ����
$CD_admin_id = "";
$CD_admin_level = 1;										// �����ڷ���
$CD_admin_level_scope = "";						// ������ ���� ���� ����(U:�̻�, L:����, ������ �ش� ����)
$CD_read_level = 1;											// �бⷹ��
$CD_write_level = 1;										// ���ⷹ��
$CD_user_level_scope = "";							// ����� ���� ���� ����(U:�̻�, L:����, ������ �ش� ����)

$CD_start_year = 2000;
$CD_end_year = 2020;

$CD_first_day_flag = "0";								// ù��° ���� ����(0:�Ͽ���, 1:������);
$CD_current_date = time();
$CD_today = getdate($CD_current_date);

$CD_page = array("view"=>"{$root}insiter.php?design_file=1132.php", "write"=>"{$root}insiter.php?design_file=1133.php", "modify"=>"{$root}insiter.php?design_file=1134.php", "delete"=>"{$root}insiter.php?design_file=1135.php");

// �����ο�� ����
$CD_table_property = "width='100%' cellpadding='0' cellspacing='1' bgcolor='cccccc' border='0'";
$CD_tr_property = "align='right' valign='top' bgcolor='#FFFFFF' class='text11pt05'";
$CD_td_color = array("0"=>"white", "1"=>"white", "2"=>"white", "3"=>"white", "4"=>"white", "5"=>"white", "6"=>"white");
$CD_day_color = array("0"=>"red", "1"=>"black", "2"=>"black", "3"=>"black", "4"=>"black", "5"=>"black", "6"=>"blue");
$CD_td_blank_color = "white";
$CD_td_property = " width=80 height=80 class='text11pt' style='padding-top:4;padding-right:4'";
$CD_new_win = array("width"=>"580", "height"=>"500");

$html_header = "
	<meta http-equiv='content-type' content='text/html; charset=euc-kr'>
	<script src='{$CD_root}javascript.js'></script>
	<link rel='stylesheet' href='{$CD_root}style.css' type='text/css'>
";


// �ش� ����� ���� �� ��¥ ��� �Լ�
function CD_get_total_days($year, $month){
	$day = 1;
	while (checkdate($month, $day, $year)) $day++;
	$day--;
	return $day;
}

function show_calendar($CD_today, $CD_year, $CD_month, $CD_day, $CD_first_day_flag="0", $CD_print_subject="Y") {
	global $CD_root, $CD_table_property, $CD_tr_property, $CD_td_blank_color, $CD_td_property, $CD_day_color, $CD_admin_id, $CD_admin_level, $CD_read_level, $CD_write_level, $CD_admin_level_scope, $CD_user_level_scope, $user_info, $CD_page, $CD_new_win, $CD_table_name;
	$is_admin = $is_read = $is_write = "";

	// ������ ���� �ο��κ�
	if ($CD_admin_id != "" && $CD_admin_id == $user_info[id]) {	// ������ ���̵�� ������ ������ ���� �ο�
		$is_admin = 'Y';
	} else {
		switch ($CD_admin_level_scope) {
			case 'L' :		// '��ġ��' ����� ���� ������ ������ ���� ������ ��� ��� ������ ���� �ο�
				if ($CD_admin_level >= $user_info[user_level]) $is_admin = 'Y';
			break;
			case 'U' :		// ������ ���� �̻��� ��� ��� ������ ���� �ο�
				if ($CD_admin_level <= $user_info[user_level]) $is_admin = 'Y';
			break;
			default :		// ������ ������ ������ ��츸 ������ ���� �ο�
				if ($CD_admin_level == $user_info[user_level]) $is_admin = 'Y';
			break;
		}
	}
	

	// ����� ���� �ο��κ�
	switch ($CD_user_level_scope) {
		case 'L' :		// '��ġ��' ����� ���Ƿ����� ����� ���� ������ ��� ��� ���� �ο�
			if ($CD_read_level >= $user_info[user_level]) $is_read = 'Y';
			if ($CD_write_level >= $user_info[user_level]) $is_write = 'Y';
		break;
		case 'U' :		// ����� ���� �̻��� ��� ��� ������ ���� �ο�
			if ($CD_read_level <= $user_info[user_level]) $is_read = 'Y';
			if ($CD_write_level <= $user_info[user_level]) $is_write = 'Y';
		break;
		default :		// ����� ������ ������ ��츸 ������ ���� �ο�
			if ($CD_read_level == $user_info[user_level]) $is_read = 'Y';
			if ($CD_write_level == $user_info[user_level]) $is_write = 'Y';
		break;
	}

	$CD_month_total_day = CD_get_total_days($CD_year, $CD_month);		// ������ ���� �ϼ��� ����
	$CD_first_date = mktime(0, 0, 0, $CD_month, 1, $CD_year);
	$CD_last_date = mktime(23, 59, 59, $CD_month, $CD_month_total_day, $CD_year);
	$CD_first_day = $CD_first_day_counter = date(w, $CD_first_date);		// ������ ���� 1���� ������ ����, (��:0 ~ ��:6)

	// ��������, ������
	$CD_query = "select * from $CD_table_name where etc_1>=$CD_first_date and etc_1<=$CD_last_date";	// �ش� ���� �������� ����� ��� �Խù� ����
	$CD_result = @mysql_query($CD_query) or die(mysql_error());
	
	$CD_subject = array();	// ����� �Խù��� ������ �Ϻ��� ����
	while ($CD_value = mysql_fetch_array($CD_result)) {
		$CD_subject[date('j', $CD_value[etc_1])] .= "<br>" . "<a href='#;' onclick=\"window.open('{$CD_page[view]}&article_num=$CD_value[serial_num]&year2=$CD_year&month2=$CD_month','','scrollbars=no,width=$CD_new_win[width],height=$CD_new_win[height],resizable=yes,scrollbars=yes')\">$CD_value[subject]</a>";
	}

	if ($CD_first_day_flag == "0") {	// 
		$CD_head_blanks = $CD_first_day;
		$head_title_0 = "<td><img src='{$CD_root}images/day_0.gif' border=0></td>";
	} else {
		$CD_head_blanks = $CD_first_day - 1;
		$head_title_1 = "<td><img src='{$CD_root}images/day_0.gif' border=0></td>";
	}

	$CD_month_tag = "
		<table {$CD_table_property}>
			<tr>
				$head_title_0
				<td><img src='{$CD_root}images/day_1.gif' border=0></td>
				<td><img src='{$CD_root}images/day_2.gif' border=0></td>
				<td><img src='{$CD_root}images/day_3.gif' border=0></td>
				<td><img src='{$CD_root}images/day_4.gif' border=0></td>
				<td><img src='{$CD_root}images/day_5.gif' border=0></td>
				<td><img src='{$CD_root}images/day_6.gif' border=0></td>
				$head_title_1
			</tr>
			<tr {$CD_tr_property}>
	";	// ���̺����
	
	for ($CD_i=0; $CD_i<$CD_head_blanks; $CD_i++) $CD_month_tag .= "<td bgcolor='$CD_td_blank_color' {$CD_td_property}>&nbsp;</td>";	// ó�� ��ĭ ����

	for ($CD_i=1; $CD_i<=$CD_month_total_day; $CD_i++) {	// �� �ϼ� ��ŭ �ݺ�
		
		// ��¥ ��º�
		if ($CD_today[year] == $CD_year && $CD_today[mon] == $CD_month && $CD_today[mday] == $CD_i) $print_date = "[ " . $CD_i . " ]";	// ������ ���
		else $print_date = $CD_i;
		if ($is_admin == 'Y' || $is_write == 'Y') {								// ������ �Ǵ� ������� �ִ� ������� ��� ��ũ����.
			$print_date_a_tag_open = "<a href='#;' onclick=\"window.open('{$CD_page[write]}&year2=$CD_year&month2=$CD_month&day2=$CD_i','','scrollbars=no,width=$CD_new_win[width],height=$CD_new_win[height],resizable=yes,scrollbars=yes')\">";
			$print_date_a_tag_close = "</a>";
		} else {
			$print_date_a_tag_open = $print_date_a_tag_close = "";
		}

		$CD_day_tag .= "<td bgcolor='$CD_td_color[$CD_first_day_counter]' {$CD_td_property}>$print_date_a_tag_open<font color='$CD_day_color[$CD_first_day_counter]'>$print_date</font>{$print_date_a_tag_close}{$CD_subject[$CD_i]}</td>";
		$CD_week_days = ($CD_i + $CD_head_blanks) % 7;
		if ($CD_week_days != 0) {
			$CD_first_day_counter++;
			if ($CD_first_day_counter > 6) $CD_first_day_counter = 0;			// ������ ���� ��µǴ� ��� �Ͽ����� 7�� �����Ǵ°��� ����
		}	else {																														// �� ���� ������ ���̸� �ٹٲ�
			$CD_first_day_counter = $CD_first_day_flag;
			$CD_day_tag .= "</tr>";
			if ($CD_i != $CD_month_total_day) $CD_day_tag .= "<tr {$CD_tr_property}>";
		}
	}
	$CD_month_tag .= $CD_day_tag;
	
	for ($CD_i=0; $CD_i<(7-$CD_week_days); $CD_i++) $CD_month_tag .= "<td bgcolor='$CD_td_blank_color' {$CD_td_property}>&nbsp;</td>";	// ó�� ��ĭ ����
	$CD_month_tag .= "</tr></table>";

	return $CD_month_tag;
}

?>