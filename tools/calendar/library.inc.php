<?
///////////////////////////////////////////////////
// 인사이터 캘린더 모듈 - library.inc.php
///////////////////////////////////////////////////

require_once "{$root}include/db.php";		// DB 접속부

$CD_root = "{$root}tools/calendar/";
$CD_table_name = "TCBOARD_1131";		// DB table 명

// $user_info = ... 사용자 정보 설정 $user_info[id], $user_info[user_level] 형식으로 로그인 세션 혹은 쿠키에서 가져온다.
// 사용자 레벨은 1 : 관리자, 2~7 : 사용자, 8 : 방문객 형태로 맞춤, 혹은 함수 수정
$CD_admin_id = "";
$CD_admin_level = 1;										// 관리자레벨
$CD_admin_level_scope = "";						// 관리자 레벨 적용 범위(U:이상, L:이하, 없으면 해당 레벨)
$CD_read_level = 1;											// 읽기레벨
$CD_write_level = 1;										// 쓰기레벨
$CD_user_level_scope = "";							// 사용자 레벨 적용 범위(U:이상, L:이하, 없으면 해당 레벨)

$CD_start_year = 2000;
$CD_end_year = 2020;

$CD_first_day_flag = "0";								// 첫번째 요일 설정(0:일요일, 1:월요일);
$CD_current_date = time();
$CD_today = getdate($CD_current_date);

$CD_page = array("view"=>"{$root}insiter.php?design_file=1132.php", "write"=>"{$root}insiter.php?design_file=1133.php", "modify"=>"{$root}insiter.php?design_file=1134.php", "delete"=>"{$root}insiter.php?design_file=1135.php");

// 디자인요소 설정
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


// 해당 년월에 속한 총 날짜 계산 함수
function CD_get_total_days($year, $month){
	$day = 1;
	while (checkdate($month, $day, $year)) $day++;
	$day--;
	return $day;
}

function show_calendar($CD_today, $CD_year, $CD_month, $CD_day, $CD_first_day_flag="0", $CD_print_subject="Y") {
	global $CD_root, $CD_table_property, $CD_tr_property, $CD_td_blank_color, $CD_td_property, $CD_day_color, $CD_admin_id, $CD_admin_level, $CD_read_level, $CD_write_level, $CD_admin_level_scope, $CD_user_level_scope, $user_info, $CD_page, $CD_new_win, $CD_table_name;
	$is_admin = $is_read = $is_write = "";

	// 관리자 권한 부여부분
	if ($CD_admin_id != "" && $CD_admin_id == $user_info[id]) {	// 지정된 아이디는 무조건 관리자 권한 부여
		$is_admin = 'Y';
	} else {
		switch ($CD_admin_level_scope) {
			case 'L' :		// '수치상' 사용자 세션 레벨이 관리자 레벨 이하인 경우 모두 관리자 레벨 부여
				if ($CD_admin_level >= $user_info[user_level]) $is_admin = 'Y';
			break;
			case 'U' :		// 관리자 레벨 이상인 경우 모두 관리자 레벨 부여
				if ($CD_admin_level <= $user_info[user_level]) $is_admin = 'Y';
			break;
			default :		// 관리자 레벨과 동일할 경우만 관리자 레벨 부여
				if ($CD_admin_level == $user_info[user_level]) $is_admin = 'Y';
			break;
		}
	}
	

	// 사용자 권한 부여부분
	switch ($CD_user_level_scope) {
		case 'L' :		// '수치상' 사용자 세션레벨이 사용자 레벨 이하인 경우 모두 권한 부여
			if ($CD_read_level >= $user_info[user_level]) $is_read = 'Y';
			if ($CD_write_level >= $user_info[user_level]) $is_write = 'Y';
		break;
		case 'U' :		// 사용자 레벨 이상인 경우 모두 관리자 레벨 부여
			if ($CD_read_level <= $user_info[user_level]) $is_read = 'Y';
			if ($CD_write_level <= $user_info[user_level]) $is_write = 'Y';
		break;
		default :		// 사용자 레벨과 동일할 경우만 관리자 레벨 부여
			if ($CD_read_level == $user_info[user_level]) $is_read = 'Y';
			if ($CD_write_level == $user_info[user_level]) $is_write = 'Y';
		break;
	}

	$CD_month_total_day = CD_get_total_days($CD_year, $CD_month);		// 선택한 월의 일수를 구함
	$CD_first_date = mktime(0, 0, 0, $CD_month, 1, $CD_year);
	$CD_last_date = mktime(23, 59, 59, $CD_month, $CD_month_total_day, $CD_year);
	$CD_first_day = $CD_first_day_counter = date(w, $CD_first_date);		// 선택한 월의 1일의 요일을 구함, (일:0 ~ 토:6)

	// 제목추출, 설정부
	$CD_query = "select * from $CD_table_name where etc_1>=$CD_first_date and etc_1<=$CD_last_date";	// 해당 월의 일정으로 저장된 모든 게시물 추출
	$CD_result = @mysql_query($CD_query) or die(mysql_error());
	
	$CD_subject = array();	// 추출된 게시물의 제목을 일별로 저장
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
	";	// 테이블시작
	
	for ($CD_i=0; $CD_i<$CD_head_blanks; $CD_i++) $CD_month_tag .= "<td bgcolor='$CD_td_blank_color' {$CD_td_property}>&nbsp;</td>";	// 처음 빈칸 설정

	for ($CD_i=1; $CD_i<=$CD_month_total_day; $CD_i++) {	// 총 일수 만큼 반복
		
		// 날짜 출력부
		if ($CD_today[year] == $CD_year && $CD_today[mon] == $CD_month && $CD_today[mday] == $CD_i) $print_date = "[ " . $CD_i . " ]";	// 오늘인 경우
		else $print_date = $CD_i;
		if ($is_admin == 'Y' || $is_write == 'Y') {								// 관리자 또는 쓰기권한 있는 사용자인 경우 링크설정.
			$print_date_a_tag_open = "<a href='#;' onclick=\"window.open('{$CD_page[write]}&year2=$CD_year&month2=$CD_month&day2=$CD_i','','scrollbars=no,width=$CD_new_win[width],height=$CD_new_win[height],resizable=yes,scrollbars=yes')\">";
			$print_date_a_tag_close = "</a>";
		} else {
			$print_date_a_tag_open = $print_date_a_tag_close = "";
		}

		$CD_day_tag .= "<td bgcolor='$CD_td_color[$CD_first_day_counter]' {$CD_td_property}>$print_date_a_tag_open<font color='$CD_day_color[$CD_first_day_counter]'>$print_date</font>{$print_date_a_tag_close}{$CD_subject[$CD_i]}</td>";
		$CD_week_days = ($CD_i + $CD_head_blanks) % 7;
		if ($CD_week_days != 0) {
			$CD_first_day_counter++;
			if ($CD_first_day_counter > 6) $CD_first_day_counter = 0;			// 월요일 먼저 출력되는 경우 일요일이 7로 설정되는것을 보정
		}	else {																														// 각 주의 마지막 날이면 줄바꿈
			$CD_first_day_counter = $CD_first_day_flag;
			$CD_day_tag .= "</tr>";
			if ($CD_i != $CD_month_total_day) $CD_day_tag .= "<tr {$CD_tr_property}>";
		}
	}
	$CD_month_tag .= $CD_day_tag;
	
	for ($CD_i=0; $CD_i<(7-$CD_week_days); $CD_i++) $CD_month_tag .= "<td bgcolor='$CD_td_blank_color' {$CD_td_property}>&nbsp;</td>";	// 처음 빈칸 설정
	$CD_month_tag .= "</tr></table>";

	return $CD_month_tag;
}

?>