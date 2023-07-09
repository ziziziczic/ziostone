<?
/*----------------------------------------------------------------------------------
 * 제목 : 관리자 모드에서 회원 정보 관리 하는 프로그램
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "header_proc.inc.php";
if ($mode == "add" || $mode == "modify") {
	$upload_file_name_array = array();
	$upload_file_size_array = array();
	for ($i=1; $i<=10; $i++) {																	// 개수만큼 반복
		$upload_file_name = $file_size = '';
		$user_files = "upload_file_" . $i;													// 임시파일
		$saved_user_files = "saved_upload_file_" . $i;					// 저장된파일
		$new_file_name = $GLOBALS[w_time] . '_' . $i;
		$upload_file_name = $GLOBALS[lib_common]->file_upload($user_files, $$saved_user_files, $GLOBALS[VI][allow_ext], 'T', $DIRS[member_img], $new_file_name, '', 'Y');
		$upload_file_name_array[$i] = $upload_file_name;
	}
	$upload_files = implode(';', $upload_file_name_array);
	$birth_day = "{$birth_day_year}-{$birth_day_month}-{$birth_day_day} 00:00:00";
	$last_ip = "관리자";
	if ($passwd != '') {
		$query = "select password('$passwd')";
		$result = $GLOBALS[lib_common]->querying($query, "인코딩패스워드 추출 쿼리중 에러");
		$passwd = mysql_result($result, 0, 0);
	}
}
switch ($mode) {
	case "add" :
		if ($_POST[id] == '') die("아이디가 없습니다.");
		$query = "select name from $DB_TABLES[member] where id='$_POST[id]'";
		$result = $GLOBALS[lib_common]->querying($query, "중복 아이디 추출 쿼리중 에러");
		if (mysql_num_rows($result) > 0) $GLOBALS[lib_common]->alert_url("중복된 아이디가 있습니다. 다른 아이디를 사용하십시오.");
		$input_data = array();
		$input_data[id] = $id;
		$input_data[name] = $name_kr;
		$input_data[passwd] = $passwd;
		$input_data[email] = $email;
		$input_data[nick_name] = $nick_name;
		$input_data[homepage] = $homepage;
		$input_data[messenger] = $messenger;
		$input_data[gender] = $gender;
		$input_data[birth_day] = $birth_day;
		$input_data[birth_day_type] = $birth_day_type;
		$input_data[introduce] = $introduce;
		$input_data[jumin_number] = $jumin_number;
		$input_data[post] = $post;
		$input_data[address] = $address;
		$input_data[phone] = $phone;
		$input_data[phone_mobile] = $phone_mobile;
		$input_data[phone_fax] = $phone_fax;
		$input_data[job_kind] = $job_kind;
		$input_data[user_level] = $input_user_level;
		$input_data[mileage] = $mileage;
		$input_data[rec_date] = 0;
		$input_data[reg_date] = $GLOBALS[w_time];
		$input_data[mailing] = $mailing;
		$input_data[recommender] = $recommender;
		$input_data[visit_num] = 0;
		$input_data[hobby] = $hobby;
		$input_data[upload_file] = $upload_files;
		$input_data[admin_memo] = $admin_memo;
		$input_data[group_1] = $group_1;
		$input_data[group_2] = $group_2;
		$input_data[category_1] = $category_1;
		$input_data[category_2] = $category_2;
		$input_data[category_3] = $category_3;
		$input_data[etc_1] = $etc_1;
		$input_data[etc_2] = $etc_2;
		$input_data[etc_3] = $etc_3;
		$input_data[etc_4] = $etc_4;
		$input_data[etc_5] = $etc_5;
		$input_data[etc_6] = $etc_6;
		$input_data[state] = $state;
		$input_data[biz_company] = $biz_company;
		$input_data[biz_number] = $biz_number;
		$input_data[biz_ceo] = $biz_ceo;
		$input_data[biz_cond] = $biz_cond;
		$input_data[biz_item] = $biz_item;
		$input_data[biz_address] = $biz_address;
		$GLOBALS[lib_common]->input_record($DB_TABLES[member], $input_data);

		// 레벨에 따른 추가 가입프로세스 구현 (해당 파일 사용자정의)
		$file_member_level_add = "{$DIRS[member_root]}user_define/member_level_add.inc.php";
		if (file_exists($file_member_level_add)) {
			$case_user_level = $input_user_level;
			include $file_member_level_add;
		}

		$change_vars = array("page"=>'');
		$link = "./member_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "modify" :
		$input_data = array();
		if ($id != $id_pre) $input_data[id] = $id;
		$input_data[name] = $name_kr;
		if ($passwd != '') $input_data[passwd] = $passwd;
		$input_data[email] = $email;
		$input_data[nick_name] = $nick_name;
		$input_data[homepage] = $homepage;
		$input_data[messenger] = $messenger;
		$input_data[gender] = $gender;
		$input_data[birth_day] = $birth_day;
		$input_data[birth_day_type] = $birth_day_type;
		$input_data[introduce] = $introduce;
		$input_data[jumin_number] = $jumin_number;
		$input_data[post] = $post;
		$input_data[address] = $address;
		$input_data[phone] = $phone;
		$input_data[phone_mobile] = $phone_mobile;
		$input_data[phone_fax] = $phone_fax;
		$input_data[job_kind] = $job_kind;
		$input_data[user_level] = $input_user_level;
		$input_data[mileage] = $mileage;
		$input_data[mailing] = $mailing;
		$input_data[recommender] = $recommender;
		$input_data[hobby] = $hobby;
		$input_data[upload_file] = $upload_files;
		$input_data[admin_memo] = $admin_memo;
		$input_data[group_1] = $group_1;
		$input_data[group_2] = $group_2;
		$input_data[category_1] = $category_1;
		$input_data[category_2] = $category_2;
		$input_data[category_3] = $category_3;
		$input_data[etc_1] = $etc_1;
		$input_data[etc_2] = $etc_2;
		$input_data[etc_3] = $etc_3;
		$input_data[etc_4] = $etc_4;
		$input_data[etc_5] = $etc_5;
		$input_data[etc_6] = $etc_6;
		$input_data[state] = $state;
		$input_data[biz_company] = $biz_company;
		$input_data[biz_number] = $biz_number;
		$input_data[biz_ceo] = $biz_ceo;
		$input_data[biz_cond] = $biz_cond;
		$input_data[biz_item] = $biz_item;
		$input_data[biz_address] = $biz_address;
		$GLOBALS[lib_common]->modify_record($DB_TABLES[member], "serial_num", $serial_num, $input_data);

		// 레벨에 따른 추가 수정프로세스 구현 (해당 파일 사용자정의)
		$file_member_level_modify = "{$DIRS[member_root]}user_define/member_level_modify.inc.php";
		if (file_exists($file_member_level_modify)) {
			$case_user_level = $input_user_level;
			include $file_member_level_modify;
		}

		$change_vars = array();
		$link = "./member_input_form.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "delete" :
		$query = "delete from $DB_TABLES[member] where serial_num='$serial_num'";
		$result = $GLOBALS[lib_common]->querying($query, "회원정보 삭제 쿼리중 에러");
		$change_vars = array("serial_num"=>'', "page"=>'');
		$link = "./member_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "cm_add" :
		$mi_milage = eregi_replace("[^0-9]", '', $mi_milage);
		$lib_insiter->insert_milage($mb_id, $mi_milage, $mi_memo, '', '', $mi_state);
		$change_vars = array();
		$link = "./member_cm_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "cm_modify" :
		$mi_milage = eregi_replace("[^0-9]", '', $mi_milage);
		$record_info = array();
		$record_info[mb_id] = $mb_id;
		$record_info[mi_milage] = $mi_milage;
		$record_info[mi_memo] = $mi_memo;
		$record_info[mi_state] = $mi_state;
		$record_info[mi_time] = $GLOBALS[w_time];
		$GLOBALS[lib_common]->modify_record($DB_TABLES[cyber_money], "mi_id", $mi_id, $record_info);
		$change_vars = array();
		$link = "./member_cm_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
	case "cm_delete" :
		$GLOBALS[lib_common]->db_record_delete($DB_TABLES[cyber_money], "mi_id", $mi_id);
		$change_vars = array();
		$link = "./member_cm_list.php?" . $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
	break;
}
$GLOBALS[lib_common]->alert_url('', 'E', $link);
?>