<?
$auth_method_array = array(array('L', '1', $vg_tax_user_info[user_level], 'E'));
if (!$lh_common->auth_process($auth_method_array)) die("권한이 없습니다.");

if ($_GET[mode_1] == "modify") {	 // 계산서수정
	$saved_tax_info = $lh_common->get_data($vg_tax_db_tables[tax_list], "serial_num", $_GET[tax_serial_num]);
	$biz_issue_date = date("Y-m-d", $saved_tax_info[biz_issue_date]);
	$form_mode_1 = "modify";
	$buyer_info = $lh_common->get_data($vg_tax_db_tables[buyer_list], "serial_num", $saved_tax_info[biz_b_serial]);
} else {													// 계산서등록
	// 기업정보 추출
	if ($_GET[buyer_id] != '') {			// 기업고유 id 값이 넘어온 경우.
		$buyer_info = $lh_common->get_data($vg_tax_db_tables[buyer_list], "buyer_id", $_GET[buyer_id]);
	} else if ($_GET[bbn] != '') {		// 고객 사업자번호가 넘어온 경우
		$buyer_info = $lh_common->get_data($vg_tax_db_tables[buyer_list], "biz_number", $_GET[bbn]);
	} else if ($_GET[buyer_serial_num] != '') {
		$buyer_info = $lh_common->get_data($vg_tax_db_tables[buyer_list], "serial_num", $_GET[buyer_serial_num]);
	}
	$saved_tax_info = array();
	$saved_tax_info[biz_a_name] = $vg_tax_biz_info[name];
	$saved_tax_info[biz_a_ceo] = $vg_tax_biz_info[ceo];
	$saved_tax_info[biz_a_number] = $vg_tax_biz_info[number];
	$saved_tax_info[biz_a_address] = $vg_tax_biz_info[address];
	$saved_tax_info[biz_a_cond] = $vg_tax_biz_info[cond];
	$saved_tax_info[biz_a_type] = $vg_tax_biz_info[type];
	$saved_tax_info[biz_tax_inc] = $vg_tax_setup[tax_inc];
	$form_mode_1 = "add";

	$saved_tax_info[biz_b_name] = $buyer_info[biz_name];
	$saved_tax_info[biz_b_ceo] = $buyer_info[biz_ceo];
	$saved_tax_info[biz_b_number] = $buyer_info[biz_number];
	$saved_tax_info[biz_b_address] = $buyer_info[biz_address];
	$saved_tax_info[biz_b_cond] = $buyer_info[biz_cond];
	$saved_tax_info[biz_b_type] = $buyer_info[biz_type];
	$saved_tax_info[biz_b_email] = $buyer_info[biz_email];
	$saved_tax_info[biz_b_fax] = $buyer_info[biz_fax];
	$saved_tax_info[biz_tax_inc] = $buyer_info[biz_inc];
}

$script_use_buyer_id = '';
if ($vg_tax_setup[use_buyer_id] == 'Y') {
	$script_use_buyer_id = "
		if (form.buyer_id.value == '') {
			alert('공급받는자 아이디 값이 없습니다.\\n\\n기존 시스템의 회원 아이디나 일련번호를 URL 변수(buyer_id)로 넘겨주십시오.');
			return false;
		}
	";
}

if ($buyer_info[buyer_id] == '' && $_GET[buyer_id] != '') $buyer_info[buyer_id] = $_GET[buyer_id];

echo("
<script language='javascript1.2'>
<!--
function verify_submit_tax(form) {
	if (form.mode.value == 'tax') {
		if (form.biz_a_name.value == '') {
			alert('공급자 상호를 입력하세요.');
			form.biz_a_name.focus();
			return false;
		}
		if (form.biz_a_number_1.value == '' || form.biz_a_number_2.value == '' || form.biz_a_number_3.value == '') {
			alert('공급자 사업자번호를 입력하세요.');
			form.biz_a_number_1.focus();
			return false;
		}
		if (form.biz_a_cond.value == '') {
			alert('공급자 업태를 입력하세요.');
			form.biz_a_cond.focus();
			return false;
		}
		if (form.biz_a_type.value == '') {
			alert('공급자 종목을 입력하세요.');
			form.biz_a_type.focus();
			return false;
		}
		if (form.biz_a_ceo.value == '') {
			alert('공급자 대표자를 입력하세요.');
			form.biz_a_ceo.focus();
			return false;
		}
		if (form.biz_issue_date.value == '') {
			alert('발급일을 입력하세요.');
			form.biz_issue_date.focus();
			return false;
		}
		if (form.biz_a_address.value == '') {
			alert('공급자 주소를 입력하세요.');
			form.biz_a_address.focus();
			return false;
		}
		if (form.biz_goods.value == '') {
			alert('품목을 입력하세요.');
			form.biz_goods.focus();
			return false;
		}
		if (form.biz_amount.value == '') {
			alert('금액을 입력하세요.');
			form.biz_amount.focus();
			return false;
		}
		if (form.biz_receipt.value == '') {
			alert('영수 여부를 선택하세요.');
			form.biz_receipt.focus();
			return false;
		}
		if (form.biz_b_name.value == '') {
			alert('공급받는자 상호를 입력하세요.');
			form.biz_b_name.focus();
			return false;
		}
		if (form.biz_b_number_1.value == '' || form.biz_b_number_2.value == '' || form.biz_b_number_3.value == '') {
			alert('공급받는자 사업자번호를 입력하세요.');
			form.biz_b_number_1.focus();
			return false;
		}
		if (form.biz_b_cond.value == '') {
			alert('공급받는자 업태를 입력하세요.');
			form.biz_b_cond.focus();
			return false;
		}
		if (form.biz_b_type.value == '') {
			alert('공급받는자 종목을 입력하세요.');
			form.biz_b_type.focus();
			return false;
		}
		if (form.biz_b_ceo.value == '') {
			alert('공급받는자 대표자를 입력하세요.');
			form.biz_b_ceo.focus();
			return false;
		}
		if (form.biz_b_address.value == '') {
			alert('공급받는자 주소를 입력하세요.');
			form.biz_b_address.focus();
			return false;
		}
		if (form.biz_tax_inc.value == '') {
			alert('부가세 포함여부를 선택 하세요.');
			form.biz_tax_inc.focus();
			return false;
		}

	} else {
		$script_use_buyer_id
		if (form.biz_b_name.value == '') {
			alert('공급받는자 상호를 입력하세요.');
			form.biz_b_name.focus();
			return false;
		}
		if (form.biz_b_number_1.value == '' || form.biz_b_number_2.value == '' || form.biz_b_number_3.value == '') {
			alert('공급받는자 사업자번호를 입력하세요.');
			form.biz_b_number.focus();
			return false;
		}
		if (form.biz_b_cond.value == '') {
			alert('공급받는자 업태를 입력하세요.');
			form.biz_b_cond.focus();
			return false;
		}
		if (form.biz_b_type.value == '') {
			alert('공급받는자 종목을 입력하세요.');
			form.biz_b_type.focus();
			return false;
		}
		if (form.biz_b_ceo.value == '') {
			alert('공급받는자 대표자를 입력하세요.');
			form.biz_b_ceo.focus();
			return false;
		}
		if (form.biz_b_address.value == '') {
			alert('공급받는자 주소를 입력하세요.');
			form.biz_b_address.focus();
			return false;
		}
	}
}

function verify_submit_buyer_info(form, mode1) {
	form.mode.value = 'buyer';
	form.mode_1.value = mode1;
	if (verify_submit_tax(form) == false) return false;
	form.submit();
}

function verify_submit_sch_tax(form) {
	if (form.search_keyword.value == '') {
		alert('검색어를 입력하세요');
		form.search_keyword.focus();
		return false;
	}
}

//-->
</script>
<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#CABE8E'>
<form name=frm method=post action='tax_manager.php' onsubmit='return verify_submit_tax(this)'>
<input type=hidden name=mode value='tax'>
<input type=hidden name=mode_1 value=$form_mode_1>
<input type=hidden name=buyer_serial value=$buyer_info[serial_num]>
<input type=hidden name=buyer_id value=$buyer_info[buyer_id]>
<input type=hidden name=tax_serial_num value=$saved_tax_info[serial_num]>
<input type=hidden name=page value='$_GET[page]'>
	<tr>
		<td bgcolor='#ECE9D8' align='center'>
			<table width=100% cellpadding=3 cellspacing=1 border=0>
				<tr><td colspan=4 class='item_title'><font color='#FF0000'>+ 공급자 +</font></td></tr>
				<tr>
					<td class='item_title'><font color='#FF0000'>회사명</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_a_name], "biz_a_name", "text", "size='20' maxlength='60' class='designer_text'", '', '') . "
					</td>
					<td class='item_title'><font color='#FF0000'>사업자번호</td>
					<td class=item_input>
						" . $lh_common->make_input_box(substr($saved_tax_info[biz_a_number], 0, 3), "biz_a_number_1", "text", "size='3' maxlength='3' class='designer_text'", '', '') . "
						" . $lh_common->make_input_box(substr($saved_tax_info[biz_a_number], 3, 2), "biz_a_number_2", "text", "size='2' maxlength='2' class='designer_text'", '', '') . "
						" . $lh_common->make_input_box(substr($saved_tax_info[biz_a_number], 5), "biz_a_number_3", "text", "size='5' maxlength='5' class='designer_text'", '', '') . "
					</td>
				</tr>
				<tr>
					<td class='item_title'><font color='#FF0000'>업태</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_a_cond], "biz_a_cond", "text", "size='20' maxlength='60' class='designer_text'", '', '') . "
					</td>
					<td class='item_title'><font color='#FF0000'>종목</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_a_type], "biz_a_type", "text", "size='20' maxlength='60' class='designer_text'", '', '') . "
					</td>
				</tr>
				<tr>
					<td class='item_title'><font color='#FF0000'>대표자</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_a_ceo], "biz_a_ceo", "text", "size='20' maxlength='60' class='designer_text'", '', '') . "
					</td>
					<td class='item_title'>발급일</td>
					<td class=item_input>
						" . $lh_common->make_date_input_box("nw_begin_chk", "biz_issue_date", $saved_tax_info[biz_issue_date], 0, " 현재", "Y-m-d") . "
					</td>
				</tr>
				<tr>
					<td class='item_title'><font color='#FF0000'>주소</td>
					<td class=item_input colspan=3>
						" . $lh_common->make_input_box($saved_tax_info[biz_a_address], "biz_a_address", "text", "style='width:100%' size='63' maxlength='60' class='designer_text'", '', '') . "
					</td>
				</tr>
				<tr>
					<td class='item_title'>품목</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_goods], "biz_goods", "text", "size='20' maxlength='60' class='designer_text'", '', '') . "
					</td>
					<td class='item_title'>금액</td>
					<td class=item_input>
");
if ($buyer_info[serial_num] != '') {
	$btn_buyer_save = "<input type='button' value='정보수정' onclick=\"verify_submit_buyer_info(this.form, 'modify')\">";
	if ($vg_tax_setup[use_buyer_id] == 'N') $btn_buyer_save .= " <input type='button' value='새고객추가' onclick=\"document.location.href='$vg_tax_file[tax_input_form]'\">"; 
	$msg_buyer = " 등록 고객";
	$msg_tax_list = " * <font color=blue><b><u>$buyer_info[biz_name] $buyer_info[buyer_id]</u></b></font> 님께 발급된 세금계산서 목록";
} else {
	$btn_buyer_save = "<input type='button' value='고객정보등록' onclick=\"verify_submit_buyer_info(this.form, 'add')\">";
	$msg_buyer = " 미등록 고객";
	$msg_tax_list = " * 발급된 세금계산서 목록";
}
$btn_buyer_save .= " <input type='button' value='고객목록' onclick=\"document.location.href='{$vg_tax_file[buyer_list]}'\">";

$T_vg_tax_pay = $vg_tax_pay;
echo("
						" . $lh_common->make_input_box($saved_tax_info[biz_amount], "biz_amount", "text", "size='10' maxlength='60' class='designer_text'", '', '') . "
						" . $lh_common->get_list_boxs_array($T_vg_tax_pay, "biz_receipt", $saved_tax_info[biz_receipt], 'Y', "class='designer_select'") . "
					</td>
				</tr>
			</table>
		</td>
		<td bgcolor='#ECE9D8' align='center'>
			<table width=100% cellpadding=3 cellspacing=1 border=0>
				<tr>
					<td colspan=4 class='item_title'>
						<table cellpadding=2 cellspacing=0 border=0 width=100%>
							<tr>
								<td><font color='#0066FF'><b>+ 공급받는자 +</b></font>$msg_buyer</td>
								<td align=right>$btn_buyer_save</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class='item_title'><font color='#0066FF'>회사명</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_b_name], "biz_b_name", "text", "size='20' maxlength='60' class='designer_text'", '', '') . "
					</td>
					<td class='item_title'><font color='#0066FF'>사업자번호</td>
					<td class=item_input>
						" . $lh_common->make_input_box(substr($saved_tax_info[biz_b_number], 0, 3), "biz_b_number_1", "text", "size='3' maxlength='3' class='designer_text'", '', '') . "
						" . $lh_common->make_input_box(substr($saved_tax_info[biz_b_number], 3, 2), "biz_b_number_2", "text", "size='2' maxlength='2' class='designer_text'", '', '') . "
						" . $lh_common->make_input_box(substr($saved_tax_info[biz_b_number], 5), "biz_b_number_3", "text", "size='5' maxlength='5' class='designer_text'", '', '') . "
					</td>
				</tr>
				<tr>
					<td class='item_title'><font color='#0066FF'>업태</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_b_cond], "biz_b_cond", "text", "size='20' maxlength='60' class='designer_text'", '', '') . "
					</td>
					<td class='item_title'><font color='#0066FF'>종목</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_b_type], "biz_b_type", "text", "size='20' maxlength='60' class='designer_text'", '', '') . "
					</td>
				</tr>
				<tr>
					<td class='item_title'><font color='#0066FF'>대표자</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_b_ceo], "biz_b_ceo", "text", "size='20' maxlength='60' class='designer_text'", '', '') . "
					</td>
					<td class='item_title'>형태</td>
					<td class=item_input>
");
$T_vg_tax_inc = $vg_tax_inc;
if ($saved_tax_info[serial_num] != '') {
	$btn_tax_save = "<input type='submit' value='계산서수정'>";
} else {
	$btn_tax_save = "<input type='submit' value='계산서저장'>";
}
echo("
						" . $lh_common->get_list_boxs_array($T_vg_tax_inc, "biz_tax_inc", $saved_tax_info[biz_tax_inc], 'Y', "class='designer_select'") . "
					</td>
				</tr>
				<tr>
					<td class='item_title'><font color='#0066FF'>주소</td>
					<td class=item_input colspan=3>
						" . $lh_common->make_input_box($saved_tax_info[biz_b_address], "biz_b_address", "text", "style='width:100%' size='63' maxlength='60' class='designer_text'", '', '') . "
					</td>
				</tr>
				<tr>
					<td class='item_title'>수신메일</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_b_email], "biz_b_email", "text", "size='20' maxlength='255' class='designer_text'", '', '') . "
					</td>
					<td class='item_title'>팩스</td>
					<td class=item_input>
						" . $lh_common->make_input_box($saved_tax_info[biz_b_fax], "biz_b_fax", "text", "size='20' maxlength='255' class='designer_text'", '', '') . "
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td bgcolor=#ECE9D8 colspan=2 align=right>
			<table cellpadding=3 cellspacing=0 border=0>
				<tr>
					<td>						
						$btn_tax_save	
						<input type='reset' value='다시작성'> 
					</td>
				</tr>
			</table>
		</td>
	</tr>
</form>
</table>

");
$sub_query = $sub_query_1 = '';
if ($buyer_info[serial_num] != '') $sub_query = " biz_b_serial='$buyer_info[serial_num]'";

if ($_GET[search_keyword] != '') {
	if ($search_item == "sell_item_name") {	// 품목검색
		$sub_query_1 = "biz_goods like '%{$_GET[search_keyword]}%'";
		if ($sub_query != '') $is_and = " and ";
		else $is_and = '';
		$sub_query .= "{$is_and}$sub_query_1";
	} else if ($search_item == "serial_num") {
		$sub_query_1 = "serial_num='$_GET[search_keyword]'";
		if ($sub_query != '') $is_and = " and ";
		else $is_and = '';
		$sub_query .= "{$is_and}$sub_query_1";
	} else {																		// 날짜검색
		$sch_date = explode("~", $_GET[search_keyword]);							// 범위 구분
		$ymd = explode("-", $sch_date[0]);
		$sch_start_date = mktime(0, 0, 0, $ymd[1], $ymd[2], $ymd[0]);
		$ymd = explode("-", $sch_date[1]);
		$sch_end_date = mktime(0, 0, 0, $ymd[1], $ymd[2]+1, $ymd[0]);
		$sub_query_1 = "biz_issue_date>=$sch_start_date and biz_issue_date<$sch_end_date";
		if ($sub_query != '') $is_and = " and ";
		else $is_and = '';
		$sub_query .= "{$is_and}$sub_query_1";
	}
}
if ($sub_query != '') $sub_query = " where {$sub_query}";
else $sub_query = '';

$query = "select * from $vg_tax_db_tables[tax_list]{$sub_query}";
$query_order = " order by biz_issue_date desc, sign_date desc";
$query_ppb = str_replace("select *", "select count(serial_num)", $query . $query_order);
$voucher_ppb_link = $lh_common->get_page_block($query_ppb, $vg_tax_setup[tax_ppa], $vg_tax_setup[tax_ppb], $_GET[page], '', '', $vg_tax_dir_info[images]);
$voucher_list_info = $lh_vg_tax->get_tax_list($query . $query_order, $voucher_ppb_link[1][0], $vg_tax_setup[tax_ppa], $voucher_ppb_link[2]);

// 매출, 세액 합계 계산부
$query_head = "select sum(biz_amount) from $vg_tax_db_tables[tax_list]";
if ($sub_query != '') $sub_query_1 = " and biz_tax_inc='A'";		// 부가세 없음.
else $sub_query_1 = " where biz_tax_inc='A'";
$query = "{$query_head}{$sub_query}{$sub_query_1}";
$result = $lh_common->querying($query);
$sell_amount_A = mysql_result($result, 0, 0);

if ($sub_query != '') $sub_query_1 = " and biz_tax_inc='B'";		// 부가세 별도.
else $sub_query_1 = " where biz_tax_inc='B'";
$query = "{$query_head}{$sub_query}{$sub_query_1}";
$result = $lh_common->querying($query);
$sell_amount_B = mysql_result($result, 0, 0);
$sell_tax_B = $sell_amount_B / 10;

if ($sub_query != '') $sub_query_1 = " and biz_tax_inc='C'";		// 부가세 포함.
else $sub_query_1 = " where biz_tax_inc='C'";
$query = "{$query_head}{$sub_query}{$sub_query_1}";
$result = $lh_common->querying($query);
$T_sell_amount_C = mysql_result($result, 0, 0);
$sell_amount_C = $T_sell_amount_C / 1.1;										// 공급가
$sell_tax_C = $sell_amount_C / 10;														// 부가세

// 매출액 정리
$total_sell_amount = $sell_amount_A + $sell_amount_B + $sell_amount_C;						// 총 매출
$total_sell_tax = $sell_tax_A + $sell_tax_B + $sell_tax_C;																// 총 매출 부가세


// 검색항목선택상자 설정부 (분기별, 월별등의 검색 날짜 설정)
$set_sign_date_term = date("Y-m-d", time()-60*60*24*30) . "~" . date("Y-m-d", time());
$today_array = getdate(time());
if ($today_array[mon] > 1) {
	$prev_year = $today_array[year];
	$prev_mon = $today_array[mon] - 1;
} else {
	$prev_year = $today_array[year] - 1;
	$prev_mon = 12;
}
$start_date = array($prev_year, $prev_mon, 1);
$set_prev_month_term = "{$prev_year}-{$prev_mon}-01~" . date("Y-m-d", $lh_vg_tax->get_date_term($start_date, "month", 1));
$start_date = array($today_array[year], $today_array[mon], 1);
$set_next_month_term = "{$today_array[year]}-{$today_array[mon]}-01~" . date("Y-m-d", $lh_vg_tax->get_date_term($start_date, "month", 1));
$start_date = array($today_array[year], 1, 1);
$set_bungi_term_1 = "{$today_array[year]}-01-01~" . date("Y-m-d", $lh_vg_tax->get_date_term($start_date, "month", 3));
$start_date = array($today_array[year], 4, 1);
$set_bungi_term_2 = "{$today_array[year]}-04-01~" . date("Y-m-d", $lh_vg_tax->get_date_term($start_date, "month", 3));
$start_date = array($today_array[year], 7, 1);
$set_bungi_term_3 = "{$today_array[year]}-07-01~" . date("Y-m-d", $lh_vg_tax->get_date_term($start_date, "month", 3));
$start_date = array($today_array[year], 10, 1);
$set_bungi_term_4 = "{$today_array[year]}-10-01~" . date("Y-m-d", $lh_vg_tax->get_date_term($start_date, "month", 3));
$start_date = array($today_array[year], 01, 1);
$set_bungi_term_12 = "{$today_array[year]}-01-01~" . date("Y-m-d", $lh_vg_tax->get_date_term($start_date, "month", 6));
$start_date = array($today_array[year], 07, 1);
$set_bungi_term_22 = "{$today_array[year]}-07-01~" . date("Y-m-d", $lh_vg_tax->get_date_term($start_date, "month", 6));
$option_name = array("품목", "전월", "금월", "1분기", "2분기", "3분기", "4분기", "전반기", "후반기", "일련번호");
$option_value = array("sell_item_name", "prev_month", "next_month", "1_bungi", "2_bungi", "3_bungi", "4_bungi", "12_bungi", "22_bungi", "serial_num");

echo("
<br>
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table width=100% cellpadding=3 cellspacing=0 border=0>
				<tr>
					<td>$msg_tax_list / <a href='$vg_tax_file[tax_list]'>[전체목록검색]</a></td>
					<td align=right>						
						<table>
						<form name=frm_sch_tax method=get action='$vg_tax_file[tax_list]' onsubmit='return verify_submit_sch_tax(this)'>
						<input type=hidden name=vg_tax_file_name value='$_GET[vg_tax_file_name]'>
						<input type=hidden name=bbn value='$buyer_info[biz_number]'>
							<tr>
								<td>
									" . $lh_common->make_list_box("search_item", $option_name, $option_value, '', $_GET[search_item], "onchange=\"set_keyword(this.form, this)\"", '') . "
									" . $lh_common->make_input_box($_GET[search_keyword], "search_keyword", "text", "size='23' maxlength='60'", '', '') . "
									<input type='submit' value='검색'>
								</td>
							</tr>
						</form>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan=2>
						<table cellpadding=3 cellspacing=0 border=0 align=right>
							<tr>
								<td>
									<font color=blue><b><u>공급가 : " . number_format($total_sell_amount) . "원</b></u></font> / 
									<font color=blue><b><u>부가세 : " . number_format($total_sell_tax) . "원</b></u></font> / 
									<font color=blue><b><u>합계 : " . number_format($total_sell_amount + $total_sell_tax) . "원</font></b></u>
								</td>
							</tr>
						</table>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border='0' cellpadding='5' cellspacing='1' width=100% bgcolor='#CABE8E' style='table-layout:fixed'>
				<tr align=center>
					<td class=item_title width=40>번호</td>
					<td class=item_title align=left width=140>고객명</td>
					<td class=item_title align=left>품목</td>
					<td class=item_title width=60 align=right>공급가</td>
					<td class=item_title width=50 align=right>세액</td>
					<td class=item_title width=60 align=right>합계</td>
					<td class=item_title width=55>조회수</td>
					<td class=item_title width=80>발급일</td>
					<td class=item_title width=50>발송</td>
					<td class=item_title width=90>편집</td>					
				</tr>
				$voucher_list_info[0]
				<tr>
					<td colspan=10 class=item_title align=center>$voucher_ppb_link[0]</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<script language='javascript1.2'>
<!--
function set_keyword(form, obj) {
	switch (obj.selectedIndex) {
		case 1 :
			form.search_keyword.value = '$set_prev_month_term';
		break;
		case 2 :
			form.search_keyword.value = '$set_next_month_term';
		break;
		case 3 :
			form.search_keyword.value = '$set_bungi_term_1';
		break;
		case 4 :
			form.search_keyword.value = '$set_bungi_term_2';
		break;
		case 5 :
			form.search_keyword.value = '$set_bungi_term_3';
		break;
		case 6 :
			form.search_keyword.value = '$set_bungi_term_4';
		break;
		case 7 :
			form.search_keyword.value = '$set_bungi_term_12';
		break;
		case 8 :
			form.search_keyword.value = '$set_bungi_term_22';
		break;
		default :
			form.search_keyword.value = '';
		break;
	}
}
//-->
</script>
");

?>