<?
/*----------------------------------------------------------------------------------
 * 제목 : 회원가입, 수정, 삭제 프로그램
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
*/
include "../include/verify_input.inc.php";	// 비정상적인 입력 방지

$root = "../";
include "{$root}db.inc.php";
include "{$root}config.inc.php";
include "{$DIRS[include_root]}form_input_filter.inc.php";

if ($proc_mode == "add" || $proc_mode == "modify") {
	$upload_file_name_array = array();
	$upload_file_size_array = array();
	for ($i=1; $i<=10; $i++) {																	// 개수만큼 반복
		$upload_file_name = $file_size = '';
		$user_files = "upload_file_" . $i;													// 임시파일
		$saved_user_files = "saved_upload_file_" . $i;					// 저장된파일
		if ($user_files == '' && $saved_user_files == '') continue;
		$new_file_name = $GLOBALS[w_time] . '_' . $i;
		$upload_file_name = $GLOBALS[lib_common]->file_upload($user_files, $$saved_user_files, $GLOBALS[VI][allow_ext], 'T', $DIRS[member_img], $new_file_name, '', 'Y');
		$upload_file_name_array[$i] = $upload_file_name;
	}
	$upload_files = implode(';', $upload_file_name_array);
	$password = '';
	if ($passwd != '') {
		$query = "select password('$passwd')";
		$result = $GLOBALS[lib_common]->querying($query, "인코딩패스워드 추출 쿼리중 에러");
		$password = mysql_result($result, 0, 0);
	}
	if ($birth_1 != '') $birth_day = $birth_1;
	if ($birth_2 != '') $birth_day .= "{$GLOBALS[DV][ct6]}{$birth_2}";
	if ($birth_3 != '') $birth_day .= "{$GLOBALS[DV][ct6]}{$birth_3}";
	if ($jumin_number_1 != '') $jumin_number = $jumin_number_1;
	if ($jumin_number_2 != '') $jumin_number .= "{$GLOBALS[DV][ct6]}{$jumin_number_2}";
	if ($email_1 != '') $email = $email_1;
	if ($email_2 != '') $email .= "@{$email_2}";
	if ($post_1 != '') $post = $post_1;
	if ($post_2 != '') $post .= "{$GLOBALS[DV][ct6]}{$post_2}";
	if ($phone_1 != '') $phone = $phone_1;
	if ($phone_2 != '') $phone .= "{$GLOBALS[DV][ct6]}{$phone_2}";
	if ($phone_3 != '') $phone .= "{$GLOBALS[DV][ct6]}{$phone_3}";
	if ($phone_mobile_1 != '') $phone_mobile = $phone_mobile_1;
	if ($phone_mobile_2 != '') $phone_mobile .= "{$GLOBALS[DV][ct6]}{$phone_mobile_2}";
	if ($phone_mobile_3 != '') $phone_mobile .= "{$GLOBALS[DV][ct6]}{$phone_mobile_3}";
	if ($phone_fax_1 != '') $phone_fax = $phone_fax_1;
	if ($phone_fax_2 != '') $phone_fax .= "{$GLOBALS[DV][ct6]}{$phone_fax_2}";
	if ($phone_fax_3 != '') $phone_fax .= "{$GLOBALS[DV][ct6]}{$phone_fax_3}";
	if ($biz_number_1 != '') $biz_number = $biz_number_1;
	if ($biz_number_2 != '') $biz_number .= "{$GLOBALS[DV][ct6]}{$biz_number_2}";
	if ($biz_number_3 != '') $biz_number .= "{$GLOBALS[DV][ct6]}{$biz_number_3}";
}
switch ($proc_mode) {
	case "add" :
		if ($id == '') die("아이디가 없습니다.");
		$query = "select name from $DB_TABLES[member] where id='$id'";
		$result = $GLOBALS[lib_common]->querying($query, "중복 아이디 추출 쿼리중 에러");
		if (mysql_num_rows($result) > 0) $GLOBALS[lib_common]->alert_url("중복된 아이디가 있습니다. 다른 아이디를 사용하십시오.");
		if ($user_level == '') $user_level = '7';
		$input_data = array();
		$input_data[id] = $id;
		$input_data[name] = $name;
		$input_data[passwd] = $password;
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
		$input_data[sido] = $sido;
		$input_data[gugun] = $gugun;
		$input_data[phone] = $phone;
		$input_data[phone_mobile] = $phone_mobile;
		$input_data[phone_fax] = $phone_fax;
		$input_data[job_kind] = $job_kind;
		$input_data[user_level] = $user_level;
		$input_data[mileage] = $mileage;
		$input_data[rec_date] = 0;
		$input_data[reg_date] = $GLOBALS[w_time];
		$input_data[mailing] = $mailing;
		$input_data[recommender] = $recommender;
		$input_data[visit_num] = 0;
		$input_data[hobby] = $hobby;
		$input_data[upload_file] = $upload_files;
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
		$input_data[biz_company] = $biz_company;
		$input_data[biz_number] = $biz_number;
		$input_data[biz_ceo] = $biz_ceo;
		$input_data[biz_cond] = $biz_cond;
		$input_data[biz_item] = $biz_item;
		$input_data[biz_address] = $biz_address;
		if ($site_info[auth_method] == 'A') $input_data[state] = 'A';
		else $input_data[state] = 'W';
		$GLOBALS[lib_common]->input_record($DB_TABLES[member], $input_data);
		
		// 추천인이 있는 경우
		if (($recommender != "") && ($recommender != $id)) {
			$recommender_info = $lib_insiter->get_user_info($recommender);
			$lib_insiter->insert_milage($recommender, $GLOBALS[VI][default_cm], "축하합니다. $id 님추천으로 적립되었습니다.", "", "", "F");
		}

		// 레벨에 따른 추가 가입프로세스 구현 (해당 파일 사용자정의)
		$file_member_level_add = "user_define/member_level_add.inc.php";
		if (file_exists($file_member_level_add)) {
			$case_user_level = $user_level;
			include $file_member_level_add;
		}

		// 가입환영메일 발송
		$subject = "$name ($id) 님 회원가입을 축하드립니다.";
		$mail_contents = "
						감사합니다.
		";
		$GLOBALS[lib_common]->mailer($site_info[site_name], $site_info[site_email], $email, $subject, $mail_contents, 1, "", "EUC-KR", "", "", $GLOBALS[VI][mail_form]);

		// 자동로그인
		$current_time = time();
		$_SESSION[user_id] = $id;
		$_SESSION[user_level] = $user_level;
		$_SESSION[login_time] = $current_time;
		$query = "update $DB_TABLES[member] set rec_date='$current_time' where id='$id'";
		$result = $GLOBALS[lib_common]->querying($query, "최근 로그인시간 변경 쿼리 수행중 에러발생");
		$query = "update $DB_TABLES[member] set visit_num=visit_num+1 where id='$id'";
		$result = $GLOBALS[lib_common]->querying($query, "방문회수 변경 쿼리중 에러발생");

		$after_msg = "{$name} 님의 가입을 진심으로 환영합니다.\\n\\n자동으로 로그인 됩니다.";
	break;
	case "modify" :
		$input_data = array();
		if ($id != $id_pre) $input_data[id] = $id;
		if (isset($name)) $input_data[name] = $name;
		if ($password != '') $input_data[passwd] = $password;
		if (isset($email)) $input_data[email] = $email;
		if (isset($nick_name)) $input_data[nick_name] = $nick_name;
		if (isset($homepage)) $input_data[homepage] = $homepage;
		if (isset($messenger)) $input_data[messenger] = $messenger;
		if (isset($gender)) $input_data[gender] = $gender;
		if (isset($birth_day)) $input_data[birth_day] = $birth_day;
		if (isset($birth_day_type)) $input_data[birth_day_type] = $birth_day_type;
		if (isset($introduce)) $input_data[introduce] = $introduce;
		if (isset($jumin_number)) $input_data[jumin_number] = $jumin_number;
		if (isset($post)) $input_data[post] = $post;
		if (isset($address)) $input_data[address] = $address;
		if (isset($sido)) $input_data[sido] = $sido;
		if (isset($gugun)) $input_data[gugun] = $gugun;
		if (isset($phone)) $input_data[phone] = $phone;
		if (isset($phone_mobile)) $input_data[phone_mobile] = $phone_mobile;
		if (isset($phone_fax)) $input_data[phone_fax] = $phone_fax;
		if (isset($job_kind)) $input_data[job_kind] = $job_kind;
		if (isset($mileage)) $input_data[mileage] = $mileage;
		if (isset($mailing)) $input_data[mailing] = $mailing;
		if (isset($recommender)) $input_data[recommender] = $recommender;
		if (isset($hobby)) $input_data[hobby] = $hobby;
		if (isset($upload_files)) $input_data[upload_file] = $upload_files;
		if (isset($group_1)) $input_data[group_1] = $group_1;
		if (isset($group_2)) $input_data[group_2] = $group_2;
		if (isset($category_1)) $input_data[category_1] = $category_1;
		if (isset($category_2)) $input_data[category_2] = $category_2;
		if (isset($category_3)) $input_data[category_3] = $category_3;
		if (isset($etc_1)) $input_data[etc_1] = $etc_1;
		if (isset($etc_2)) $input_data[etc_2] = $etc_2;
		if (isset($etc_3)) $input_data[etc_3] = $etc_3;
		if (isset($etc_4)) $input_data[etc_4] = $etc_4;
		if (isset($etc_5)) $input_data[etc_5] = $etc_5;
		if (isset($etc_6)) $input_data[etc_6] = $etc_6;
		if (isset($biz_company)) $input_data[biz_company] = $biz_company;
		if (isset($biz_number)) $input_data[biz_number] = $biz_number;
		if (isset($biz_ceo)) $input_data[biz_ceo] = $biz_ceo;
		if (isset($biz_cond)) $input_data[biz_cond] = $biz_cond;
		if (isset($biz_item)) $input_data[biz_item] = $biz_item;
		if (isset($biz_address)) $input_data[biz_address] = $biz_address;
		$GLOBALS[lib_common]->modify_record($DB_TABLES[member], "serial_num", $user_info[serial_num], $input_data);
		// 레벨에 따른 추가 수정프로세스 구현 (해당 파일 사용자정의)
		$file_member_level_modify = "user_define/member_level_modify.inc.php";
		if (file_exists($file_member_level_modify)) {
			$case_user_level = $user_level;
			include $file_member_level_modify;
		}
		$after_msg = "회원정보가 수정되었습니다.\\n\\n감사합니다.";
	break;
	case "withdrawal" :
		if ($user_info[user_level] == 1) $GLOBALS[lib_common]->alert_url("관리자는 탈퇴 할 수 없습니다. 관리자 모드에서 삭제 가능합니다.");
		$input_data = array();
		$input_data[withdrawal_question] = $withdrawal_question;
		$input_data[withdrawal_question_msg] = $IS_withdrawal_question[$withdrawal_question];
		$input_data[memo] = $memo;
		$input_data[member_info] = "{$user_info[serial_num]}\n{$user_info[id]}\n{$user_info[name]}\n{$user_info[phone]}\n{$user_info[phone_mobile]}\n{$user_info[email]}";
		$input_data[withdrawal_date] = $GLOBALS[w_time];
		$GLOBALS[lib_common]->input_record($DB_TABLES[member_withdrawal], $input_data);
		$GLOBALS[lib_common]->db_record_delete($DB_TABLES[member], "serial_num", $user_info[serial_num]);
		$after_msg = "회원정보가 삭제되었습니다.\\n\\n감사합니다.";
		$after_db_msg = 'Y';
		session_destroy();
	break;
}

// 처리후 이동할 페이지 및 수행 할 스크립트 설정
$change_vars = array("design_file"=>'');
$move_page_link_tail = $GLOBALS[lib_common]->get_change_var_url($Q_STRING, $change_vars);
if ($after_db_msg == 'Y') {
	echo("
		<script language='javascript1.2'>
			<!--
				alert('$after_msg');
			//-->
		</script>
	");
}
if ($after_db_script == '') {
	if ($http_referer != '') {
		$move_page_link = $http_referer;
	} else {
		$move_page_link = "{$root}{$site_info[index_file]}?{$move_page_link_tail}";
	}
	$GLOBALS[lib_common]->alert_url('', 'E', $move_page_link);
} else {
	$after_db_script = stripslashes($after_db_script);
	$after_db_script = stripslashes($after_db_script);
	$after_db_script = str_replace("%LINK%", $move_page_link_tail, $after_db_script);
	echo("
		<script language='javascript1.2'>
			<!--
				$after_db_script
			//-->
		</script>
	");	
}
?>