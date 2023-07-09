<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // 파일 내용을 읽어온다

if ($cpn > 0) {	// 저장되어 있는 항목을 클릭한 경우
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	$default_value_info = $exp[7];
	if ($exp[0] == "게시판입력상자") {	// 게시물 정보인 경우만 설정을 불러온다.
		$article_item = $exp[1];					// 기존 선택된 필드항목
		$input_box_type = $exp[2];			// 입력상자 형태
		$default_pp = $exp[3];					// 기본속성
		$item_define = $exp[4];
		$item_divider = $exp[5];
		$item_index = $exp[6];
	}
}

$P_only_board_box = 'Y';

include "{$DIRS[designer_root]}include/form_input_box.inc.php";
include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$P_form_input = "
	<table width='100%'>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "subject") . "<b>제목</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "writer_name") . "<b>작성자</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "email") . "<b>이메일</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "homepage") . "<b>홈페이지</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "phone") . "<b>전화번호</b></td>
		</tr>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "comment") . "<b>내용</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=file", '', "user_file") . "<b>업로드파일</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password_calendar", '', "sign_date") . "<b>작성일</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password", '', "writer_id") . "<b>작성자아이디</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password", '', "passwd") . "<b>비밀번호</b></td>
		</tr>
		<tr>											
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_html_select_checkbox_radio_password_hidden_calendar", '', "etc") . "<b>기타</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select_radio_checkbox", '', "category") . "<b>분류입력</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select_radio_checkbox", '', "type") . "<b>게시물유형</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "is_html") . "<b>HTML체크</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "is_notice") . "<b>공지글체크</b></td>
		</tr>
		<tr>											
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "is_private") . "<b>비공개체크</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "is_view") . "<b>출력안함체크</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "reply_answer") . "<b>답변메일체크</b></td>
			<td></td>
			<td></td>
		</tr>
		<tr>											
			<td colspan=5><hr size=1 width=100% color=cccccc></td>
		</tr>
		<tr>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select", '', "tpa") . "<b>목록게시물수</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=checkbox", '', "list_select[]") . "<b>다중선택</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=text_textarea_select_checkbox_radio_password", '', "search_value") . "<b>검색어입력</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select_radio_checkbox", '', "search_item") . "<b>검색필드선택</b></td>
			<td>" . $GLOBALS[lib_common]->make_input_box($article_item, "article_item", "radio", "onclick='inverter()' id=select_radio", '', "category_go") . "<b>분류이동</b></td>
		</tr>
	</table>
";
$P_form_input = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input, $IS_input_box_padding, array("title"=>"<b>입력항목선택</b>"));

$help_msg = "
	게시판 입력상자 설정
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--
	var checked_value = checked_id = '';
	// 필드에 따른 활용 가능한 입력상자 종류 제한
	function inverter() {
		form = document.frm;
		for (i=0; i<form.article_item.length; i++) {
			if (form.article_item[i].checked) {
				checked_id = form.article_item[i].id;
				checked_value = form.article_item[i].value;
			}
		}
		disable_child_radio(checked_id, form.input_box_type);	// 선택된 필드에 따른 출력 속성 제한
		form.article_item_user.value = checked_value;

		// 항목 인덱스 입력상자 활성화여부
		if (checked_value == 'category' || checked_value == 'comment' || checked_value == 'user_file' || checked_value == 'etc' || checked_value == 'category_go' || (checked_value == 'sign_date' && form.input_box_use_mode.checked == true)) form.item_index.disabled = false;
		else form.item_index.disabled = true;
		
		// 검색용 체크상자 활성화여부
		if (checked_value == 'tpa' || checked_value == 'list_select[]' || checked_value == 'search_value' || checked_value == 'search_item' || checked_value == 'category_go' || checked_value == '') form.input_box_use_mode.disabled = true;
		else form.input_box_use_mode.disabled = false;

		// 저장값 선택, 입력상자 활성화 여부
		if (checked_value == 'list_select[]' || checked_value == 'search_value' || checked_value == 'search_item' || checked_value == 'category_go') {
			form.input_box_default_value_mode.disabled = true;
			form.input_box_default_value.disabled = true;
		} else {
			form.input_box_default_value_mode.disabled = false;
			form.input_box_default_value.disabled = false;
		}
		inverter_1();
	}

	function chg_use_mode() {
		form = document.frm;
		inverter();
		if (form.input_box_use_mode.checked == true) {
			if (form.item_index.value != '') T_str = '_' + form.item_index.value;
			else T_str = '';
			form.input_box_default_value_mode.value = 'G';
			form.input_box_default_value.value = 'SCH_' + form.article_item_user.value + T_str;
		} else {
			form.input_box_default_value_mode.value = form.input_box_default_value_mode.defaultValue;
			form.input_box_default_value.value = form.input_box_default_value.defaultValue;
		}
	}

	// 입력상자에 따른 항목값 입력 상자 출력 결정
	function inverter_1() {
		form = document.frm;
		checked_id_2 = checked_value_2 = '';
		for (i=0; i<form.input_box_type.length; i++) {
			if (form.input_box_type[i].checked) {
				checked_id_2 = form.input_box_type[i].id;
				checked_value_2 = form.input_box_type[i].value;
			}
		}
		if (checked_id == 'checkbox' || checked_id_2 == 'basic' || checked_value=='category' || checked_value=='type' || checked_value=='category_go' || checked_value=='search_item') {
			form.item_define.disabled = true;												// 항목정의 없음
			form.item_define.style.background = 'fafafa';
		} else {
			form.item_define.disabled = false;												// 항목정의 있음
			form.item_define.style.background = 'ffffff';
		}
		if (checked_value_2 == 'checkbox' || checked_value_2 == 'radio') {
			form.divider.disabled = false;														// 항목간 내용 있음
			form.divider.style.background = 'ffffff';
		} else {
			form.divider.disabled = true;															// 항목간 내용 없음
			form.divider.style.background = 'fafafa';
		}
	}

	function verify_submit() {
		form = document.frm;
		select_flag = 0;
		for(i=0; i<form.article_item.length; i++) if (form.article_item[i].checked) select_flag = 1;
		if (select_flag == 0) {
			alert('입력할 항목을 선택하세요');
			form.article_item[0].focus();
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
<table width=100% border=0 cellpadding=0 cellspacing=0>
	<form method='post'  name='frm' action='table_board_input_box_manager.php' enctype='multipart/form-data' onsubmit='return verify_submit()'>
	<input type=hidden name=design_file value=$design_file>
	<input type=hidden name=index value=$index>
	<input type=hidden name=current_line value=$current_line>
	<input type=hidden name=cpn value=$cpn>
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
				<tr>
					<td>
						$P_form_input
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='5' cellspacing='3' id='DF_FORM' style='display:{$is_saved_default}'>	
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
			</table>
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