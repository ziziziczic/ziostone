<?
$sell_state = 'X';

// 결제연동 시작

// 결제연동 끝

for ($BIF_i=0; $BIF_i<sizeof($_POST[BIF_item_select]); $BIF_i++) {
	$name_money_price = "price_unit_" . $_POST[BIF_item_select][$BIF_i];
	$name_item_name = "item_name_" . $_POST[BIF_item_select][$BIF_i];
	$name_ea = "ea_" . $_POST[BIF_item_select][$BIF_i];
	$name_ea_unit = "ea_unit_" . $_POST[BIF_item_select][$BIF_i];
	$name_service_table = "service_table_" . $_POST[BIF_item_select][$BIF_i];
	$name_service_field = "service_field_" . $_POST[BIF_item_select][$BIF_i];

	$sell_info = array();
	$sell_info[title] = $$name_item_name;
	$money_price = eregi_replace("[^0-9]", '', $$name_money_price);
	$sell_info[money_price] = $money_price;
	$sell_info[ea] = $$name_ea;
	$sell_info[ea_unit] = $$name_ea_unit;
	$sell_info[service_table] = $$name_service_table;
	$sell_info[service_field] = $$name_service_field;
	$sell_info[pay_method] = $BIF_pay_method;
	$sell_info[service_serial] = $new_serial_num;
	$sell_info[sell_state] = $sell_state;
	$sell_info[date_open] = mktime($date_open_hours, $date_open_minutes, $date_open_seconds, $date_open_month, $date_open_day, $date_open_year);
	$sell_info[serial_item] = $_POST[BIF_item_select][$BIF_i];
	$sell_info[serial_buyer] = $serial_member;
	$sell_info[buyer_name] = $user_info[name];
	$sell_info[date_sign] = $GLOBALS[w_time];
	if ($BIF_pay_method == 'B') $sell_info[pay_info] = "입금정보 : $BIF_bank_account / 입금자 : $BIF_bank_sender";
	$sell_info[serial_num] = $GLOBALS[lib_common]->input_record($DB_TABLES[service_sell], $sell_info, 'Y');	// 판매번호할당
	if ($sell_state == 'O') set_state_sell($sell_info);																															// 판매 반영상태로 넘어오면 바로 반영
}
?>