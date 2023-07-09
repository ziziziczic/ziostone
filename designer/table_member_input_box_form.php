<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // 파일 내용을 읽어온다
if ($cpn > 0) {	// 저장되어 있는 항목을 클릭한 경우
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "회원입력상자") {		// 회원 입력상자인 경우만 설정을 불러온다.
		$article_item = $exp[1];					// 기존 선택된 필드항목
		$input_box_type = $exp[2];
		$default_pp = $exp[3];					// 기본속성
		$item_define = $exp[4];
		$item_divider = $exp[5];
		$item_index = $exp[6];
	}
}

$P_member_input_field = "
<table width='100%' cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "id") . "아이디</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "name") . "이름</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "passwd") . "비밀번호</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "passwd_re") . "비밀번호확인</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "gender") . "성별</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "homepage") . "홈페이지</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "introduce") . "메모</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "hobby") . "취미</td>					
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "nick_name") . "닉네임</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "messenger") . "메신저주소</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select_radio", "", "mailing") . "메일링</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "job_kind") . "직종</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "recommender") . "추천인</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=file", "", "upload_file") . "업로드파일</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "admin_memo") . "관리메모</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "group_1") . "그룹1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "group_2") . "그룹2</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "sido") . "시도</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "gugun") . "구군</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "category_1") . "분류1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "category_2") . "분류2</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "category_3") . "분류3</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_1") . "기타1</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_2") . "기타2</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_3") . "기타3</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_4") . "기타4</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_5") . "기타5</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "etc_6") . "기타6</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>					
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "email") . "이메일주소</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "email_1") . "<font color=999999>이메일1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "email_2") . "<font color=999999>이메일2</font>)</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>					
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "birth_day") . "생년월일</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "birth_1") . "<font color=999999>생년</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "birth_2") . "<font color=999999>생월</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "birth_3") . "<font color=999999>생일</font>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "post") . "우편번호</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "post_1") . "<font color=999999>우편1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "post_2") . "<font color=999999>우편2</font>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "address") . "주소</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone") . "전화번호</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_1") . "<font color=999999>전화1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_2") . "<font color=999999>전화2</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_3") . "<font color=999999>전화3</font>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_mobile") . "휴대폰번호</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_mobile_1") . "<font color=999999>휴대폰1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_mobile_2") . "<font color=999999>휴대폰2</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_mobile_3") . "<font color=999999>휴대폰3</font>)</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_fax") . "팩스번호</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_fax_1") . "<font color=999999>팩스1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_fax_2") . "<font color=999999>팩스2</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "phone_fax_3") . "<font color=999999>팩스3</font>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "jumin_number") . "주민번호</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "jumin_number_1") . "<font color=999999>주민1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", "", "jumin_number_2") . "<font color=999999>주민2</font></a>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_file_html_hidden", "", '') . "<font color=999999>사용자</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_company") . "회사명</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_number") . "사업자번호</td>
					<td>(" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_number_1") . "<font color=999999>번호1</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_number_2") . "<font color=999999>번호2</font></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_number_3") . "<font color=999999>번호3</font>)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_ceo") . "대표자</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_cond") . "업태</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_item") . "종목</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_hidden", '', "biz_address") . "소재지</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_member_input_field = $lib_insiter->w_get_img_box($IS_thema_window, $P_member_input_field, $IS_input_box_padding, array("title"=>"DB table field 선택 (테이블 : TCMEMBER)"));

include "{$DIRS[designer_root]}include/form_input_box.inc.php";
include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$help_msg = "
	회원정보 입력상자 삽입화면
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--
	var chk_fld='', chk_fld_id='', chk_fld_value='';
	var chk_fld_2 = 'T', chk_fld_id_2='', chk_fld_value_2='';
	function inverter() {
		form = document.frm;
		for (i=0; i<form.article_item.length; i++) {
			if (form.article_item[i].checked) {
				chk_fld_id = form.article_item[i].id;
				chk_fld_value = form.article_item[i].value;
			}
		}
		disable_child_radio(chk_fld_id, form.input_box_type);	// 선택된 필드에 따른 출력 속성 제한
		form.article_item_user.value = chk_fld_value;
		if (chk_fld_value == 'upload_file') form.item_index.disabled = false;
		else form.item_index.disabled = true;

		// 선택항목 기본값 변환
		form.item_define.value = form.item_define.defaultValue;
		switch (chk_fld_value) {
			case 'gender' :
				if (form.item_define.value == '') form.item_define.value = '{$GLOBALS[VI][DD_gender]}';
			break;
			case 'mailing' :
				if (form.item_define.value == '') form.item_define.value = '{$GLOBALS[VI][DD_mailling]}';
			break;
			case 'phone_1' :
				if (form.item_define.value == '') form.item_define.value = '{$GLOBALS[VI][DD_phone_1]}';
			break;
			case 'phone_mobile_1' :
				if (form.item_define.value == '') form.item_define.value = '{$GLOBALS[VI][DD_phone_mobile_1]}';
			break;
			case 'phone_fax_1' :
				if (form.item_define.value == '') form.item_define.value = '{$GLOBALS[VI][DD_phone_fax_1]}';
			break;
		}
		inverter_1();
	}

	// 입력상자에 따른 항목값 입력 상자 출력 결정
	function inverter_1() {
		form = document.frm;
		for (i=0; i<form.input_box_type.length; i++) {
			if (form.input_box_type[i].checked) {
				chk_fld_id_2 = form.input_box_type[i].id;
				chk_fld_value_2 = form.input_box_type[i].value;
			}
		}
		if (chk_fld_id_2 == '' || chk_fld_id == 'checkbox' || chk_fld_id_2 == 'basic' || chk_fld_value == 'group') {
			form.item_define.disabled = true;	// 항목정의 없음
			form.item_define.style.background = 'fafafa';
		} else {
			form.item_define.disabled = false;												// 항목정의 있음
			form.item_define.style.background = 'ffffff';
		}
		if (chk_fld_value_2 == 'checkbox' || chk_fld_value_2 == 'radio') {
			form.divider.disabled = false;														// 항목간 내용 있음
			form.divider.style.background = 'ffffff';			
		} else {
			form.divider.disabled = true;															// 항목간 내용 없음
			form.divider.style.background = 'fafafa';
		}
	}

	function verify_submit(form) {
		select_flag = 0;
		for(i=0; i<form.article_item.length; i++) if (form.article_item[i].checked) select_flag = 1;
		if (select_flag == 0) {
			alert('입력할 항목을 선택하세요');
			return false;
		}
		select_flag = 0;
		for(i=0; i<form.input_box_type.length; i++) if (form.input_box_type[i].disabled == false && form.input_box_type[i].checked) select_flag = 1;
		if (select_flag == 0) {
			alert('입력 타입을 선택하세요');
			return false;
		}
		if (form.item_index.disabled == false && form.item_index.value == '') {
			alert('필드 번호를 입력하세요.');
			form.item_index.focus();
			return false;
		}
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<form method='post'  name='frm' action='table_member_input_box_manager.php' onsubmit='return verify_submit(this)'>
	<input type=hidden name=design_file value=$design_file>
	<input type=hidden name=index value=$index>
	<input type=hidden name=current_line value=$current_line>
	<input type=hidden name=cpn value=$cpn>
	<tr>
		<td>
			$P_member_input_field
		</td>
	</tr>
	<tr>
		<td>
			$P_form_input_box
		</td>
	</tr>
	<tr>
		<td>
			$P_form_open_close_tag
		</td>
	</tr>
		<tr>
		<td>
			$P_form_blank
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'>
			<a href='javascript:window.close()'><img src='{$DIRS[designer_root]}images/bt_close.gif' border='0'></a>
		</td>
	</tr>
	</form>
	<tr>
		<td>
			$P_table_form_help
		</td>
	</tr>
</table>
<script language='javascript1.2'>
<!--
	inverter();
//-->
</script>
");
include "footer_sub.inc.php";
?>