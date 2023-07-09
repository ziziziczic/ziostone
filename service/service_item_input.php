<?
include "header_proc.inc.php";
//if ($proc_mode != "add") $service_item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $serial_num);
if ($proc_mode == "add" || $proc_mode == "modify") {
	$price = eregi_replace("[^0-9]", '', $price);
	$price_7 = eregi_replace("[^0-9]", '', $price_7);
	$price_6 = eregi_replace("[^0-9]", '', $price_6);
	$price_5 = eregi_replace("[^0-9]", '', $price_5);
	$price_4 = eregi_replace("[^0-9]", '', $price_4);
	$price_3 = eregi_replace("[^0-9]", '', $price_3);
	$price_2 = eregi_replace("[^0-9]", '', $price_2);
	$save_dir = $DIRS[service_upload] . "item/";
	$upload_file_name_array = array();
	$upload_file_size_array = array();
	for ($i=1; $i<=2; $i++) {																// 개수만큼 반복
		$upload_file_name = $file_size = '';
		$user_files = "upload_file_" . $i;											// 임시파일
		$saved_user_files = "saved_upload_file_" . $i;			// 저장된파일
		$new_file_name = $GLOBALS[w_time] . '_' . $i;
		$upload_file_name = $GLOBALS[lib_common]->file_upload($user_files, $$saved_user_files, array("jpg","jpeg","gif","png","swf"), 'T', $save_dir, $new_file_name);
		$upload_file_name_array[$i] = $upload_file_name;
	}
	$upload_files = implode($GLOBALS[DV][ct2], $upload_file_name_array);
}

switch ($proc_mode) {
	case "add" :
		$input_data = array();
		$input_data[code_table_name] = $code_table_name;
		$input_data[code_field_name] = $code_field_name;
		$input_data[apply_fields] = $apply_fields;
		$input_data[name] = $name;
		$input_data[price] = $price;
		$input_data[price_7] = $price_7;
		$input_data[price_6] = $price_6;
		$input_data[price_5] = $price_5;
		$input_data[price_4] = $price_4;
		$input_data[price_3] = $price_3;
		$input_data[price_2] = $price_2;
		$input_data[unit_code] = $unit_code;
		$input_data[ea_min] = $ea_min;
		$input_data[ea_max] = $ea_max;
		$input_data[ea_pack] = $ea_pack;
		$input_data[ea_total] = $ea_total;
		$input_data[package] = $package;
		$input_data[dc_method] = $dc_method;
		$input_data[upload_files] = $upload_files;
		$input_data[item_option] = $item_option;
		$input_data[state] = $state;
		$input_data[comment] = $comment;
		$input_data[date_sign] = $GLOBALS[w_time];
		$GLOBALS[lib_common]->input_record($DB_TABLES[service_item], $input_data);
		$change_vars = array("menu"=>"service");
		$link = "./service_item_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "modify" :
		$input_data = array();
		$input_data[code_table_name] = $code_table_name;
		$input_data[code_field_name] = $code_field_name;
		$input_data[apply_fields] = $apply_fields;
		$input_data[name] = $name;
		$input_data[price] = $price;
		$input_data[price_7] = $price_7;
		$input_data[price_6] = $price_6;
		$input_data[price_5] = $price_5;
		$input_data[price_4] = $price_4;
		$input_data[price_3] = $price_3;
		$input_data[price_2] = $price_2;
		$input_data[unit_code] = $unit_code;
		$input_data[ea_min] = $ea_min;
		$input_data[ea_max] = $ea_max;
		$input_data[ea_pack] = $ea_pack;
		$input_data[ea_total] = $ea_total;
		$input_data[package] = $package;
		$input_data[dc_method] = $dc_method;
		$input_data[upload_files] = $upload_files;
		$input_data[item_option] = $item_option;
		$input_data[state] = $state;
		$input_data[comment] = $comment;
		$GLOBALS[lib_common]->modify_record($DB_TABLES[service_item], "serial_num", $serial_num, $input_data);
		$change_vars = array();
		$link = "./service_item_input_form.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "delete" :
		$query = "delete from $DB_TABLES[service_item] where serial_num='$serial_num'";
		$result = $GLOBALS[lib_common]->querying($query, "정보 삭제 쿼리중 에러");
		$change_vars = array("serial_num"=>'', "page"=>'');
		$link = "./service_item_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "chg_state" :
		$query = "update $DB_TABLES[service_item] set state='$state' where serial_num='$serial_num'";
		$result = $GLOBALS[lib_common]->querying($query, "상태변경 쿼리중 에러");
		$change_vars = array();
		$link = "./service_item_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
}
$GLOBALS[lib_common]->alert_url('', 'E', $link);
?>