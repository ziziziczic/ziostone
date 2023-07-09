<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);               // 파일 내용을 읽어온다
if ($cpn > 0) {	// 저장되어 있는 항목을 클릭한 경우
	$exp = explode($GLOBALS[DV][dv], $design[$current_line]);
	if ($exp[0] == "버튼" || $exp[0] == "그림") {
		if ($exp[1] == '')	$button_item = "user";
		else $button_item = $exp[1];					// 기존 선택된 필드항목
		$button_type = $exp[2];							// 버튼 형태
		$link_info = explode($GLOBALS[DV][ct4], $exp[5]);
		$pp_link_target = $link_info[0];
		$pp_link_nw = $link_info[1];
		$pp_link_etc = $link_info[2];
		$pp_link_rollover = $link_info[3];
		if ($exp[6] != '') {
			$btn_etc = explode($GLOBALS[DV][ct4], $exp[6]);
			switch ($button_item) {
				case "sort" :
					$sort_fld_name = $btn_etc[0];
					$sort_sequence = $btn_etc[1];
					$sort_is_multi = $btn_etc[2];
					$sort_design_file = $btn_etc[3];
					$sort_link_file = $btn_etc[4];
				break;
				case "multi_submit" :
					$multi_submit_action = $btn_etc[0];
					$multi_submit_target = $btn_etc[1];
					$multi_submit_fnc = $btn_etc[2];
				break;
			}			
		}
		$link_url = explode($GLOBALS[DV][ct4], $exp[7]);
		$user_link_page = $link_url[0];
		$user_link_url = $link_url[1];
		$is_rollover = $link_info[5];
		
		$exp_tag_both = explode($GLOBALS[DV][ct4], $exp[12]);
		$tag_open = $exp_tag_both[0];
		$tag_close = $exp_tag_both[1];

		if ($button_type == "태그") {
			$define_property = array();
			$tag_value = $exp[3];
			$default_property = $GLOBALS[lib_common]->parse_property($exp[4], ' ', '=', $define_property);
			$pp_tag_etc = $default_property[etc];
		} else if ($button_type == "글자") {
			$define_property = array("face", "size", "color");
			$default_property = $GLOBALS[lib_common]->parse_property($exp[4], ' ', '=', $define_property);
			$pp_font_face = $default_property[face];
			$pp_font_size = $default_property[size];
			$pp_font_color = $default_property[color];
			$pp_font_etc = $default_property[etc];
			$text_value = $exp[3];
		} else {
			$define_property = array("width", "height", "border", "align");
			$default_property = $GLOBALS[lib_common]->parse_property($exp[4], ' ', '=', $define_property);
			$pp_img_width = $default_property[width];
			$pp_img_height = $default_property[height];
			$pp_img_align = $default_property[align];
			$pp_img_border = $default_property[border];
			$pp_img_etc = $default_property[etc];
			$pp_img_src = $exp[3];
		}
	} else {
		$exp = '';
		$button_item = "user";
		$button_type = "그림";
	}
}
if ($button_item == '') $button_item = "user";
if ($button_type == '') $button_type = "그림";

$disabled_board = $disabled_member = $disabled_login = $disabled_submit = '';
switch($mode) {
	case "board" :
		$disabled_member = $disabled_login = " disabled";
	break;
	case "member" :
		$disabled_board = $disabled_login = " disabled";
	break;
	case "login" :
		$disabled_board = $disabled_member = " disabled";
	break;
	default :
		$disabled_board = $disabled_member = $disabled_login = $disabled_submit = " disabled";
	break;
}

$options = array("asc"=>"오름차순", "desc"=>"내림차순");

$P_form_input = "
						<table width='100%' border='0' cellspacing='0' cellpadding='3' >
							<tr>
								<td width=15%>* 일반버튼</td>
								<td width=85%><hr></td>
							</tr>
							<tr>
								<td colspan=2>
									<table width='100%'>
										<tr>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "user") . "<b>사용자정의</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "home") . "<b>홈으로이동</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "login") . "<b>로그인</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "logout") . "<b>로그아웃</b></td>
										</tr>
										<tr>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "member") . "<b>회원가입</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "favor") . "<b>즐겨찾기</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "start") . "<b>시작페이지로</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "admin") . "<b>관리자모드</b></td>
										</tr>
										<tr>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "back") . "<b>뒤로이동</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "close") . "<b>창닫기</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'", "", "print") . "<b>인쇄하기</b></td>
											<td></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>* 게시판버튼</td>
								<td><hr></td>
							</tr>
							<tr>
								<td colspan=2>
									<table width='100%'>
										<tr>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_board}", "", "list") . "<b>목록보기</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_board}", "", "write") . "<b>글쓰기</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_board}", "", "modify") . "<b>글수정</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_board}", "", "delete") . "<b>글삭제</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_board}", "", "submit") . "<b>저장(SUBMIT)</b></td>
										</tr>
										<tr>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_board}", "", "reply") . "<b>답글쓰기</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_board}", "", "prev") . "<b>이전글</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_board}", "", "next") . "<b>다음글</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_board}", "", "reset") . "<b>다시쓰기</b></td>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()' id=LY-SORT{$disabled_board}", "", "sort") . "<b>정렬버튼</b></td>
										</tr>
										<tr>
											<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()' id=LY-MULTISUBMIT{$disabled_board}", "", "multi_submit") . "<b>다중선택확인</b></td>
											<td></td>
										</tr>
										<tr id='LY-SORT' style='display:none'>
											<td colspan=5 align=center>
												* 필드명 : " . $GLOBALS[lib_common]->make_input_box($sort_fld_name, "sort_fld_name", "text", "size=10 class=designer_text", "") . "
												" . $GLOBALS[lib_common]->get_list_boxs_array($options, "sort_sequence", $sort_sequence, 'Y', " class=designer_select") . "
												, 다중정렬 : " . $GLOBALS[lib_common]->make_input_box($sort_is_multi, "sort_is_multi", "checkbox", " class=designer_checkbox", "", 'Y') . "
												, 디자인파일 : " . $GLOBALS[lib_common]->make_input_box($sort_design_file, "sort_design_file", "text", "size=5 class=designer_text", "") . "
												, 링크파일 : " . $GLOBALS[lib_common]->make_input_box($sort_link_file, "sort_link_file", "text", "size=5 class=designer_text", "") . "
											</td>
										</tr>
										<tr id='LY-MULTISUBMIT' style='display:none'>
											<td colspan=5 align=center>
												* FORM.ACTION : " . $GLOBALS[lib_common]->make_input_box($multi_submit_action, "multi_submit_action", "text", "size=15 class=designer_text", "") . "
												, FORM.TARGET : " . $GLOBALS[lib_common]->make_input_box($multi_submit_target, "multi_submit_target", "text", "size=10 class=designer_text", "") . "
												, 함수명 : " . $GLOBALS[lib_common]->make_input_box($multi_submit_fnc, "multi_submit_fnc", "text", "size=20 class=designer_text", "") . "
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>* 회원관련버튼</td>
								<td><hr></td>
							</tr>
							<tr>
								<td colspan=2>
									<table width='100%' border='0' cellspacing='0' cellpadding='3' >
										<tr>
											<td colspan=8 align=right valign=bottom>
												<table width='100%'>
													<tr>
														<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_member}", "", "search_id") . "<b>아이디검색</b></td>
														<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_member}", "", "search_post") . "<b>주소검색</b></td>
														<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_member}", "", "submit") . "<b>저장&확인</b></td>
														<td>&nbsp;</td>
													</tr>
													<tr>
														<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_login}", "", "logout") . "<b>로그아웃</b></td>
														<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_login}", "", "member") . "<b>회원가입</b></td>
														<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_login}", "", "search_passwd") . "<b>비밀번호찾기</b></td>
														<td>" . $GLOBALS[lib_common]->make_input_box($button_item, "button_item", "radio", "onclick='inverter()'{$disabled_login}", "", "submit") . "<b>저장&확인</b></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>						
						</table>
";
$P_form_input = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input, $IS_input_box_padding, array("title"=>"<b>버튼선택</b>"));

$FL_upload_image = 'Y';
include "./include/pp_form_img.inc.php";

$FL_text_value = 'Y';
include "./include/pp_form_font.inc.php";

$FL_tag_value = 'Y';
include "./include/pp_form_tag.inc.php";

$page_type = array('U', 'P', 'Y');
$page_type_board = array('B');

include "./include/pp_form_link.inc.php";

include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$P_form_input_type = "
						<table width='100%' border='0' cellspacing='0' cellpadding='3' >
							<tr>
								<td>
									<table width=100% cellpadding=2 cellspacing=0 border=0>
										<tr>
											<td width=110>형식선택</td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($button_type, "button_type", "radio", "onclick='inverter_1()' class='designer_radio'", "", "그림") . "그림버튼
												" . $GLOBALS[lib_common]->make_input_box($button_type, "button_type", "radio", "onclick='inverter_1()' class='designer_radio'", "", "글자") . "글자버튼
												" . $GLOBALS[lib_common]->make_input_box($button_type, "button_type", "radio", "onclick='inverter_1()' class='designer_radio'", "", "태그") . "태그버튼
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><td><hr size=1></td></tr>
							<tr id='IMAGE' style='display:{$is_saved_image}'>
								<td>
									$P_form_img
								</td>
							</tr>
							<tr id='TEXT' style='display:{$is_saved_text}'>
								<td>
									$P_pp_form_font
								</td>
							</tr>
							<tr id='TAG' style='display:{$is_saved_tag}'>
								<td colspan=4>
									$P_pp_form_tag
								</td>
							</tr>
							<tr><td><hr size=1></td></tr>
							<tr>
								<td>
									<table width=100% cellpadding=2 cellspacing=0 border=0>
										<tr>
											<td width=80><font color=red>내부페이지</font></td>
											<td>
												" . $lib_insiter->design_file_list("user_link_page", $page_type, "Y", $design_file, "onchange='select_inner_page()'", $user_link_page, 'N', 'T', 'Y') . "
												" . $lib_insiter->design_file_list("user_link_board", $page_type_board, "N", $design_file, "onchange='select_board_page()'",  $user_link_page, 'N', 'T', 'Y') . " 게시판
											</td>
										</tr>
										<tr>
											<td width=80><font color=red>사용자링크</font></td>
											<td>
												" . $GLOBALS[lib_common]->make_input_box($user_link_url, "user_link_url", "text", "size=70 maxlength=200' class='designer_text'", "") . "
											</td>
										</tr>
									</table>
								</td>
							</tr>							
							<tr>
								<td>
									$P_pp_form_link
								</td>
							</tr>
						</table>
";
$P_form_input_type = $lib_insiter->w_get_img_box($IS_thema, $P_form_input_type, $IS_input_box_padding, array("title"=>"<b>버튼모양&링크 설정</b>"));

$help_msg = "
	버튼삽입화면
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

echo("
<script language='javascript1.2'>
<!--
	var msg, c1;
	var chk_fld='', chk_fld_id='', chk_fld_value='';
	var chk_prt = 'T', chk_prt_id='', chk_prt_value='';

	function inverter() {
		form = document.frm;
		for (i=0; i<form.button_item.length; i++) {	 // 선택된 필드 정보 저장
			if (typeof(form.button_item[i]) == 'undefined') continue;
			if (form.button_item[i].checked) {
				chk_fld = form.button_item[i];
				chk_fld_id = form.button_item[i].id;
				chk_fld_value = form.button_item[i].value;
			}
		}
		switch (chk_fld_value) {
			case 'favor' :
			case 'start' :
			case 'back' :
			case 'close' :
			case 'print' :
			case 'reset' :
			case 'search_id' :
			case 'search_post' :
			case 'submit' :
				form.pp_link_target.disabled = true;
			break;
			default :
				form.pp_link_target.disabled = false;
			break;
		}

		if (chk_fld_value == 'user') {
			form.user_link_page.disabled = false;
			form.user_link_board.disabled = false;
			form.user_link_url.disabled = false;
		} else if (chk_fld_value == 'search_post') {
			form.user_link_page.disabled = true;
			form.user_link_board.disabled = true;
			form.user_link_url.disabled = false;
			form.user_link_url.value = form.user_link_url.defaultValue;
			if (form.user_link_url.value == '') form.user_link_url.value = \"javascript:open_search_post('{$DIRS[member_root]}zipsearch.php?nm_post_one=post_1&nm_post_two=post_2&nm_addr=address')\";
		} else if (chk_fld_value == 'list' || chk_fld_value == 'write' || chk_fld_value == 'modify' || chk_fld_value == 'delete' || chk_fld_value == 'reply' || chk_fld_value == 'sort') {
			form.user_link_page.disabled = true;
			form.user_link_board.disabled = true;
			form.user_link_url.disabled = false;
		} else {
			 form.user_link_page.disabled = true;
			 form.user_link_board.disabled = true;
			 form.user_link_url.disabled = true;
		}
		excepts = ['IMAGE', 'TEXT', 'TAG'];	
		enable_child_id(chk_fld_id, document.getElementsByTagName('tr'), excepts);
	}

	function inverter_1() {
		form = document.frm;
		for (i=0; i<form.button_type.length; i++) {	 // 선택된 필드 정보 저장
			if (form.button_type[i].checked) {
				chk_prt = form.button_type[i];
				chk_prt_id = form.button_type[i].id;
				chk_prt_value = form.button_type[i].value;
			}
		}
		switch (chk_prt_value) {
			case '그림' :
				IMAGE.style.display='block';
				TEXT.style.display='none';
				TAG.style.display='none';
			break;
			case '글자' :
				IMAGE.style.display='none';
				TEXT.style.display='block';
				TAG.style.display='none';
			break;
			case '태그' :
				IMAGE.style.display='none';
				TEXT.style.display='none';
				TAG.style.display='block';
			break;
		}
		if (form.pp_link_target.value == '_nw') form.pp_link_nw.disabled = false;
		else form.pp_link_nw.disabled = true;
	}

	function verify_submit() {
		form = document.frm;
		if ((chk_fld.disabled == true) || (chk_fld_value == '')) {
			alert('버튼의 종류를 선택하세요');
			return false;
		}
		if (form.userfile.value == '' && form.pp_img_src.value == '' && form.text_value.value == '' && form.tag_value.value == '') {
			alert('버튼 정보를 설정하세요.');
			return false;
		}
		if (chk_fld_value == 'user' && form.user_link_url.value == '' && form.user_link_page.value == '' && form.user_link_board.value == '') {
			alert('사용자 링크를 입력하세요');
			return false;
		}
		if (chk_fld.value == 'sort' && form.sort_fld_name.value == '') {
			alert('정렬할 필드명을 입력하세요.');
			form.sort_fld_name.focus();
			return false;
		}
		if (chk_fld.value == 'multi_submit' && form.multi_submit_action.value == '') {
			alert('다중 입력 ACTION 속성을 입력하세요.');
			form.multi_submit_action.focus();
			return false;
		}
		form.submit();
	}

	function select_inner_page() {
		form = document.frm;
		form.user_link_board.value = '';
	}

	function select_board_page() {
		form = document.frm;
		if (form.user_link_page.value != '') form.user_link_page.value = '';
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<form method='post'  name='frm' action='table_button_manager.php' enctype='multipart/form-data' onsubmit='verify_submit(); return false;'>
	<input type=hidden name=design_file value=$design_file>
	<input type=hidden name=index value=$index>
	<input type=hidden name=current_line value=$current_line>
	<input type=hidden name=cpn value=$cpn>
	<tr>
		<td>
			$P_form_input
		</td>
	</tr>
	<tr>
		<td>
			$P_form_input_type
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