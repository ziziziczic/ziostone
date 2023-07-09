<?
/*----------------------------------------------------------------------------------
 * 제목 : 회원 정보 관리 화면
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */

include "header.inc.php";

if ($_GET[serial_num] != '' || $_GET[id] != '') {
	if ($_GET[serial_num] != '') $edit_user_info = $GLOBALS[lib_common]->get_data($DB_TABLES[member], "serial_num", $_GET[serial_num]);
	else $edit_user_info = $GLOBALS[lib_common]->get_data($DB_TABLES[member], "id", $_GET[id]);
	$mode = "modify";
} else {
	$btn_is_sch = $GLOBALS[lib_common]->make_input_box("검색", "btn_id", "button", "onclick='open_search_id(this.form)' class='designer_button'", "", "");
	$mode = "add";
	$edit_user_info[user_level] = $_GET[user_level];
}

// 사용자정의 폼설정 확인
$member_field_defines = $lib_insiter->member_field_define($site_info, $edit_user_info);

if (is_array($member_field_defines[job_kind])) {
	$T_title_job_kind = $member_field_defines[job_kind][2];
	$item_define = $member_field_defines[job_kind][1];
	$T_box_job_kind = $lib_insiter->make_multi_input_box($member_field_defines[job_kind][0], "job_kind", $item_define, $edit_user_info[job_kind], ' ', $member_field_defines[job_kind][3]);
} else {
	$T_title_job_kind = "직업";
	$T_box_job_kind = $GLOBALS[lib_common]->make_input_box($edit_user_info[job_kind], "job_kind", "text", "size='25' maxlength='100' class='designer_text'", "", "");
}

if (is_array($member_field_defines[name])) {
	$T_title_name = $member_field_defines[name][2];
	$item_define = $member_field_defines[name][1];
	$T_box_name = $lib_insiter->make_multi_input_box($member_field_defines[name][0], "name_kr", $item_define, $edit_user_info[name], ' ', $member_field_defines[name][3]);
} else {
	$T_title_name = "성명";
	$T_box_name = $GLOBALS[lib_common]->make_input_box($edit_user_info[name], "name_kr", "text", "size='15' maxlength='20' class='designer_text' tabindex='4'", '', '') . "&nbsp;";
}
$gender_array = $GLOBALS[lib_common]->parse_property($GLOBALS[VI][DD_gender], "\\n", $GLOBALS[DV][ct2], '', 'N', 'N');
$T_box_gender = $GLOBALS[lib_common]->get_list_boxs_array($gender_array, "gender", $edit_user_info[gender], 'N', "class='designer_select' tabindex='5'", $style);

// 생년월일
$today = getdate(time());
$exp = explode(" ", $edit_user_info[birth_day]);
$exp_1 = explode("-", $exp[0]);
$property = array("class=designer_select", "class=designer_select", "class=designer_select");
$print_info = array('Y'=>array("1920", $today[year], $exp_1[0], "년 "), 'M'=>array("1", "12", $exp_1[1], "월 "), 'D'=>array("1", "31", $exp_1[2], "일 "));
$T_box_birth_day = $GLOBALS[lib_common]->get_date_select_box("birth_day", $print_info, $property);
$option_name = array("선택", "양력", "음력");
$option_value = array("", "양력", "음력");
$T_box_birth_day .= $GLOBALS[lib_common]->make_list_box("birth_day_type", $option_name, $option_value, "", $edit_user_info[birth_day_type], "tabindex='24' class='designer_select'", $style);

if (is_array($member_field_defines[email])) {
	$T_title_email = $member_field_defines[email][2];
	$item_define = $member_field_defines[email][1];
	$T_box_email = $lib_insiter->make_multi_input_box($member_field_defines[email][0], "email", $item_define, $edit_user_info[email], ' ', $member_field_defines[hobby][3]);
} else {
	$T_title_email = "이메일주소";
	$T_box_email = $GLOBALS[lib_common]->make_input_box($edit_user_info[email], "email", "text", "size='40' maxlength='200' class='designer_text' tabindex='6'", "", "") . "";
}
$T_box_email .= $GLOBALS[lib_common]->make_input_box($edit_user_info[mailing], "mailing", "checkbox", " tabindex='7'", "", "Y") . "(메일링)";

if (is_array($member_field_defines[hobby])) {
	$T_title_hobby = $member_field_defines[hobby][2];
	$item_define = $member_field_defines[hobby][1];
	$T_box_hobby = $lib_insiter->make_multi_input_box($member_field_defines[hobby][0], "hobby", $item_define, $edit_user_info[hobby], ' ', $member_field_defines[hobby][3]);
} else {
	$T_title_hobby = "취미";
	$T_box_hobby = $GLOBALS[lib_common]->make_input_box($edit_user_info[hobby], "hobby", "text", "tabindex='25' size='25' maxlength='100' class='designer_text'", "", "");
}

if (is_array($member_field_defines[nick_name])) {
	$T_title_nick = $member_field_defines[nick_name][2];
	$item_define = $member_field_defines[nick_name][1];
	$T_box_nick = $lib_insiter->make_multi_input_box($member_field_defines[nick_name][0], "nick_name", $item_define, $edit_user_info[nick_name], ' ', $member_field_defines[nick_name][3]);
} else {
	$T_title_nick = "닉네임";
	$T_box_nick = $GLOBALS[lib_common]->make_input_box($edit_user_info[nick_name], "nick_name", "text", "tabindex='28' size='25' maxlength='100' class='designer_text'", "", "");
}

if (is_array($member_field_defines[messenger])) {
	$T_title_messenger = $member_field_defines[messenger][2];
	$item_define = $member_field_defines[messenger][1];
	$T_box_messenger = $lib_insiter->make_multi_input_box($member_field_defines[messenger][0], "messenger", $item_define, $edit_user_info[messenger], ' ', $member_field_defines[messenger][3]);
} else {
	$T_title_messenger = "메신저주소";
	$T_box_messenger = $GLOBALS[lib_common]->make_input_box($edit_user_info[messenger], "messenger", "text", "tabindex='27' size='25' maxlength='100' class='designer_text'", "", "");
}

if (is_array($member_field_defines[recommender])) {
	$T_title_recommender = $member_field_defines[recommender][2];
	$item_define = $member_field_defines[recommender][1];
	$T_box_recommender = $lib_insiter->make_multi_input_box($member_field_defines[recommender][0], "recommender", $item_define, $edit_user_info[recommender], ' ', $member_field_defines[recommender][3]);
} else {
	$T_title_recommender = "추천인";
	$T_box_recommender = $GLOBALS[lib_common]->make_input_box($edit_user_info[recommender], "recommender", "text", "tabindex='26' size='25' maxlength='100' class='designer_text'", "", "");
}

if (is_array($member_field_defines[mileage])) {
	$T_title_mileage = $member_field_defines[mileage][2];
	$item_define = $member_field_defines[mileage][1];
	$T_box_mileage = $lib_insiter->make_multi_input_box($member_field_defines[mileage][0], "mileage", $item_define, $edit_user_info[mileage], ' ', $member_field_defines[mileage][3]);
} else {
	$T_title_mileage = "마일리지";
	$T_box_mileage = $GLOBALS[lib_common]->make_input_box($edit_user_info[mileage], "mileage", "text", "tabindex='29' size='25' maxlength='100' class='designer_text'", "", "");
}

if (is_array($member_field_defines[homepage])) {
	$T_title_homepage = $member_field_defines[homepage][2];
	$item_define = $member_field_defines[homepage][1];
	$T_box_homepage = $lib_insiter->make_multi_input_box($member_field_defines[homepage][0], "homepage", $item_define, $edit_user_info[homepage], ' ', $member_field_defines[homepage][3]);
} else {
	$T_title_homepage = "홈페이지주소";
	$T_box_homepage = $GLOBALS[lib_common]->make_input_box($edit_user_info[homepage], "homepage", "text", "tabindex='17' size='50' maxlength='200' class='designer_text'", "", "");
}

$user_level_list = $lib_insiter->get_level_alias($site_info[user_level_alias]);
if ($edit_user_info[id] != $site_info[site_id]) {
	$option_name = $option_value = array();
	$T_user_level = $GLOBALS[lib_common]->get_list_boxs_array($user_level_list, "input_user_level", $edit_user_info[user_level], 'N', "tabindex='30' class='designer_select'");
} else {
	$T_user_level = "총 관리자<input type='hidden' name='input_user_level' value='$edit_user_info[user_level]'>";
}

if (is_array($member_field_defines[group_1])) {
	$T_title_group_1 = $member_field_defines[group_1][2];
	$item_define = $member_field_defines[group_1][1];
	$T_box_group_1 = $lib_insiter->make_multi_input_box($member_field_defines[group_1][0], "group_1", $item_define, $edit_user_info[group_1], ' ', $member_field_defines[group_1][3]);
} else {
	$T_title_group_1 = "그룹-1";
	$T_box_group_1 = $GLOBALS[lib_common]->make_input_box($edit_user_info[group_1], "group_1", "text", "tabindex='30' size='50' maxlength='200' class='designer_text'", "", "");
}

if (is_array($member_field_defines[group_2])) {
	$T_title_group_2 = $member_field_defines[group_2][2];
	$item_define = $member_field_defines[group_2][1];
	$T_box_group_2 = $lib_insiter->make_multi_input_box($member_field_defines[group_2][0], "group_2", $item_define, $edit_user_info[group_2], ' ', $member_field_defines[group_2][3]);
} else {
	$T_title_group_2 = "그룹-2";
	$T_box_group_2 = $GLOBALS[lib_common]->make_input_box($edit_user_info[group_2], "group_2", "text", "tabindex='30' size='50' maxlength='200' class='designer_text'", "", "");
}

if (is_array($member_field_defines[category_1])) {
	$T_title_category_1 = $member_field_defines[category_1][2];
	$item_define = $member_field_defines[category_1][1];
	$T_box_category_1 = $lib_insiter->make_multi_input_box($member_field_defines[category_1][0], "category_1", $item_define, $edit_user_info[category_1], ' ', $member_field_defines[category_1][3]);
} else {
	$T_title_category_1 = "분류-1";
	$T_box_category_1 = $GLOBALS[lib_common]->make_input_box($edit_user_info[category_1], "category_1", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[category_2])) {
	$T_title_category_2 = $member_field_defines[category_2][2];
	$item_define = $member_field_defines[category_2][1];
	$T_box_category_2 = $lib_insiter->make_multi_input_box($member_field_defines[category_2][0], "category_2", $item_define, $edit_user_info[category_2], ' ', $member_field_defines[category_2][3]);
} else {
	$T_title_category_2 = "분류-2";
	$T_box_category_2 = $GLOBALS[lib_common]->make_input_box($edit_user_info[category_2], "category_2", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[category_3])) {
	$T_title_category_3 = $member_field_defines[category_3][2];
	$item_define = $member_field_defines[category_3][1];
	$T_box_category_3 = $lib_insiter->make_multi_input_box($member_field_defines[category_3][0], "category_3", $item_define, $edit_user_info[category_3], ' ', $member_field_defines[category_3][3]);
} else {
	$T_title_category_3 = "분류-3";
	$T_box_category_3 = $GLOBALS[lib_common]->make_input_box($edit_user_info[category_3], "category_3", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[etc_1])) {
	$T_title_etc_1 = $member_field_defines[etc_1][2];
	$item_define = $member_field_defines[etc_1][1];
	$T_box_etc_1 = $lib_insiter->make_multi_input_box($member_field_defines[etc_1][0], "etc_1", $item_define, $edit_user_info[etc_1], ' ', $member_field_defines[etc_1][3]);
} else {
	$T_title_etc_1 = "기타-1";
	$T_box_etc_1 = $GLOBALS[lib_common]->make_input_box($edit_user_info[etc_1], "etc_1", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[etc_2])) {
	$T_title_etc_2 = $member_field_defines[etc_2][2];
	$item_define = $member_field_defines[etc_2][1];
	$T_box_etc_2 = $lib_insiter->make_multi_input_box($member_field_defines[etc_2][0], "etc_2", $item_define, $edit_user_info[etc_2], ' ', $member_field_defines[etc_2][3]);
} else {
	$T_title_etc_2 = "기타-2";
	$T_box_etc_2 = $GLOBALS[lib_common]->make_input_box($edit_user_info[etc_2], "etc_2", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[etc_3])) {
	$T_title_etc_3 = $member_field_defines[etc_3][2];
	$item_define = $member_field_defines[etc_3][1];
	$T_box_etc_3 = $lib_insiter->make_multi_input_box($member_field_defines[etc_3][0], "etc_3", $item_define, $edit_user_info[etc_3], ' ', $member_field_defines[etc_3][3]);
} else {
	$T_title_etc_3 = "기타-3";
	$T_box_etc_3 = $GLOBALS[lib_common]->make_input_box($edit_user_info[etc_3], "etc_3", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[etc_4])) {
	$T_title_etc_4 = $member_field_defines[etc_4][2];
	$item_define = $member_field_defines[etc_4][1];
	$T_box_etc_4 = $lib_insiter->make_multi_input_box($member_field_defines[etc_4][0], "etc_4", $item_define, $edit_user_info[etc_4], ' ', $member_field_defines[etc_4][3]);
} else {
	$T_title_etc_4 = "기타-4";
	$T_box_etc_4 = $GLOBALS[lib_common]->make_input_box($edit_user_info[etc_4], "etc_4", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[etc_5])) {
	$T_title_etc_5 = $member_field_defines[etc_5][2];
	$item_define = $member_field_defines[etc_5][1];
	$T_box_etc_5 = $lib_insiter->make_multi_input_box($member_field_defines[etc_5][0], "etc_5", $item_define, $edit_user_info[etc_5], ' ', $member_field_defines[etc_5][3]);
} else {
	$T_title_etc_5 = "기타-5";
	$T_box_etc_5 = $GLOBALS[lib_common]->make_input_box($edit_user_info[etc_5], "etc_5", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[etc_6])) {
	$T_title_etc_6 = $member_field_defines[etc_6][2];
	$item_define = $member_field_defines[etc_6][1];
	$T_box_etc_6 = $lib_insiter->make_multi_input_box($member_field_defines[etc_6][0], "etc_6", $item_define, $edit_user_info[etc_6], ' ', $member_field_defines[etc_6][3]);
} else {
	$T_title_etc_6 = "기타-6";
	$T_box_etc_6 = $GLOBALS[lib_common]->make_input_box($edit_user_info[etc_6], "etc_6", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[introduce])) {
	$T_title_introduce = $member_field_defines[introduce][2];
	$item_define = $member_field_defines[introduce][1];
	$T_box_introduce= $lib_insiter->make_multi_input_box($member_field_defines[introduce][0], "introduce", $item_define, $edit_user_info[introduce], ' ', $member_field_defines[introduce][3]);
} else {
	$T_title_introduce = "사용자메모";
	$T_box_introduce = $GLOBALS[lib_common]->make_input_box($edit_user_info[introduce], "introduce", "textarea", "tabindex='34' rows=3 cols=60 class='designer_textarea'", "width:100%;height:100%", "");
}

if (is_array($member_field_defines[biz_company])) {
	$T_title_biz_company = $member_field_defines[biz_company][2];
	$item_define = $member_field_defines[biz_company][1];
	$T_box_biz_company = $lib_insiter->make_multi_input_box($member_field_defines[biz_company][0], "biz_company", $item_define, $edit_user_info[biz_company], ' ', $member_field_defines[biz_company][3]);
} else {
	$T_title_biz_company = "사업장명";
	$T_box_biz_company = $GLOBALS[lib_common]->make_input_box($edit_user_info[biz_company], "biz_company", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[biz_number])) {
	$T_title_biz_number = $member_field_defines[biz_number][2];
	$item_define = $member_field_defines[biz_number][1];
	$T_box_biz_number = $lib_insiter->make_multi_input_box($member_field_defines[biz_number][0], "biz_number", $item_define, $edit_user_info[biz_number], ' ', $member_field_defines[biz_number][3]);
} else {
	$T_title_biz_number = "사업자번호";
	$T_box_biz_number = $GLOBALS[lib_common]->make_input_box($edit_user_info[biz_number], "biz_number", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[biz_ceo])) {
	$T_title_biz_ceo = $member_field_defines[biz_ceo][2];
	$item_define = $member_field_defines[biz_ceo][1];
	$T_box_biz_ceo = $lib_insiter->make_multi_input_box($member_field_defines[biz_ceo][0], "biz_ceo", $item_define, $edit_user_info[biz_ceo], ' ', $member_field_defines[biz_ceo][3]);
} else {
	$T_title_biz_ceo = "대표자명";
	$T_box_biz_ceo = $GLOBALS[lib_common]->make_input_box($edit_user_info[biz_ceo], "biz_ceo", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[biz_cond])) {
	$T_title_biz_cond = $member_field_defines[biz_cond][2];
	$item_define = $member_field_defines[biz_cond][1];
	$T_box_biz_cond = $lib_insiter->make_multi_input_box($member_field_defines[biz_cond][0], "biz_cond", $item_define, $edit_user_info[biz_cond], ' ', $member_field_defines[biz_cond][3]);
} else {
	$T_title_biz_cond = "업태";
	$T_box_biz_cond = $GLOBALS[lib_common]->make_input_box($edit_user_info[biz_cond], "biz_cond", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[biz_item])) {
	$T_title_biz_item = $member_field_defines[biz_item][2];
	$item_define = $member_field_defines[biz_item][1];
	$T_box_biz_item = $lib_insiter->make_multi_input_box($member_field_defines[biz_item][0], "biz_item", $item_define, $edit_user_info[biz_item], ' ', $member_field_defines[biz_item][3]);
} else {
	$T_title_biz_item = "종목";
	$T_box_biz_item = $GLOBALS[lib_common]->make_input_box($edit_user_info[biz_item], "biz_item", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

if (is_array($member_field_defines[biz_address])) {
	$T_title_biz_address = $member_field_defines[biz_address][2];
	$item_define = $member_field_defines[biz_address][1];
	$T_box_biz_address = $lib_insiter->make_multi_input_box($member_field_defines[biz_address][0], "biz_address", $item_define, $edit_user_info[biz_address], ' ', $member_field_defines[biz_address][3]);
} else {
	$T_title_biz_address = "사업장소재지";
	$T_box_biz_address = $GLOBALS[lib_common]->make_input_box($edit_user_info[biz_address], "biz_address", "text", "tabindex='33' size='35' class='designer_text'", "", "");
}

// 레벨에 따른 추가 입력폼 구현 (해당 파일 사용자정의)
$file_member_level_form = "{$DIRS[member_root]}user_define/member_level_form.inc.php";
if (file_exists($file_member_level_form)) {
	$case_user_level = $edit_user_info[user_level];
	include $file_member_level_form;
}

if ($P_member_level_form != '') {
	$member_level_form = "
		<tr><td height=10></td></tr>
		<tr>
			<td>
				$P_member_level_form
			</td>
		</tr>
	";
}
$P_contents = "
<table border='0' cellpadding='5' cellspacing='1'  width='100%' class=input_form_table>
	<tr>
		<td class='input_form_title' width=12%>아이디</td>
		<td class='input_form_value_11px' width=38%>
			" . $GLOBALS[lib_common]->make_input_box($edit_user_info[id], "id", "text", "size='25' maxlength='20' class='designer_text' tabindex='1'", "", "") . "
			$btn_is_sch
		</td>
		<td class='input_form_title' width=12%><b><font color=red>레벨</font></b></td>
		<td class='input_form_value_11px' width=38%>
			$T_user_level
		</td>
	</tr>
	<tr>
		<td class='input_form_title'>비밀번호</td>
		<td class='input_form_value_11px'>
			" . $GLOBALS[lib_common]->make_input_box('', "passwd", "text", "size='15' maxlength='20' class='designer_text' tabindex='2'", "", "") . "
			" . $GLOBALS[lib_common]->make_input_box('', "passwd_re", "text", "size='15' maxlength='20' class='designer_text' tabindex='3'", "", "") . " (2회동일입력)
		</td>
		<td class='input_form_title'>상태</td>
		<td class='input_form_value_11px'>
			" . $GLOBALS[lib_common]->get_list_boxs_array($S_user_state, "state", $edit_user_info[state], 'N', " class='designer_select'") . "
		</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_name</td>
		<td class='input_form_value_11px'>$T_box_name $T_box_gender</td>
		<td class='input_form_title'>생년월일</td>
		<td class='input_form_value_11px'>
			$T_box_birth_day
		</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_email</td>
		<td class='input_form_value_11px'>$T_box_email</td>
		<td class='input_form_title'>$T_title_hobby</td>
		<td class='input_form_value_11px'>$T_box_hobby</td>
		</td>
	</tr>
	<tr>
		<td class='input_form_title'>전화번호</td>
		<td class='input_form_value_11px'>
			" . $GLOBALS[lib_common]->make_input_box($edit_user_info[phone], "phone", "text", "size=20 maxlength=20 class='designer_text' tabindex='8'", $style) . "
		</td>
		<td class='input_form_title'>$T_title_nick</td>
		<td class='input_form_value_11px'>$T_box_nick</td>
	</tr>						
	<tr>
		<td class='input_form_title'>휴대폰번호</td>
		<td class='input_form_value_11px'>
			" . $GLOBALS[lib_common]->make_input_box($edit_user_info[phone_mobile], "phone_mobile", "text", "size=20 maxlength=20 class='designer_text' tabindex='8'", $style) . "
		</td>
		<td class='input_form_title'>팩스번호</td>
		<td class='input_form_value_11px'>
			" . $GLOBALS[lib_common]->make_input_box($edit_user_info[phone_fax], "phone_fax", "text", "size=20 maxlength=20 class='designer_text' tabindex='8'", $style) . "
		</td>
	</tr>
	<tr>
		<td rowspan=2 class='input_form_title'>주소</td>
		<td  rowspan=2 class='input_form_value_11px'>
			" . $GLOBALS[lib_common]->make_input_box($edit_user_info[post], "post", "text", "size=7 maxlength=7 class='designer_text'", $style) . "
			" . $GLOBALS[lib_common]->make_input_box("주소검색", "btn_address", "button", "tabindex='14' onclick=\"open_window_mouse('{$root}member/zipsearch.php?nm_post_one=post&nm_addr=address', '550', '400')\" class='designer_button'", "") . "<br>
			" . $GLOBALS[lib_common]->make_input_box($edit_user_info[address], "address", "text", "size=55 class='designer_text'", $style) . "
		</td>
		<td class='input_form_title'>$T_title_messenger</td>
		<td class='input_form_value_11px'>$T_box_messenger</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_recommender</td>
		<td class='input_form_value_11px'>$T_box_recommender</td>
	</tr>
	<tr>
		<td class='input_form_title'>주민등록번호</td>
		<td class='input_form_value_11px'>
			" . $GLOBALS[lib_common]->make_input_box($edit_user_info[jumin_number], "jumin_number", "text", "tabindex='15' size='20' maxlength='14' class='designer_text'", "", "") . "
		</td>
		<td class='input_form_title'>$T_title_mileage</td>
		<td class='input_form_value_11px'>$T_box_mileage</td>
	</tr>							
	<tr>
		<td class='input_form_title'>$T_title_homepage</td>
		<td class='input_form_value_11px'>$T_box_homepage</td>
		<td class='input_form_title'>$T_title_job_kind</td>
		<td class='input_form_value_11px'>$T_box_job_kind</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_biz_company</td>
		<td class='input_form_value_11px'>$T_box_biz_company</td>
		<td class='input_form_title'>$T_title_biz_cond</td>
		<td class='input_form_value_11px'>$T_box_biz_cond</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_biz_number</td>
		<td class='input_form_value_11px'>$T_box_biz_number</td>
		<td class='input_form_title'>$T_title_biz_item</td>
		<td class='input_form_value_11px'>$T_box_biz_item</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_biz_ceo</td>
		<td class='input_form_value_11px'>$T_box_biz_ceo</td>
		<td class='input_form_title'>$T_title_biz_address</td>
		<td class='input_form_value_11px'>$T_box_biz_address</td>
	</tr>
	<tr>					
		<td class='input_form_title'>$T_title_group_1</td>
		<td class='input_form_value_11px'>$T_box_group_1</td>
		<td class='input_form_title'>$T_title_group_2</td>
		<td class='input_form_value_11px'>$T_box_group_2</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_category_1</td>
		<td class='input_form_value_11px'>$T_box_category_1</td>
		<td class='input_form_title'>$T_title_etc_1</td>
		<td class='input_form_value_11px'>$T_box_etc_1</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_category_2</td>
		<td class='input_form_value_11px'>$T_box_category_2</td>
		<td class='input_form_title'>$T_title_etc_2</td>
		<td class='input_form_value_11px'>$T_box_etc_2</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_category_3</td>
		<td class='input_form_value_11px'>$T_box_category_3</td>
		<td class='input_form_title'>$T_title_etc_3</td>
		<td class='input_form_value_11px'>$T_box_etc_3</td>
	</tr>
	<tr>
		<td class='input_form_title' rowspan=3>$T_title_introduce</td>
		<td class='input_form_value_11px' rowspan=3 height=100%>$T_box_introduce</td>
		<td class='input_form_title'>$T_title_etc_4</td>
		<td class='input_form_value_11px'>$T_box_etc_4</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_etc_5</td>
		<td class='input_form_value_11px'>$T_box_etc_5</td>
	</tr>
	<tr>
		<td class='input_form_title'>$T_title_etc_6</td>
		<td class='input_form_value_11px'>$T_box_etc_6</td>
	</tr>
	<tr>
		<td class='input_form_title'>관리자메모</td>
		<td class='input_form_value_11px' height=100%>
			" . $GLOBALS[lib_common]->make_input_box($edit_user_info[admin_memo], "admin_memo", "textarea", "tabindex='18' rows=10 cols=55 class='designer_textarea'", "width:100%;height:100%", "") . "
		</td>
		<td class='input_form_title'>업로드파일</td>
		<td class='input_form_value_11px'>
			<table cellpadding=1 cellspacing=0 border=0>
				<tr>
					<td>#1</td>
					<td>" . $GLOBALS[lib_common]->get_file_upload_box("upload_file", 1, $edit_user_info[upload_file], "tabindex='20' size='25' class='designer_text'", $DIRS[member_img]) . "</td>
				</tr>
				<tr>
					<td>#2</td>
					<td>" . $GLOBALS[lib_common]->get_file_upload_box("upload_file", 2, $edit_user_info[upload_file], "tabindex='21' size='25' class='designer_text'", $DIRS[member_img]) . "</td>
				</tr>
				<tr>
					<td>#3</td>
					<td>" . $GLOBALS[lib_common]->get_file_upload_box("upload_file", 3, $edit_user_info[upload_file], "tabindex='22' size='25' class='designer_text'", $DIRS[member_img]) . "</td>
				</tr>
				<tr>
					<td>#4</td>
					<td>" . $GLOBALS[lib_common]->get_file_upload_box("upload_file", 4, $edit_user_info[upload_file], "tabindex='23' size='25' class='designer_text'", $DIRS[member_img]) . "</td>
				</tr>
				<tr>
					<td>#5</td>
					<td>" . $GLOBALS[lib_common]->get_file_upload_box("upload_file", 5, $edit_user_info[upload_file], "tabindex='24' size='25' class='designer_text'", $DIRS[member_img]) . "</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>"<b>회원정보입력</b>"));
echo("
<script language='javascript'>
<!-- 
	function open_search_id(form, ref) {
		id = eval(document.all.id);
		if (!id.value) {
			alert('아이디(ID)를 입력하신 후에 확인하세요!');
			id.focus();
			return;
		}
		reg_express = new RegExp('^[a-z0-9]{6,15}$');
		if (!reg_express.test(id.value)) {
			alert('6~15자리의 영문 또는 숫자로 이루어진 아이디만 사용 가능합니다.');
			id.value = '';
			return
		}
		ref = '{$DIRS[member_root]}check_id.php?id=' + id.value + '&form_name=' + form.name;
		open_window_mouse(ref, '450', '200');
	}
	function verify_submit(form) {
		if (form.mode.value == 'add') {
			if (form.id.value == '' || form.id_hidden.value == '' || (form.id.value != form.id_hidden.value)) {
				alert('아이디 검색을 이용해서 아이디를 입력해주세요');
				form.id.focus();
				return false;
			}
			if (form.passwd.value == '' && form.passwd_re.value == '') {
				alert('비밀번호를 입력하세요');
				form.passwd.focus();
				return false;
			}
		}

		if (form.passwd.value != form.passwd_re.value) {
			alert('비밀번호 정확히 입력해주세요, 두 비밀번호가 맞지 않습니다.');
			form.passwd.focus();
			return false;
		}
	}
//-->
</script>
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<form name='TCSYSTEM_MEMBER_FORM' method='post' action='member_manager.php' onsubmit='return verify_submit(this);' enctype='multipart/form-data'>
	<input type='hidden' name='mode' value='$mode'>
	<input type='hidden' name='serial_num' value='$_GET[serial_num]'>
	<input type='hidden' name='id_pre' value='$edit_user_info[id]'>
	<input type='hidden' name='id_hidden' value=''>
	<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	<input type='hidden' name='is_stripslashes' value='N'>
	<tr>
		<td>$P_contents</td>
	</tr>
	<tr>
		<td align=center height=30>
			<input type=submit value='저장하기' class='designer_button'>
		</td>
	</tr>
	$member_level_form
	</form>
</table>
");
include "footer.inc.php";
?>