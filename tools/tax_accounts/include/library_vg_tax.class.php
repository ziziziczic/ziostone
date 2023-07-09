<?
class library_vg_tax {
/*
	���� ���̺귯��
*/
	function library_vg_tax() {
		//$GLOBALS[lib_common] = $obj;
	}

	// �ش� ����� ���� �� ��¥ ��� �Լ�
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

	// �ΰ��� �Լ�
	function get_supply_tax($total_amount, $tax_method) {
		$return_value = array();
		switch ($tax_method) {	// �ΰ��� �κ� ����
			case 'A' : // �ΰ��� ����
				$w_supply = $total_amount;
				$w_tax = 0;
			break;
			case 'B' :	// �ΰ��� ����
				$w_supply = $total_amount;
				$w_tax = $total_amount / 10;
			break;
			case 'C' :	 // ��ǰ������
				$w_supply = $total_amount / 1.1;
				$w_tax = $total_amount - $w_supply;
			break;
		}
		$return_value[] = $w_supply;		// ���ް�
		$return_value[] = $w_tax;			// ����
		$return_value[] = round($w_supply + $w_tax);	// �հ�
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
			$P_bbn = substr($value[biz_number], 0, 3) . '-' . substr($value[biz_number], 3, 2) . '-' . substr($value[biz_number], 5);	// ������ ����� ��ȣ
			$btn_modify = " <input type='button' value='��꼭' class='input_button' onclick=\"document.location.href='{$vg_tax_file[tax_list]}&buyer_serial_num={$value[serial_num]}'\">";
			$btn_delete = " <input type='submit' value='����' class='input_button'>";
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
											<td colspan={$colspan} align=center height=50>�˻��� ������ �����ϴ�.</td>
										</tr>
			";
		} else {
			$print_value .= "
				<script language='javascript1.2'>
				<!--
				function verify_delete(form) {
					if (!confirm('������ ������ �����Ͻðڽ��ϱ�?')) return false;
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
			$total_sell_price_supply = round($voucher_supply_tax[0]);	// ���ް�
			$total_sell_tax = round($voucher_supply_tax[1]);						// ����
			$voucher_total_price = $voucher_supply_tax[2];							// �հ�

			$btn_modify = " <input type='button' value='����' class='input_button' onclick=\"document.location.href='{$vg_tax_file[tax_input_form]}&mode_1=modify&tax_serial_num=$value[serial_num]&page=$page'\">";
			$btn_delete = " <input type='submit' value='����' class='input_button'>";
			$btn_send= " <input type='button' value='�߼�' onclick=\"verify_submit_send(this.form, '{$value[biz_b_email]}')\" class='input_button'>";
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
											<td colspan={$colspan} align=center height=50>�˻��� ������ �����ϴ�.</td>
										</tr>
			";
		} else {
			$print_value .= "
				<script language='javascript1.2'>
				<!--
				function verify_delete(form) {
					if (!confirm('������ ������ �����Ͻðڽ��ϱ�?')) return false;
				}
				function verify_submit_send(form, receive_email) {
					if (!confirm('�����Ͻ� ��꼭�� ' + receive_email + ' �� �߼��Ͻðڽ��ϱ�?')) return false;
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