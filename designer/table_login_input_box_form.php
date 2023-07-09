<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // 파일 내용을 읽어온다
if ($cpn > 0) {	// 저장되어 있는 항목을 클릭한 경우
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "로그인입력상자") {		// 회원 입력상자인 경우만 설정을 불러온다.
		$article_item = $exp[1];					// 기존 선택된 필드항목
		$input_box_type = $exp[2];
		$default_pp = $exp[3];					// 기본속성
		$item_define = $exp[4];
		$item_divider = $exp[5];
		$item_index = $exp[6];
	} else {
		$exp = "";
		$article_item = "user_id";
	}
} else {
	$exp = "";
	$article_item = "user_id";
}
$P_login_input_field = "
						<table width='100%' border='0' cellspacing='0' cellpadding='3' >
							<tr>
								<td valign=bottom>
									<table>
										<tr>
											<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_radio_password", "", "user_id") . "<b>아이디</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_radio_password", "", "user_passwd") . "<b>비밀번호</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", "", "save_user_id") . "<b>아이디저장</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", "", "save_user_passwd") . "<b>비밀번호저장</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=radio_select", "", "user_level") . "<b>회원분류</b></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
";
$P_login_input_field = $lib_insiter->w_get_img_box($IS_thema_window, $P_login_input_field, $IS_input_box_padding, array("title"=>"로그인용 입력상자 선택"));

include "{$DIRS[designer_root]}include/form_input_box.inc.php";
include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$help_msg = "
	로그인용 입력상자 삽입
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
		form.item_index.disabled = true;
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

		if (form.article_item_user.value == 'save_user_id' || form.article_item_user.value == 'save_user_passwd' || chk_fld_id_2 == '' || chk_fld_id_2 == 'basic') {
			form.item_define.disabled = true;												// 항목정의 없음
			form.item_define.style.background = 'fafafa';
		} else {
			form.item_define.disabled = false;												// 항목정의 있음
			form.item_define.style.background = 'ffffff';
		}
		if ((chk_fld_value_2 == 'checkbox' || chk_fld_value_2 == 'radio') && (form.article_item_user.value != 'save_user_id' && form.article_item_user.value != 'save_user_passwd')) {
			form.divider.disabled = false;														// 항목간 내용 있음
			form.divider.style.background = 'ffffff';			
		} else {
			form.divider.disabled = true;															// 항목간 내용 없음
			form.divider.style.background = 'fafafa';
		}

		// 선택항목 기본값 변환
		form.item_define.value = form.item_define.defaultValue;
		switch (chk_fld_value) {
			case 'user_level' :
				if (form.item_define.value == '') form.item_define.value = '" . str_replace("\r\n", chr(92).r.chr(92).n, $site_info[user_level_alias]) . "';
			break;
		}
	}

	function verify_submit() {
		form = document.frm;
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
	<form method='post'  name='frm' action='table_login_input_box_manager.php' onsubmit='return verify_submit(this)'>
	<input type=hidden name=design_file value=$design_file>
	<input type=hidden name=index value=$index>
	<input type=hidden name=current_line value=$current_line>
	<input type=hidden name=cpn value=$cpn>
	<tr>
		<td>
			$P_login_input_field
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
	inverter_1();
//-->
</script>
");
include "footer_sub.inc.php";
?>