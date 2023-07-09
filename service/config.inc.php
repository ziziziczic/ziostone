<?
$DIRS[service] = "{$root}service/";
$DIRS[service_upload] = "{$root}service/upload_file/";

// db 테이블 매핑
$DB_TABLES[service_item] = "VG_service_item";							// 상품목록
$DB_TABLES[service_sell] = "VG_service_sell";								// 판매목록
$DB_TABLES[banner] = "VG_banner";													// 배너리스트
$DB_TABLES[banner_log] = "VG_banner_log";								// 배너로그

// 관리버튼재정의
$IS_btns[add] = "<img src='{$DIRS[designer_root]}images/wams_a.gif' border=0 style='margin-left:1px'>";
$IS_btns[login] = "<img src='{$DIRS[designer_root]}images/wams_l.gif' border=0 style='margin-left:1px'>";
$IS_btns[modify] = "<img src='{$DIRS[designer_root]}images/wams_m.gif' border=0 style='margin-left:1px' width=25 height=16>";
$IS_btns[delete] = "<img src='{$DIRS[designer_root]}images/wams_d.gif' border=0 style='margin-left:1px' width=25 height=16>";
$IS_btns[view] = "<img src='{$DIRS[designer_root]}images/wams_v.gif' border=0 style='margin-left:1px' width=25 height=16>";
$IS_btns[buy] = "<img src='{$DIRS[service]}images/wams_buy.gif' border=0 style='margin-left:1px' width=25 height=16>";
$IS_btns[extend] = "<img src='{$DIRS[service]}images/wams_extend.gif' border=0 style='margin-left:1px' width=25 height=16>";
$IS_icon[form_title] = "<img src='{$DIRS[service]}images/nec_dot.gif' width='13' height='13' border=0 align=absmiddle>";
$IS_icon[form_title_1] = "<img src='{$DIRS[service]}images/nec_dot.gif' width='13' height='13' border=0 align=absmiddle>";
$IS_icon[icon_help] = "<img src='{$DIRS[service]}images/icon_help.gif' width='11' height='11' border=0 align=absmiddle>";

// 상단메뉴명
$CN_menu[service] = "서비스/배너";
$CN_menu_link[service] = "{$DIRS[service]}buy_list.php";
$CN_menu_perm[service] = $GLOBALS[VI][admin_level_admin];

// 시스템변수
$IS_ppa[service] = "20";
$IS_ppb = "10";
$IS_sch_divider = $GLOBALS[DV][ct3];
$IS_thema = $IS_thema;

// 상태변수
$BA_state = array('O'=>"출력", 'X'=>"출력안함");
$BA_state_alarm = array('O'=>"알림", 'X'=>"미알림");
$BA_alarm_term_email = array(30, 3, 1);
$BA_alarm_term_sms = array(30, 3, 1);
$BA_price_chg_array = array("1"=>"추가", "-1"=>"할인");
$SI_is_yn = array('O'=>"예", 'X'=>"아니오");

// 상품설정
$SI_item_table = array("$DB_TABLES[banner]"=>"배너", "$DB_TABLES[member]"=>"회원", "$DB_TABLES[jiib_sell]"=>"지입매물");
$SI_item_field = array(
	"$DB_TABLES[banner]"=>array("banner"=>"배너"),
	"$DB_TABLES[member]"=>array("plus"=>"플러스"),
	"$DB_TABLES[jiib_sell]"=>array("recomm"=>"추천코너", "plus"=>"플러스코너", "color"=>"컬러", "bold"=>"볼드", "icon"=>"아이콘", "moveup"=>"상위이동")
);
$SI_apply_nums = array('1'=>"종료일", '2'=>"시작일 ~ 종료일");
$SI_unit_code = array('D'=>"일", 'W'=>"주", 'M'=>"개월", 'N'=>"회", 'Y'=>"년", 'L'=>"무한");

// 판매설정
$SI_pay_method = array('C'=>"신용카드", 'B'=>"무통장입금", 'H'=>"휴대폰", 'M'=>"적립금");			// 지불방식
$SI_pay_ok = array('X'=>"X", 'O'=>"O");														// 판매반영여부
$SI_bank_accounts = array("우리은행 148-397681-02-001 / 장문섭");

// 배너설정
$SI_banner_target = array("_self"=>"현재창", "_nw"=>"새창", "_blank"=>"새브라우저");

/////////////////////// 함수정의 ///////////////////////////

// 판매관리목록
function get_buy_list($query, $total, $ppa=0, $page=1, $print_type='', $colspan='8') {
	global $DIRS, $IS_btns, $SI_item_table, $SI_item_field, $SI_pay_ok, $SI_unit_code, $DB_TABLES;
	$list = '';
	$i = 0;
	if ($ppa > 0) {
		if ($page <= 0) $page = 1;
		$limit_start = $ppa * ($page-1);
		$limit_end = $ppa;
		$query_limit = " limit $limit_start, $limit_end";
		$query .= $query_limit;
	}
	$result = $GLOBALS[lib_common]->querying($query);
	if ($total == 0) $total = mysql_num_rows($result);
	$sum_price_ea = $sum_receive = $sum_dc = $sum_misu = 0;
	while ($value = mysql_fetch_array($result)) {
		$virtual_num = $total - (($page-1)*$ppa) - $i;
		if (($i%2) == 0) $tr_color = "#FFFFFF";
		else $tr_color = "#F8F5F0";
		switch ($value[service_table]) {		// 서비스 상세정보 링크
			case "$DB_TABLES[banner]" :
				$change_vars = array("serial_num"=>$value[service_serial]);
				$link_svc = "<a href='{$DIRS[service]}banner_view.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . "'>";
			break;
			default :
				$link_svc = $btn_buy = '';
			break;
		}
		$change_vars = array("serial_num"=>$value[serial_num]);
		$link_modify = "<a href=\"javascript:open_zip_window('{$DIRS[service]}buy_modify_form.php?serial_num=$value[serial_num]', '600', '540')\">";
		$link_delete = "<a href=\"javascript:verify('$value[serial_num]', 'delete', '삭제')\">";
		if ($value[sell_state] == 'X') $link_apply = "<a href=\"javascript:verify('$value[serial_num]', 'apply', '판매반영')\">";
		else $link_apply = '';
		$link_extend = "<a href=\"javascript:verify('$value[serial_num]', 'extend', '연장')\">";
		$btn_modify = "{$link_modify}{$IS_btns[modify]}</a>";
		$btn_delete = "{$link_delete}{$IS_btns[delete]}</a>";
		$btn_extend = "{$link_extend}{$IS_btns[extend]}</a>";
		
		// 금액
		$price_ea = $value[money_price]*$value[ea];
		$misu = ($value[money_price]*$value[ea]) - $value[money_receive] - $value[money_dc];

		$sum_price_ea += $price_ea;
		$sum_receive += $value[money_receive];
		$sum_dc += $value[money_dc];
		$sum_misu += $misu;			

		$list .= "
				<tr align=center bgcolor='$tr_color'>
					<td height=30>$virtual_num</td>
					<td align=left nowrap title='{$value[title]}'>{$link_svc}{$value[title]}</td>
					<td align=right>" . $GLOBALS[lib_common]->get_money_format($value[money_price], 'Y', '') . "</td>
					<td align=right>{$value[ea]} {$SI_unit_code[$value[ea_unit]]}</td>
					<td align=right>" . $GLOBALS[lib_common]->get_money_format($price_ea, 'Y', '') . "</td>
					<td align=right>" . $GLOBALS[lib_common]->get_money_format($value[money_receive], 'Y', '') . "</td>
					<!--<td align=right>" . $GLOBALS[lib_common]->get_money_format($value[money_dc], 'Y', '') . "</td>//-->
					<td align=right>" . $GLOBALS[lib_common]->get_money_format($misu, 'Y', '') . "</td>
					<td>{$link_apply}{$SI_pay_ok[$value[sell_state]]}</a></td>
					<td><a href='service_item_input_form.php?serial_num=$value[serial_item]'>{$value[serial_item]}</a></td>
					<td><a href='{$DIRS[designer_root]}member_input_form.php?menu=member&serial_num=$value[serial_buyer]'>{$value[buyer_name]}</a></td>
					<td>" . $GLOBALS[lib_common]->get_format("date", $value[date_sign]) . "</td>
					<td>{$btn_extend}{$btn_modify}{$btn_delete}</td>
				</tr>
		";
		$i++;
	}
	if ($i == 0) {
		$list = "
										<tr bgcolor=ffffff>
											<td colspan='$colspan'>검색된 목록 없음</td>
										</tr>
		";
	} else {
		$list .= "
				<tr>
					<td colspan=5 align=right class=list_form_title>" . $GLOBALS[lib_common]->get_money_format($sum_price_ea, 'Y', '') . "</td>
					<td align=right class=list_form_title>" . $GLOBALS[lib_common]->get_money_format($sum_receive, 'Y', '') . "</td>
					<!--<td align=right class=list_form_title>" . $GLOBALS[lib_common]->get_money_format($sum_dc, 'Y', '') . "</td>//-->
					<td align=right class=list_form_title>" . $GLOBALS[lib_common]->get_money_format($sum_misu, 'Y', '') . "</td>
					<td colspan=5 class=list_form_title></td>
				</tr>
		";
		$list .= "
			<form name=frm_manage method=post action='./buy_input.php'>
				<input type='hidden' name='proc_mode' value=''>
				<input type='hidden' name='serial_num' value=''>
				<input type='hidden' name='state' value=''>
				<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
			</form>
			<script language='javascript'>
				<!--
				function verify(serial_num, pm, pm_msg) {
					if (confirm('선택한 정보를 ' + pm_msg + ' 하시겠습니까?')) {
						form = document.frm_manage;
						form.serial_num.value = serial_num;
						form.proc_mode.value = pm;
						form.submit();
					}
				}
				//-->
			</script>
		";
	}
	mysql_free_result($result);
	return array($list);
}

// 판매 반영함수
function set_state_sell($sell_info) {
	global $DB_TABLES;
	$item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $sell_info[serial_item]);
	if ($item_info[package] != '') {
		$exp = explode($GLOBALS[DV][ct2], $item_info[package]);
		for ($T_i=0; $T_i<sizeof($exp); $T_i++) {
			if ($exp[$T_i] == '') continue;
			$item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $exp[$T_i]);
			get_date_service($item_info, $sell_info, "modify");
		}
	} else {
		get_date_service($item_info, $sell_info, "modify");
	}
}

// 특정 서비스의 시작, 종료일 구하거나, 수정하는 함수
function get_date_service($item_info, $service_info, $mode='') {
	global $DB_TABLES;
	$open_name = '';
	$value = $rec_info = array();	
	if ($item_info[apply_fields] == '2') $open_name = $item_info[code_field_name] . "_open_date";
	$close_name = $item_info[code_field_name] . "_close_date";
	if ($mode == "modify") {
		$saved_service_info = $GLOBALS[lib_common]->get_data($service_info[service_table], "serial_num", $service_info[service_serial]);
		if ($open_name != '') {								// 시작날짜 필드가 있는 경우만.
			if ($service_info[date_open] > 0) {	// 판매정보에 시작날짜가 지정된 경우만
				if ($service_info[date_open] >= $GLOBALS[w_time]) $rec_info[$open_name] = $service_info[date_open];				// 시작날짜가 현재 날짜보다 미래인 경우
				else $rec_info[$open_name] = $GLOBALS[w_time];																																// 시작날짜가 현재보다 과거인 경우 서비스 시작일을 현재시간으로 재 설정
			} else {
				if ($saved_service_info[$open_name] == 0) $rec_info[$open_name] = $GLOBALS[w_time];												// 예외처리 (판매정보, 서비스 정보 모두 시작날짜가 없는 경우)
			}
		}
		// 종료날짜 설정 : 판매정보에 시작날짜가 있는 경우는 해당 날짜부터 지정기간 동안(신규), 시작날짜가 없는경우는 기존 종료날짜 부터 지정기간동안(연장), (패키지 상품이나 배너 판매에 필요.)
		if ($rec_info[$open_name] > 0) $date_open = $rec_info[$open_name];																										// 마감후연장
		else if ($saved_service_info[$close_name] > $GLOBALS[w_time]) $date_open = $saved_service_info[$close_name];		// 마감전연장
		else $date_open = $GLOBALS[w_time];																																											// 신규
		$rec_info[$close_name] = get_date_close($date_open, $service_info[ea], $service_info[ea_unit]);
		$GLOBALS[lib_common]->modify_record($service_info[service_table], "serial_num", $service_info[service_serial], $rec_info);
		$rec_info = array();
		$rec_info[sell_state] = 'O';
		$rec_info[money_receive] = $service_info[money_price]*$service_info[ea];
		$GLOBALS[lib_common]->modify_record($DB_TABLES[service_sell], "serial_num", $service_info[serial_num], $rec_info);
	} else {
		$value[date_open] = $service_info[$open_name];
		$value[date_close] = $service_info[$close_name];
		return $value;
	}
}

// 단위에 따른 종료일시 구하는 함수
function get_date_close($date_open, $ea, $unit_code) {
	$A_date_open = getdate($date_open);
	switch ($unit_code) {
		case 'M' :
			$A_date_open[mon] = $A_date_open[mon]+$ea;		
		break;
		case 'D' :
			$A_date_open[mday] = $A_date_open[mday]+$ea;
		break;
		case 'Y' :
			$A_date_open[year] = $A_date_open[year]+$ea;
		break;
		default :
			return 0;
		break;
	}
	$value = mktime($A_date_open[hours], $A_date_open[minutes], $A_date_open[seconds], $A_date_open[mon], $A_date_open[mday], $A_date_open[year]);
	return $value;
}

// 배너로그
function get_banner_log_list($serial_banner, $year, $month) {
	global $DB_TABLES;
	$last_day = $GLOBALS[lib_common]->get_last_date_month($year, $month);
	$list_1 = $list_2 = '';	
	for ($i=1; $i<=$last_day; $i++) {
		$start_date = mktime(0, 0, 0, $month, $i, $year);
		$end_date = mktime(0, 0, 0, $month, $i+1, $year);
		$query = "select count(serial_banner),  count(distinct ip_addr), count(distinct serial_member) from $DB_TABLES[banner_log] where serial_banner='$serial_banner' and date_sign>=$start_date and date_sign<$end_date";
		$result = $GLOBALS[lib_common]->querying($query);
		$value_log = mysql_fetch_row($result);				
		if (strlen($month) == 1) $P_month = '0' . $month;
		else $P_month = $month;
		if (strlen($i) == 1) $P_date = '0' . $i;
		else $P_date = $i;
		if (($i%2) == 0) $tr_color = "#FFFFFF";
		else $tr_color = "#F8F5F0";
		if ($i<=15) {
			$list_1 .= "
				<tr align=center bgcolor='$tr_color'>
					<td height=30>{$year}-{$P_month}-{$P_date}</td>
					<td>$value_log[0]</td>
					<td>$value_log[1]</td>
					<td>$value_log[2]</td>
				</tr>
			";
		} else {
			$list_2 .= "
				<tr align=center bgcolor='$tr_color'>
					<td height=30>{$year}-{$P_month}-{$P_date}</td>
					<td>$value_log[0]</td>
					<td>$value_log[1]</td>
					<td>$value_log[2]</td>
				</tr>
			";
		}		
	}

	$table_1 = "
		<table border='0' cellpadding='5' cellspacing='1' width='100%' class='list_form_table' style='table-layout:fixed'>
			<tr align=center>
				<td class=list_form_title width=85 height=30>년 월 일</td>
				<td class=list_form_title>클릭수</td>
				<td class=list_form_title>방문자수</td>
				<td class=list_form_title>방문회원수</td>
			</tr>
			<tr><td align='center' bgcolor='#CABE8E' colspan='4' height='1'></td></tr>
			$list_1
		</table>
	";
	$table_2 = "
		<table border='0' cellpadding='5' cellspacing='1' width='100%' class='list_form_table' style='table-layout:fixed'>
			<tr align=center>
				<td class=list_form_title width=85 height=30>년 월 일</td>
				<td class=list_form_title>클릭수</td>
				<td class=list_form_title>방문자수</td>
				<td class=list_form_title>방문회원수</td>
			</tr>
			<tr><td align='center' bgcolor='#CABE8E' colspan='4' height='1'></td></tr>
			$list_2
		</table>
	";
	$return_value = "
		<table cellpadding=0 cellspacing=0 border=0>
			<tr valign=top>
				<td>$table_1</td>
				<td width=5></td>
				<td>$table_2</td>
			</tr>
		</table>
	";
	return $return_value;
}

// 배너출력목록
function print_banner_list($serial_service_item, $serial_banner='') {
	global $root, $DIRS, $DB_TABLES;
	$service_item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $serial_service_item);		// 서비스정보추출
	$exp_item_option = explode($GLOBALS[DV][ct2], stripslashes($service_item_info[item_option]));														// 배너정보추출 (서비스옵션)
	if ($exp_item_option[1] != '') $banner_limits = " limit $exp_item_option[1]";					// 총출력개수
	$line_per_banners = (int)trim($exp_item_option[2]);																	// 한줄개수
	$bonus_banners = (int)trim($exp_item_option[3]);																		// 보너스배너개수
	$banner_skin_name = $exp_item_option[4];																					// 배너스킨명
	if ($exp_item_option[5] != '') $table_width = ' ' . $exp_item_option[5];							// 배너테이블폭
	if ($exp_item_option[6] != '') $img_td_style = ' ' . $exp_item_option[6];							// 이미지칸속성
	$width = $exp_item_option[7];																												// 이미지(플래시) 가로폭
	$height = $exp_item_option[8];																												// 이미지(플래시) 세로폭
	$etc_pp = $exp_item_option[9];																											// 기타속성
	if ($exp_item_option[10] != '') $text_td_style = ' ' . $exp_item_option[10];					// 텍스트칸속성
	$len_title = $exp_item_option[11];																										// 타이틀 길이
	$len_contents = $exp_item_option[12];																							// 내용길이
	if ($exp_item_option[13] != '') $table_pp = ' ' . $exp_item_option[13];								// 목록테이블속성
	else $table_pp = "width=100% cellpadding=0 cellspacing=0 border=0";
	if ($serial_banner != '') $query = "select * from $DB_TABLES[banner] where serial_num='$serial_banner'";		// 배너상세보기화면용
	else $query = "select * from $DB_TABLES[banner] where serial_service_item='$serial_service_item' and banner_open_date<=$GLOBALS[w_time] and banner_close_date>=$GLOBALS[w_time] and state='O' order by priority desc, sign_date desc{$banner_limits}";
	$result = $GLOBALS[lib_common]->querying($query);
	$total_count = mysql_num_rows($result);
	$banner_list = $bonus_banner = '';
	$count = 0;
	while ($banner_info = mysql_fetch_array($result)) {
		$count++;
		// 서비스배너출력
		if ($bonus_banners > 0 && $count <= $bonus_banners) $bonus_banner .= $GLOBALS[lib_common]->make_link($banner_info[title], "{$root}move_url.php?serial_banner={$banner_info[serial_num]}&url={$banner_info[link_url]}", $banner_info[link_target], $banner_info[target_pp]) . "&nbsp;&nbsp;&nbsp;";
		if ($count % $line_per_banners == 1) $banner_list .= "<tr valign=top>";
		if ($banner_info[upload_files] != '') $exp = explode($GLOBALS[DV][ct2], $banner_info[upload_files]);
		if ($exp[0] != '') {
			$pp = array(array("width"=>$width, "height"=>$height, "border"=>'0', "align"=>"absmiddle", "etc"=>$etc_pp), 'B');
			$file_tag = $GLOBALS[lib_common]->view_files($exp[0], "{$DIRS[service_upload]}banner/", $pp) . "<br>";
		}
		$title = $GLOBALS[lib_common]->str_cutstring($banner_info[title], $len_title, '');
		$contents = $GLOBALS[lib_common]->str_cutstring($banner_info[contents], $len_contents, '');
		$tag .= "<b><font color='#0075AF'>$title</font></b><br>$contents";
		if ($banner_info[link_url] != '') {
			$file_tag = $GLOBALS[lib_common]->make_link($file_tag, "{$root}move_url.php?serial_banner={$banner_info[serial_num]}&url={$banner_info[link_url]}", $banner_info[link_target], $banner_info[target_pp]);
			$title = $GLOBALS[lib_common]->make_link($title, "{$root}move_url.php?serial_banner={$banner_info[serial_num]}&url={$banner_info[link_url]}", $banner_info[link_target], $banner_info[target_pp]);
			$contents = $GLOBALS[lib_common]->make_link($contents, "{$root}move_url.php?serial_banner={$banner_info[serial_num]}&url={$banner_info[link_url]}", $banner_info[link_target], $banner_info[target_pp]);
		}
		$print_banner_info = array(
			"table_width"=>$table_width,
			"image"=>$file_tag,
			"image_td_style"=>$img_td_style,
			"title"=>$title,
			"text_td_style"=>$text_td_style,
			"contents"=>$contents,
			"contents_td_style"=>''
		);
		$tag_banner = get_banner_skin($banner_skin_name, $print_banner_info);
		$banner_list .= "
								<td align='center'>
									$tag_banner
								</td>
		";
		if ($count % $line_per_banners == 0) $banner_list .= "</tr>";
	}
	$T_P_tag_banner = "
						<table {$table_pp}>
							$banner_list
						</table>
	";
	$P_tag_banner = array($T_P_tag_banner, $bonus_banner);
	return $P_tag_banner;
}

// 배너포장
function get_banner_skin($skin_name, $banner_print_info) {
	global $DIRS;
	switch ($skin_name) {
		case "img_title_gray" :
			if ($banner_print_info[contents] != '') {
				$contents = "
								<tr>
									<td bgcolor=F7F7F7 {$banner_print_info[text_td_style]} align=center>{$banner_print_info[contents]}</td>
								</tr>
				";
			}
			$value = "
				<table width='{$banner_print_info[table_width]}' cellpadding=0 cellspacing=0 bgcolor=ffffff border=0>
					<tr>
						<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/1_1.gif' width=3 height=3 border=0></td>
						<td width=3 background='{$DIRS[service]}banner_skin/img_title_gray/1_2.gif'></td>
						<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/1_3.gif' width=3 height=3 border=0></td>
					</tr>
					<tr>
						<td width=3 background='{$DIRS[service]}banner_skin/img_title_gray/2_1.gif'></td>
						<td>
							<table width=100% cellpadding=0 cellspacing=0 border=0>
								<tr>
									<td>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/i_1_1.gif' width=3 height=3 border=0></td>
												<td></td>
												<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/i_1_3.gif' width=3 height=3 border=0></td>
											</tr>
											<tr>
												<td width=3></td>
												<td {$banner_print_info[image_td_style]} align=center>{$banner_print_info[image]}</td>
												<td width=3></td>
											</tr>
											<tr>
												<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/i_3_1.gif' width=3 height=3 border=0></td>
												<td background='{$DIRS[service]}banner_skin/img_title_gray/i_3_2.gif'></td>
												<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/i_3_3.gif' width=3 height=3 border=0></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td bgcolor=F7F7F7 {$banner_print_info[text_td_style]} align=center><b>{$banner_print_info[title]}</b></td>
								</tr>
								$contents
							</table>
						</td>
						<td width=3 background='{$DIRS[service]}banner_skin/img_title_gray/2_3.gif'></td>
					</tr>
					<tr>
						<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/3_1.gif' width=3 height=3 border=0></td>
						<td background='{$DIRS[service]}banner_skin/img_title_gray/3_2.gif'></td>
						<td width=3><img src='{$DIRS[service]}banner_skin/img_title_gray/3_3.gif' width=3 height=3 border=0></td>
					</tr>
				</table>
			";
		break;
		case "img_title_gray_1" :
			if ($banner_print_info[contents] != '') {
				$contents = "
								<tr>
									<td bgcolor=F7F7F7 {$banner_print_info[text_td_style]} align=center>{$banner_print_info[contents]}</td>
								</tr>
				";
			}
			$value = "
				<table width='{$banner_print_info[table_width]}' cellpadding=0 cellspacing=0 bgcolor=ffffff border=0>
					<tr>
						<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/1_1.gif' width=3 height=3 border=0></td>
						<td width=3 background='{$DIRS[service]}banner_skin/img_title_gray/1_2.gif'></td>
						<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/1_3.gif' width=3 height=3 border=0></td>
					</tr>
					<tr>
						<td width=3 background='{$DIRS[service]}banner_skin/img_title_gray/2_1.gif'></td>
						<td>
							<table width=100% cellpadding=0 cellspacing=0 border=0>
								<tr>
									<td>
										<table width=100% cellpadding=0 cellspacing=0 border=0>
											<tr>
												<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/i_1_1.gif' width=3 height=3 border=0></td>
												<td></td>
												<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/i_1_3.gif' width=3 height=3 border=0></td>
											</tr>
											<tr>
												<td width=3></td>
												<td {$banner_print_info[image_td_style]} align=center>{$banner_print_info[image]}</td>
												<td width=3></td>
											</tr>
											<tr>
												<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/i_3_1.gif' width=3 height=3 border=0></td>
												<td background='{$DIRS[service]}banner_skin/img_title_gray/i_3_2.gif'></td>
												<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/i_3_3.gif' width=3 height=3 border=0></td>
											</tr>
										</table>
									</td>
								</tr>
								$contents
							</table>
						</td>
						<td width=3 background='{$DIRS[service]}banner_skin/img_title_gray/2_3.gif'></td>
					</tr>
					<tr>
						<td width=3 height=3><img src='{$DIRS[service]}banner_skin/img_title_gray/3_1.gif' width=3 height=3 border=0></td>
						<td background='{$DIRS[service]}banner_skin/img_title_gray/3_2.gif'></td>
						<td width=3><img src='{$DIRS[service]}banner_skin/img_title_gray/3_3.gif' width=3 height=3 border=0></td>
					</tr>
				</table>
			";
		break;
		case "img_title_contents_LR" :
			$contents = "<strong><font color='#A06742'>{$banner_print_info[title]}</font></strong><br>{$banner_print_info[contents]}";
			$value = "
				<table border=0 cellspacing=0 cellpadding=0 width='{$banner_print_info[table_width]}'>
					<tr height=4>
						<td width=4><img src={$DIRS[service]}banner_skin/{$skin_name}/1_1.gif height=4 width=4></td>
						<td background={$DIRS[service]}banner_skin/{$skin_name}/1_2.gif width=100%></td>
						<td width=4><img src={$DIRS[service]}banner_skin/{$skin_name}/1_3.gif height=4 width=4></td>
					</tr>
					<tr>
						<td background={$DIRS[service]}banner_skin/{$skin_name}/2_1.gif></td>
						<td>
							<table cellpadding=0 cellspacing=0 border=0 width=100%>
								<tr>
									<td {$banner_print_info[image_td_style]} align=center>{$banner_print_info[image]}</td>
									<td width=3></td>
									<td width='1' bgcolor='#C8BEB1'></td>
									<td width=3 bgcolor='#FBF9F8'></td>
									<td bgcolor='#FBF9F8' {$banner_print_info[text_td_style]}>{$contents}</td>
								</tr>
							</table>
						</td>
						<td background={$DIRS[service]}banner_skin/{$skin_name}/2_3.gif></td>
					</tr>
					<tr>
						<td><img src={$DIRS[service]}banner_skin/{$skin_name}/3_1.gif width=4 height=4></td>
						<td height=4 background={$DIRS[service]}banner_skin/{$skin_name}/3_2.gif></td>
						<td><img src={$DIRS[service]}banner_skin/{$skin_name}/3_3.gif width=4 height=4></td>
					</tr>
				</table>
			";
		break;
		default :
			if ($banner_print_info[contents] != '') {
				$contents = "
					<tr>
						<td{$banner_print_info[text_td_style]} align=center>{$banner_print_info[contents]}</td>
					</tr>
				";
			}
			if ($banner_print_info[title] != '') {
				$title = "
					<tr>
						<td {$banner_print_info[text_td_style]} align=center><b>{$banner_print_info[title]}</b></td>
					</tr>
				";
			}
			$value = "
				<table width='{$banner_print_info[table_width]}' cellpadding=0 cellspacing=0 bgcolor=ffffff border=0>
					<tr>
						<td>{$banner_print_info[image]}</td>
					</tr>
					$title
					$contents
					</tr>
				</table>
			";
		break;
	}
	return $value;
}

// 배너관리목록
function get_banner_list($query, $total, $ppa=0, $page=1, $print_type='', $colspan='8') {
	global $DIRS, $IS_btns, $BA_state, $BA_state_alarm, $DB_TABLES;
	$list = '';
	$i = 0;
	if ($ppa > 0) {
		if ($page <= 0) $page = 1;
		$limit_start = $ppa * ($page-1);
		$limit_end = $ppa;
		$query_limit = " limit $limit_start, $limit_end";
		$query .= $query_limit;
	}
	$result = $GLOBALS[lib_common]->querying($query);
	if ($total == 0) $total = mysql_num_rows($result);
	while ($value = mysql_fetch_array($result)) {
		$virtual_num = $total - (($page-1)*$ppa) - $i;
		if (($i%2) == 0) $tr_color = "#FFFFFF";
		else $tr_color = "#F8F5F0";
		// 관리버튼
		$change_vars = array("serial_num"=>$value[serial_num], "code_table_name"=>$DB_TABLES[banner], "code_field_name"=>"banner", "search_item"=>"service_serial", "search_keyword"=>$value[serial_num]);
		$link_view = "<a href='{$DIRS[banner]}banner_view.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . "'>";
		$link_modify = "<a href='{$DIRS[banner]}banner_input_form.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . "'>";
		$link_delete = "<a href=\"javascript:verify('$value[serial_num]')\">";
		$btn_modify = "{$link_modify}{$IS_btns[modify]}</a>";
		$btn_delete = "{$link_delete}{$IS_btns[delete]}</a>";
		if ($_GET[serial_num] == $value[serial_num]) $title_header = "<font color=red><b>=></b></font> ";
		else $title_header = '';

		if ($value[upload_files] != '') $exp = explode($GLOBALS[DV][ct2], $value[upload_files]);
		else $exp = '';
		if ($exp[0] != '') {
			$pp = array(array("width"=>40, "height"=>40, "border"=>'0', "align"=>"absmiddle", "etc"=>''), 'B');
			$banner_img = $GLOBALS[lib_common]->view_files($exp[0], "{$DIRS[service_upload]}banner/", $pp) . "<br>";
		} else {
			$banner_img = '';
		}
		$list .= "
				<tr align=center bgcolor='$tr_color'>
					<td height=50>$virtual_num</td>
					<td>{$link_view}$banner_img</td>
					<td align=left>{$title_header}{$link_view}{$value[title]}</td>	
					<td align=left>{$link_view}{$value[name]}</td>
					<td>" . $GLOBALS[lib_common]->get_format("date", $value[banner_open_date]) . "</td>
					<td>" . $GLOBALS[lib_common]->get_format("date", $value[banner_close_date]) . "</td>
					<td>" . $GLOBALS[lib_common]->get_format("date", $value[sign_date]) . "</td>
					<td>{$value[buy_qty]}</td>
					<td>{$BA_state[$value[state]]}</td>
					<td>{$BA_state_alarm[$value[state_alarm]]}</a></td>
					<td><a href='{$DIRS[designer_root]}member_input_form.php?serial_num={$value[serial_member]}'>{$value[serial_member]}</a></td>
					<td>{$btn_modify}{$btn_delete}</td>
				</tr>
		";
		$i++;
	}
	if ($i == 0) {
		$list = "
										<tr bgcolor=ffffff>
											<td colspan='$colspan'>검색된 목록 없음</td>
										</tr>
		";
	} else {
		$list .= "
			<form name=frm_manage method=post action='./banner_input.php'>
				<input type='hidden' name='proc_mode' value=''>
				<input type='hidden' name='serial_num' value=''>
				<input type='hidden' name='state' value=''>
				<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
			</form>
			<script language='javascript'>
				<!--
				function verify(serial_num) {
					if (confirm(\"선택한 정보를 삭제하시겠습니까? 삭제된 내용은 복원 할 수 없습니다.\")) {
						form = document.frm_manage;
						form.serial_num.value = serial_num;
						form.proc_mode.value = 'delete';
						form.submit();
					}
				}
				function chg_state(state, serial_num) {
					if (confirm(\"선택한 정보의 상태를 변경하시겠습니까?\")) {
						form = document.frm_manage;
						form.serial_num.value = serial_num;
						form.state.value = state;
						form.proc_mode.value = 'chg_state';
						form.submit();
					}
				}
				//-->
			</script>
		";
	}
	mysql_free_result($result);
	return array($list);
}

// 상품목록
function get_service_item_list($query, $total, $ppa=0, $page=1, $print_type='', $colspan='8') {
	global $DIRS, $IS_btns, $SI_item_table, $SI_item_field, $SI_is_yn, $SI_unit_code, $DB_TABLES;
	$list = '';
	$i = 0;
	if ($ppa > 0) {
		if ($page <= 0) $page = 1;
		$limit_start = $ppa * ($page-1);
		$limit_end = $ppa;
		$query_limit = " limit $limit_start, $limit_end";
		$query .= $query_limit;
	}
	$result = $GLOBALS[lib_common]->querying($query);
	if ($total == 0) $total = mysql_num_rows($result);
	while ($value = mysql_fetch_array($result)) {
		$virtual_num = $total - (($page-1)*$ppa) - $i;
		if (($i%2) == 0) $tr_color = "#FFFFFF";
		else $tr_color = "#F8F5F0";
		// 관리버튼
		switch ($value[code_table_name]) {
			case "$DB_TABLES[banner]" :
				$change_vars = array("serial_num"=>'', "serial_service_item"=>$value[serial_num]);
				$link_buy = "<a href='{$DIRS[service]}banner_input_form.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . "'>";
				$btn_buy = "{$link_buy}{$IS_btns[buy]}</a>";
			break;
			default :
				$link_buy = $btn_buy = '';
			break;
		}
		$change_vars = array("serial_num"=>$value[serial_num]);
		$link_modify = "<a href='{$DIRS[service]}service_item_input_form.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars) . "'>";
		$link_delete = "<a href=\"javascript:verify('$value[serial_num]')\">";
		$btn_modify = "{$link_modify}{$IS_btns[modify]}</a>";
		$btn_delete = "{$link_delete}{$IS_btns[delete]}</a>";
		$list .= "
				<tr align=center bgcolor='$tr_color'>
					<td height=30>$virtual_num</td>
					<td>{$link_modify}{$SI_item_table[$value[code_table_name]]}</td>
					<td>{$link_modify}{$SI_item_field[$value[code_table_name]][$value[code_field_name]]}</td>
					<td align=left>{$link_modify}{$value[name]}</td>
					<td align=right>" . $GLOBALS[lib_common]->get_format("money", $value[price]) . "</td>
					<td align=right>({$value[ea_min]}~{$value[ea_max]}){$SI_unit_code[$value[unit_code]]}</td>
					<td>{$SI_is_yn[$value[state]]}</a></td>
					<td align=right>{$btn_buy}{$btn_modify}{$btn_delete}</td>
				</tr>
		";
		$i++;
	}
	if ($i == 0) {
		$list = "
										<tr bgcolor=ffffff>
											<td colspan='$colspan'>검색된 목록 없음</td>
										</tr>
		";
	} else {
		$list .= "
			<form name=frm_manage method=post action='./service_item_input.php'>
				<input type='hidden' name='proc_mode' value=''>
				<input type='hidden' name='serial_num' value=''>
				<input type='hidden' name='state' value=''>
				<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
			</form>
			<script language='javascript'>
				<!--
				function verify(serial_num) {
					if (confirm(\"선택한 정보를 삭제하시겠습니까? 삭제된 내용은 복원 할 수 없습니다.\")) {
						form = document.frm_manage;
						form.serial_num.value = serial_num;
						form.proc_mode.value = 'delete';
						form.submit();
					}
				}
				function chg_state(state, serial_num) {
					if (confirm(\"선택한 정보의 상태를 변경하시겠습니까?\")) {
						form = document.frm_manage;
						form.serial_num.value = serial_num;
						form.state.value = state;
						form.proc_mode.value = 'chg_state';
						form.submit();
					}
				}
				//-->
			</script>
		";
	}
	mysql_free_result($result);
	return array($list);
}

/* 서비스 만기일 알림
$get_option = array(
	"query"=>"쿼리(기간쿼리만제외된)",
	"table_service"=>"서비스테이블명",
	"field_date_end"=>"서비스만료일필드명",
	"field_date_recent"=>"최근발송일필드명",
	"field_owner_serial"=>"소유자필드명",
	"field_item_serial"=>"상품필드명",
	"svc_type"=>"서비스분류, banner ...",
	"field_svc_serial"=>"서비스일련번호"
);
$send_option = array(
	"method"=>"email ..",
	"table_member"=>"회원테이블명",
	"field_member_serial"=>"회원테이블일련번호필드명",
	"field_member_price_method"=>"회원테이블가격분류필드명",
	"table_item"=>"상품테이블명",
	"field_item_serial"=>"상품테이블일련번호필드명",
	"msg_bank"=>"입금계좌",
	"msg_card"=>"신용카드",
	"field_buy_qty"=>"서비스테이블기본구매수량필드명"
	"send_name"=>"보내는이름",
	"send_email"=>"보내는이메일",
	"send_phone"=>"보내는전화번호",
	"field_recv_name"=>"받는이름 회원필드명;서비스필드명",
	"field_recv_email"=>"받는이메일 회원필드명;서비스필드명",
	"field_recv_phone"=>"받는전화번호 회원필드명;서비스필드명",
	"send_phone_time"=>"sms 자동발송가능시간 - 예) 9;20";
	"skin_file"=>"스킨파일명",
	"contents_header"=>"내용상단",
	"contents_header"=>"내용내부",
	"contents_footer"=>"내용하단"
);
*/
function alarm_service($term, $get_option, $send_option) {
	global $lib_insiter, $site_info, $SI_unit_code, $BA_price_chg_array;
	$field_type = "date_recent_alarm_" . $send_option[method];
	$term_nums = sizeof($term);
	if (!is_array($term) || $term_nums <= 0) return;	// 알림간격이 배열이 아니거나 없는경우 종료
	sort($term);																				// 알림간격을 작은 순으로 정렬한다.
	$max_term = max($term)*60*60*24;							// 알림일중 가장 큰 값을 기준으로 호스팅 목록을 추출한다.
	$query = $get_option[query] . " and {$get_option[field_date_end]}-{$GLOBALS[w_time]}<{$max_term}";	// 알림대상 레코드 추출쿼리
	$result = $GLOBALS[lib_common]->querying($query);
	while ($saved_svc_info = mysql_fetch_array($result)) {																																										// 추출된 수만큼
		$left_date = $saved_svc_info[$get_option[field_date_end]] - $GLOBALS[w_time];																											// 만기일까지 남은시간구함
		for ($i=0; $i<$term_nums; $i++) {																																																				// 알림일 수만큼 반복(예를들어 30일전, 10일전, 1일전 알림이면 3번)
			$alarm_date = $term[$i]*60*60*24;																																																		// 알림기준시간(만기일로부터 몇일전에 알릴지)
			$alarm_recent_date = $saved_svc_info[$get_option[field_date_end]] - $saved_svc_info[$get_option[field_date_recent]];					// 만기일 몇일전 발송되었는지 파악
			if (($alarm_date >= $left_date) && ($alarm_date < $alarm_recent_date)) {																														// 서비스 만기일이 알림일 안에 들어온경우 & 최근 알림일이 현재(루프내)알림일보다 큰경우
				$svc_end_date = date("Y년 m월 d일", $saved_svc_info[$get_option[field_date_end]]);
				$log_info = array("owner"=>"member,{$saved_svc_info[$get_option[field_owner_serial]]}", "link"=>"{$get_option[svc_type]},{$saved_svc_info[field_svc_serial]}", "etc_msg"=>$term[$i] . "일전");																			// 전송 기록에 저장될 소유자, 링크 정보
				if ($saved_svc_info[$get_option[field_owner_serial]] != '') $owner_info = $GLOBALS[lib_common]->get_data($send_option[table_member], $send_option[field_member_serial], $saved_svc_info[$get_option[field_owner_serial]]);			// 소유(비)자정보추출
				else $owner_info = '';
				if ($saved_svc_info[$get_option[field_item_serial]] != '') $item_info = $GLOBALS[lib_common]->get_data($send_option[table_item], $send_option[field_item_serial], $saved_svc_info[$get_option[field_item_serial]]);										// 상품정보추출
				else $item_info = '';
				$item_name = stripslashes($item_info[name]);
				if ($send_option[method] == "email") {																					// 메일설정&전송부
					$T_exp = explode(';', $send_option[field_recv_name]);												// 받는이름
					if ($T_exp[0] != '') $to_name = $owner_info[$T_exp[0]];
					else $to_name = $saved_svc_info[$T_exp[1]];
					$T_exp = explode(';', $send_option[field_recv_email]);												// 받는메일
					if ($T_exp[0] != '') $to_mail = $owner_info[$T_exp[0]];
					else $to_mail = $saved_svc_info[$T_exp[1]];					
					if ($to_mail == '') break;
					$svc_price = $lib_insiter->get_price_member($item_info, $owner_info);			// 가격정책
					$svc_qty = $saved_svc_info[buy_qty];
					if ($send_option[msg_card] != '') $msg_card = "<br><br>{$send_option[msg_card]}";
					else $msg_card = '';
					$replace_search = array("%TONAME%", "%SENDNAME%", "%ITEMNAME%", "%SERIALSVC%", "%SERIALOWNER%");
					$replace_replace = array($to_name, $send_option[send_name], $item_name, $saved_svc_info[$get_option[field_svc_serial]], $saved_svc_info[$get_option[field_owner_serial]]);
					$contents_header = str_replace($replace_search, $replace_replace, $send_option[contents_header]);
					if ($send_option[contents_body] != '') $contents_body = "<br><br>" . str_replace($replace_search, $replace_replace, $send_option[contents_body]);
					$contents_footer = str_replace($replace_search, $replace_replace, $send_option[contents_footer]);

					if ($saved_svc_info[price_chg] != 0) {
						if ($saved_svc_info[price_chg] > 0) $price_chg_tail = $BA_price_chg_array[$saved_svc_info[price_chg_type]];
						$svc_price_chg = "
							<tr bgcolor=ffffff>
								<td colspan=2><table cellpadding=5 cellspacing=0 border=0><tr><td>< 할인 및 추가사항 ><br><b>{$saved_svc_info[price_chg_msg]}</b> 적용(으)로 <b>" . $GLOBALS[lib_common]->get_format("money", $saved_svc_info[price_chg]) . "이 {$price_chg_tail}</b> 되었습니다.{$msg_card}{$contents_body}</td></tr></table></td>
							</tr>
						";
					} else {
						$svc_price_chg = '';
					}
					$svc_price_amount = ($svc_price*$saved_svc_info[$send_option[field_buy_qty]]) + ($saved_svc_info[price_chg]*$saved_svc_info[price_chg_type]);
					$svc_send_msg_item = "
						<table cellpadding=5 cellspacing=1 bgcolor=f3f3f3 border=0 width=100%>
							<tr bgcolor=ffffff align=center>
								<td><b>서비스상품명</b></td>
								<td><b>단가</b></td>
								<td><b>수량</b></td>
								<td><b>만료일</b></td>
							</tr>
							<tr bgcolor=ffffff align=center>
								<td>$item_name</td>
								<td><font color=blue>" . $GLOBALS[lib_common]->get_format("money", $svc_price) . "</font></td>
								<td><font color=blue>X {$saved_svc_info[$send_option[field_buy_qty]]}{$SI_unit_code[$item_info[unit_code]]}</font></td>
								<td>" . $GLOBALS[lib_common]->get_format("date", $saved_svc_info[$get_option[field_date_end]]) . "</td>
							</tr>
						</table>
					";
					$svc_send_msg_item = $lib_insiter->w_get_img_box("heavy_gray_sq_title_abs", $svc_send_msg_item, 5, array("title"=>"<b>서비스정보</b>"));
					$svc_send_msg_pay = "
						<table cellpadding=5 cellspacing=1 bgcolor=f3f3f3 border=0 width=100%>
							<tr bgcolor=ffffff align=center>
								<td><b>총 결제금액</b></td>
								<td><b>입금계좌</b></td>
							</tr>
							<tr bgcolor=ffffff align=center>
								<td><font color=red><b>" . $GLOBALS[lib_common]->get_format("money", $svc_price_amount) . "</b></font> ({$saved_svc_info[$send_option[field_buy_qty]]}{$SI_unit_code[$item_info[unit_code]]})</td>
								<td>{$send_option[msg_bank]}</td>
							</tr>
							{$svc_price_chg}
						</table>
					";
					$svc_send_msg_pay = $lib_insiter->w_get_img_box("heavy_gray_sq_title_abs", $svc_send_msg_pay, 5, array("title"=>"<b>결제정보</b>"));
					$mail_subject = "$item_name - 서비스 연장 안내문";
					$mail_contents = "
						<table cellpadding=3 cellspacing=0 border=0 width=100%>
							<tr>
								<td>$contents_header</td>
							</tr>
							<tr><td height=10></td></tr>
							<tr>
								<td>$svc_send_msg_item</td>
							</tr>
							<tr><td height=5></td></tr>
							<tr>
								<td>$svc_send_msg_pay</td>
							</tr>
							<tr><td height=10></td></tr>
							<tr>
								<td>$contents_footer</td>
							</tr>
						</table>
					";
					$send_ok = $GLOBALS[lib_common]->mailer($send_option[send_name], $send_option[send_email], $to_mail, $mail_subject, $mail_contents, 1, '', "EUC-KR", '', '', $send_option[skin_file], $log_info, 'N', $to_name);
				} else if ($send_option[method] == "sms") {	// SMS 설정&전송
					$T_exp = explode(';', $send_option[field_recv_phone]);													// 받는전화
					if ($owner_info[$T_exp[0]] != '') $to_phone = $owner_info[$T_exp[0]];
					else $to_phone = $saved_svc_info[$T_exp[1]];
					if ($to_phone == '') break;
					$c_time = getdate($GLOBALS[w_time]);
					$T_exp = explode(';', $send_option[send_phone_time]);
					if ($c_time[hours] < $T_exp[0] || $c_time[hours] >= $T_exp[1]) break;	 // 자동 발송가능한 시간이 아니면 건너뜀.
					$from_phone = $send_option[send_phone];
					$sms_comment = "[$item_name]서비스만기일{$svc_end_date} - 연장요망합니다.";
					$send_ok = $lib_insiter->send_sms($site_info[site_id], $from_phone, $to_phone, $sms_comment, $log_info);
				}
				// 메일 혹은 SMS 가 정상 전송 되었으면 전송일 기록
				if ($send_ok) $GLOBALS[lib_common]->db_set_field_value($get_option[table_service], $get_option[field_date_recent], $GLOBALS[w_time], $get_option[field_svc_serial], $saved_svc_info[serial_num]);					
				break;
			}
		}
	}
}

function banner_alarm($type="email") {
	global $site_info, $DB_TABLES, $DIRS, $lib_insiter, $BA_alarm_term_email, $BA_alarm_term_sms;
	$host_info = $lib_insiter->get_user_info($site_info[site_id]);
	switch ($type) {
		case "email" :
			$field_date_recent = "date_recent_alarm_email";
			$term = $BA_alarm_term_email;
		break;
		case "sms" :
			$field_date_recent = "date_recent_alarm_sms";
			$term = $BA_alarm_term_sms;
		break;
	}
	$get_option = array(
		"query"=>"select * from $DB_TABLES[banner] where state='O' and state_alarm='O' and banner_close_date>{$GLOBALS[w_time]}",
		"table_service"=>$DB_TABLES[banner],
		"field_date_end"=>"banner_close_date",
		"field_date_recent"=>$field_date_recent,
		"field_owner_serial"=>"serial_member",
		"field_item_serial"=>"serial_service_item",
		"svc_type"=>"banner",
		"field_svc_serial"=>"serial_num"
	);
	$send_option = array(
		"method"=>$type,
		"table_member"=>$DB_TABLES[member],
		"field_member_serial"=>"serial_num",
		"field_member_price_method"=>"user_level",
		"table_item"=>$DB_TABLES[service_item],
		"field_item_serial"=>"serial_num",
		"msg_bank"=>"국민은행 : 350402-04-003788 , 예금주 이주한",
		"msg_card"=>"신용카드결제 클릭",
		"field_buy_qty"=>"buy_qty",
		"send_name"=>$site_info[site_name],
		"send_email"=>$host_info[email],
		"send_phone"=>$host_info[phone_mobile],
		"field_recv_name"=>"name;",
		"field_recv_email"=>"email;",
		"field_recv_phone"=>"phone_mobile;",
		"send_phone_time"=>"0;24",
		"skin_file"=>"{$DIRS[service]}etc/mail_skin.html",
		"contents_header"=>"안녕하세요 %TONAME% 고객님, %SENDNAME% 고객센터 입니다.<br>본 메일은 고객님의 <b>%ITEMNAME%</b> 관련 <b>서비스연장</b> 안내메일 입니다.",
		"contents_body"=>"클릭하시면 서비스 결과를 조회 할 수 있습니다. <a href='http://logistics1.co.kr/insiter.php?design_file=home.php&serial_svc=%SERIALSVC%&serial_owner=%SERIALOWNER%'>[ 배너방문자분석 ]</a>",
		"contents_footer"=>"만기일 전에 연장하시여 서비스가 중단되지 않도록 협조하여 주시길 당부드립니다.<br>이미 연장하신 고객께서는 본 메일을 삭제하시면 됩니다.<br>보다 자세한 사항은 당사 홈페이지 고객센터로 문의 주시기 바랍니다.<br>감사합니다."
	);
	alarm_service($term, $get_option, $send_option);
	/*
		"field_recv_name"=>";owner_name",
		"field_recv_email"=>";owner_email",
		"field_recv_phone"=>";owner_phone_mobile",
	*/
}
?>