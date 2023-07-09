<?
include "header_proc.inc.php";
include "{$DIRS[include_root]}form_input_filter.inc.php";
switch ($proc_mode) {
	case "modify" :
		$money_receive = eregi_replace("[^0-9]", '', $money_receive);
		$money_dc = eregi_replace("[^0-9]", '', $money_dc);
		$sell_info[money_receive] = $money_receive;
		$sell_info[money_dc] = $money_dc;
		$sell_info[pay_info] = $pay_info;
		$GLOBALS[lib_common]->modify_record($DB_TABLES[service_sell], "serial_num", $serial_num, $sell_info);
		$GLOBALS[lib_common]->alert_url('', 'E', '', '', "opener.location.reload();window.close()");
	break;
	case "delete" :
		$GLOBALS[lib_common]->db_record_delete($DB_TABLES[service_sell], "serial_num", $serial_num);
	break;
	case "apply" :
		$sell_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_sell], "serial_num", $serial_num);
		set_state_sell($sell_info);
	break;
	case "extend" :
		$saved_sell_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_sell], "serial_num", $serial_num);
		$T_sell_info[title] = $saved_sell_info[title] . " 연장";
		$T_sell_info[money_price] = $saved_sell_info[money_price];
		$T_sell_info[money_receive] = $saved_sell_info[money_receive];
		$T_sell_info[money_dc] = $saved_sell_info[money_dc];
		$T_sell_info[ea] = $saved_sell_info[ea];
		$T_sell_info[ea_unit] = $saved_sell_info[ea_unit];
		$T_sell_info[pay_method] = $saved_sell_info[pay_method];
		$T_sell_info[service_table] = $saved_sell_info[service_table];
		$T_sell_info[service_field] = $saved_sell_info[service_field];
		$T_sell_info[service_serial] = $saved_sell_info[service_serial];
		$T_sell_info[sell_state] = 'O';
		$T_sell_info[date_open] = 0;
		$T_sell_info[serial_item] = $saved_sell_info[serial_item];
		$T_sell_info[serial_buyer] = $saved_sell_info[serial_buyer];
		$T_sell_info[buyer_name] = $saved_sell_info[buyer_name];
		$T_sell_info[date_sign] = $GLOBALS[w_time];
		$T_sell_info[serial_num] = $GLOBALS[lib_common]->input_record($DB_TABLES[service_sell], $T_sell_info, 'Y');		// 판매번호할당
		set_state_sell($T_sell_info);
	break;
}
$change_vars = array();
$link = "./buy_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
$GLOBALS[lib_common]->alert_url('', 'E', $link);
?>