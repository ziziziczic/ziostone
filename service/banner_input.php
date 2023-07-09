<?
include "header_proc.inc.php";
if ($proc_mode == "add_user" || $proc_mode == "add" || $proc_mode == "modify") {
	$service_item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $serial_service_item);
	$owner_phone_mobile = eregi_replace("[^0-9]", '', $owner_phone_mobile);
	$price_chg = eregi_replace("[^0-9]", '', $price_chg);
	$save_dir = $DIRS[service_upload] . "banner/";
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
	case "add_user" :
		$input_data = array();
		$input_data[upload_files] = $upload_files;
		$input_data[name] = $service_item_info[name];
		$input_data[title] = $title;
		$input_data[contents] = $contents;
		$input_data[link_url] = $link_url;
		$input_data[state] = 'O';
		$input_data[state_alarm] = 'O';
		$input_data[priority] = 11;
		$input_data[date_sign] = $GLOBALS[w_time];
		$input_data[date_modify] = 0;
		$input_data[buy_qty] = $buy_qty;
		$input_data[serial_service_item] = $serial_service_item;
		$input_data[serial_member] = $serial_member;
		$input_data[owner_name] = $owner_name;
		$input_data[owner_phone_mobile] = $owner_phone_mobile;
		$input_data[owner_email] = $owner_email;
		$new_serial_num = $GLOBALS[lib_common]->input_record($DB_TABLES[banner], $input_data, 'Y');
		
		// 판매기록작성
		include "{$root}service/buy_input_add.inc.php";

		$change_vars = array("design_file"=>"3055.php", "serial_banner"=>$new_serial_num);
		$link = "{$root}insiter.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "add" :
		$input_data = array();
		$input_data[upload_files] = $upload_files;
		$input_data[name] = $service_item_info[name];
		$input_data[title] = $title;
		$input_data[contents] = $contents;
		$input_data[link_url] = $link_url;
		$input_data[link_target] = $link_target;
		$input_data[link_target_pp] = $link_target_pp;
		$input_data[banner_open_date] = $open_date;
		$input_data[banner_close_date] = $close_date;
		$input_data[state] = $state;
		$input_data[state_alarm] = $state_alarm;
		$input_data[priority] = $priority;
		$input_data[sign_date] = $GLOBALS[w_time];
		$input_data[modify_date] = 0;
		$input_data[price_chg_type] = $price_chg_type;
		$input_data[price_chg] = $price_chg;
		$input_data[price_chg_msg] = $price_chg_msg;
		$input_data[buy_qty] = $buy_qty;
		$input_data[serial_service_item] = $serial_service_item;
		$input_data[serial_member] = $serial_member;
		$input_data[owner_name] = $owner_name;
		$input_data[owner_phone_mobile] = $owner_phone_mobile;
		$input_data[owner_email] = $owner_email;
		$new_serial_num = $GLOBALS[lib_common]->input_record($DB_TABLES[banner], $input_data, 'Y');
		
		// 판매기록작성
		include "{$root}service/buy_input_add.inc.php";

		$change_vars = array();
		$link = "./banner_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "modify" :
		$input_data = array();
		$input_data[upload_files] = $upload_files;
		$input_data[name] = $service_item_info[name];
		$input_data[title] = $title;
		$input_data[contents] = $contents;
		$input_data[link_url] = $link_url;
		$input_data[link_target] = $link_target;
		$input_data[link_target_pp] = $link_target_pp;
		$input_data[banner_open_date] = $open_date;
		$input_data[banner_close_date] = $close_date;
		$input_data[state] = $state;
		$input_data[state_alarm] = $state_alarm;
		$input_data[priority] = $priority;
		$input_data[modify_date] = $GLOBALS[w_time];
		$input_data[price_chg_type] = $price_chg_type;
		$input_data[price_chg] = $price_chg;
		$input_data[price_chg_msg] = $price_chg_msg;
		$input_data[buy_qty] = $buy_qty;
		$input_data[serial_service_item] = $serial_service_item;
		$input_data[serial_member] = $serial_member;
		$input_data[owner_name] = $owner_name;
		$input_data[owner_phone_mobile] = $owner_phone_mobile;
		$input_data[owner_email] = $owner_email;
		$GLOBALS[lib_common]->modify_record($DB_TABLES[banner], "serial_num", $serial_num, $input_data);
		$change_vars = array();
		$link = "./banner_input_form.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "delete" :
		$query = "delete from $DB_TABLES[banner] where serial_num='$serial_num'";
		$result = $GLOBALS[lib_common]->querying($query, "정보 삭제 쿼리중 에러");
		$change_vars = array("serial_num"=>'', "page"=>'');
		$link = "./banner_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "chg_state" :
		$query = "update $DB_TABLES[banner] set state='$state' where serial_num='$serial_num'";
		$result = $GLOBALS[lib_common]->querying($query, "상태변경 쿼리중 에러");
		$change_vars = array();
		$link = "./banner_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
}
$GLOBALS[lib_common]->alert_url('', 'E', $link);
?>