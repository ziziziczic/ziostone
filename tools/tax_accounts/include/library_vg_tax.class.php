<?
class library_vg_tax {
/*
	전용 라이브러리
*/
	function library_vg_tax() {
		//$GLOBALS[lib_common] = $obj;
	}

	// 해당 년월에 속한 총 날짜 계산 함수
	function get_last_date_month($year, $month) {
		$day = 28;
		while (checkdate($month, $day, $year)) $day++;
		$day--;
		return $day;
	}

	function get_date_term($start_date, $mode, $term) {
		switch ($mode) {
			case "year" :
				$start_date[0] += $term;
				$start_date[2] -= 1;
			break;
			case "month" :
				$start_date[1] += ($term -1);
				$start_date[2] = $this->get_last_date_month($start_date[0], $start_date[1]);
			break;
			case "day" :
				$start_date[2] += $term;
			break;
		}
		return mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
	}

	// 부가세 함수
	function get_supply_tax($total_amount, $tax_method) {
		$return_value = array();
		switch ($tax_method) {	// 부가세 부분 결정
			case 'A' : // 부가세 없음
				$w_supply = $total_amount;
				$w_tax = 0;
			break;
			case 'B' :	// 부가세 별도
				$w_supply = $total_amount;
				$w_tax = $total_amount / 10;
			break;
			case 'C' :	 // 상품에포함
				$w_supply = $total_amount / 1.1;
				$w_tax = $total_amount - $w_supply;
			break;
		}
		$return_value[] = $w_supply;		// 공급가
		$return_value[] = $w_tax;			// 세액
		$return_value[] = round($w_supply + $w_tax);	// 합계
		return $return_value;
	}

	function get_buyer_list($query, $total, $ppa=0, $page=1, $colspan='8') {
		global $lh_common, $page, $lh_vg_tax, $vg_tax_file;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$result = $lh_common->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
		$i = 0;
		$print_value = '';
		while ($value = mysql_fetch_array($result)) {
			$virtual_num = $total - (($page-1)*$ppa) - $i;
			$sign_date = date("y-m-d", $value[sign_date]);
			$P_bbn = substr($value[biz_number], 0, 3) . '-' . substr($value[biz_number], 3, 2) . '-' . substr($value[biz_number], 5);	// 공급자 사업자 번호
			$btn_modify = " <input type='button' value='계산서' class='input_button' onclick=\"document.location.href='{$vg_tax_file[tax_list]}&buyer_serial_num={$value[serial_num]}'\">";
			$btn_delete = " <input type='submit' value='삭제' class='input_button'>";
			$admin_btn = "
											<table>
												<tr>
													<td>$btn_modify $btn_delete</td>
												</tr>
											</table>
			";
			$print_value .= "
										<form name=frm_{$value[serial_num]} action='{$vg_tax_dir_info[root]}tax_manager.php' method=post onsubmit='return verify_delete(this)'>
										<input type='hidden' name='mode' value='buyer'>
										<input type='hidden' name='mode_1' value='delete'>
										<input type='hidden' name='buyer_serial_num' value='$value[serial_num]'>
										<input type='hidden' name='bbn' value='$value[biz_b_number]'>
										<tr bgcolor=ffffff align=center>
											<td>$virtual_num</td>
											<td align=left>$value[biz_name]</td>
											<td>$P_bbn</td>
											<td align=left>$value[biz_address]</td>
											<td align=left>$value[biz_cond]</td>
											<td align=left>$value[biz_type]</td>
											<td>$sign_date</td>
											<td>{$btn_modify}{$btn_delete}</td>											
										</tr>
										</form>
			";
			$i++;
		}	// while end	
		if ($i == 0) {
			$print_value .= "
										<tr bgcolor=ffffff>
											<td colspan={$colspan} align=center height=50>검색된 정보가 없습니다.</td>
										</tr>
			";
		} else {
			$print_value .= "
				<script language='javascript1.2'>
				<!--
				function verify_delete(form) {
					if (!confirm('선택한 정보를 삭제하시겠습니까?')) return false;
				}
				//-->
				</script>
			";
		}
		mysql_free_result($result);
		return array($print_value, $total);
	}

	function get_tax_list($query, $total, $ppa=0, $page=1, $colspan='10') {
		global $lh_common, $lh_vg_tax, $vg_tax_file;
		if ($ppa > 0) {
			if ($page <= 0) $page = 1;
			$limit_start = $ppa * ($page-1);
			$limit_end = $ppa;
			$query_limit = " limit $limit_start, $limit_end";
			$query .= $query_limit;
		}
		$result = $lh_common->querying($query);
		if ($total == 0) $total = mysql_num_rows($result);
		$i = 0;
		$print_value = '';
		while ($value = mysql_fetch_array($result)) {
			$virtual_num = $total - (($page-1)*$ppa) - $i;
			$sign_date = date("y-m-d", $value[biz_issue_date]);
			
			$voucher_supply_tax = $lh_vg_tax->get_supply_tax($value[biz_amount], $value[biz_tax_inc]);
			$total_sell_price_supply = round($voucher_supply_tax[0]);	// 공급가
			$total_sell_tax = round($voucher_supply_tax[1]);						// 세액
			$voucher_total_price = $voucher_supply_tax[2];							// 합계

			$btn_modify = " <input type='button' value='수정' class='input_button' onclick=\"document.location.href='{$vg_tax_file[tax_input_form]}&mode_1=modify&tax_serial_num=$value[serial_num]&page=$page'\">";
			$btn_delete = " <input type='submit' value='삭제' class='input_button'>";
			$btn_send= " <input type='button' value='발송' onclick=\"verify_submit_send(this.form, '{$value[biz_b_email]}')\" class='input_button'>";
			$print_value .= "
										<form name=frm_{$value[serial_num]} action='{$vg_tax_dir_info[root]}tax_manager.php' method=post onsubmit='return verify_delete(this)'>
										<input type='hidden' name='mode' value='tax'>
										<input type='hidden' name='mode_1' value='delete'>
										<input type='hidden' name='tax_serial_num' value='$value[serial_num]'>
										<input type='hidden' name='bbn' value='$value[biz_b_number]'>
										<tr bgcolor=ffffff align=center>
											<td>$value[serial_num]</td>
											<td align=left>$value[biz_b_name]</td>
											<td align=left><a href='{$vg_tax_file[tax_view]}&tax_serial_num=$value[serial_num]'>$value[biz_goods]</a></td>
											<td align=right>" . number_format($total_sell_price_supply) . "</td>
											<td align=right>" . number_format($total_sell_tax) . "</td>
											<td align=right>" . number_format($voucher_total_price) . "</td>
											<td>$value[biz_tax_count]</td>
											<td>$sign_date</td>
											<td align=center>{$btn_send}</td>
											<td>{$btn_modify}{$btn_delete}</td>
										</tr>
										</form>
			";
			$i++;
		}	// while end	
		if ($i == 0) {
			$print_value .= "
										<tr bgcolor=ffffff>
											<td colspan={$colspan} align=center height=50>검색된 정보가 없습니다.</td>
										</tr>
			";
		} else {
			$print_value .= "
				<script language='javascript1.2'>
				<!--
				function verify_delete(form) {
					if (!confirm('선택한 정보를 삭제하시겠습니까?')) return false;
				}
				function verify_submit_send(form, receive_email) {
					if (!confirm('선택하신 계산서를 ' + receive_email + ' 로 발송하시겠습니까?')) return false;
					form.mode_1.value = 'send_email';
					window.open('', 'win_send_form', 'left=5000,top=5000,width=0,height=0');
					form.target = 'win_send_form';
					form.submit();
				}
				//-->
				</script>
			";
		}
		mysql_free_result($result);
		return array($print_value, $total);
	}
}
?>