<?
class library_vg_cart {
/*
	카트 전용 라이브러리
*/
	function library_vg_cart() {
		//$GLOBALS[lib_common] = $obj;
	}

	// 마일리지 내역을 테이블에 입력
	function insert_milage($mb_id, $milage, $memo, $od_id="", $ct_id="", $mi_state='R') {
		global $lh_common, $REMOTE_ADDR, $DB_TABLES;
		$now = date("Y-m-d H:i:s", time());
		$query = " insert $DB_TABLES[cyber_money] set mb_id = '$mb_id', mi_milage = '$milage', mi_memo = '$memo', od_id = '$od_id', ct_id = '$ct_id', mi_time = '$now', mi_ip = '$REMOTE_ADDR', mi_state='$mi_state'";
		$lh_common->querying($query);
	}

	function cart_delete_all() {
		global $vg_cart_var_name;
		for ($vg_cart_i=0; $vg_cart_i<$_SESSION[$vg_cart_var_name[total]]; $vg_cart_i++) {				// 장바구니 배열수만큼 루프 돌린다..
			session_unregister($vg_cart_var_name[board_name] . $vg_cart_i);
			session_unregister($vg_cart_var_name[serial_num] . $vg_cart_i);
			session_unregister($vg_cart_var_name[name] . $vg_cart_i);
			session_unregister($vg_cart_var_name[price] . $vg_cart_i);
			session_unregister($vg_cart_var_name[quantity] . $vg_cart_i);
			session_unregister($vg_cart_var_name[option1] . $vg_cart_i);
			session_unregister($vg_cart_var_name[option2] . $vg_cart_i);
			session_unregister($vg_cart_var_name[option3] . $vg_cart_i);
		}
		$_SESSION[$vg_cart_var_name[total]] = 0;
	}

	function get_order_list($query, $total, $ppa=0, $page=1, $colspan='8') {
		global $lh_common, $vg_db_tables, $vg_cart_order_state, $page, $vg_cart_file, $vg_cart_dir_info;
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
			$order_no = $value[order_num];
			$amount = $value[price];
			$sign_date = date("y-m-d", $value[order_sign_date]);
			$T_vg_cart_order_state = $vg_cart_order_state;
			$T_vg_cart_order_state[Z] = "삭제";
			$order_state = $lh_common->get_list_boxs_array($T_vg_cart_order_state, "order_state", $value[order_state], 'N', "onchange='this.form.submit()' class='designer_select' style='width:70px'");

			$btn_modify = " <input type='button' value='수정' class='input_button' onclick=\"document.location.href='{$vg_cart_file[order_detail]}?vg_cart_order_num=$order_no'\">";
			$btn_delete = " <input type='button' value='삭제' class='input_button' onclick=\"javascript:verify_delete($order_no)\">";
			$admin_btn = "
											<table>
												<tr>
													<td>$btn_modify $btn_delete</td>
												</tr>
											</table>
			";
			$print_value .= "
										<form name=frm_{$order_no} action='{$vg_cart_dir_info[root]}order_manager.php' method=post>
										<input type='hidden' name='mode' value='chg_state'>
										<input type='hidden' name='order_num' value='$order_no'>
										<input type='hidden' name='page' value='$page'>
										<tr bgcolor=ffffff align=center>
											<td><a href='{$vg_cart_file[order_detail]}&order_num=$order_no&page=$page'>$order_no</a></td>
											<td>$value[order_c_name]</td>
											<td>$value[order_c_phone]</td>
											<td align=left>$value[order_c_email]</td>
											<td align=right>" . number_format($value[order_cost_goods] + $value[order_cost_delivery]) . "</td>
											<td>$value[order_pay_method]</td>
											<td>$order_state</td>
											<td>$sign_date</td>
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
				function verify_delete(title_num) {
					if (confirm('선택한 정보를 삭제하시겠습니까?')) {
						url = '{$VG_OP_dir_info[root]}input.php?VG_OP_mode=delete&title_num=' + title_num;
						window.open(url, 'temp','top=7000,left=7000,width=0,height=0');
					}
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