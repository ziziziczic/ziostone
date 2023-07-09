<?
/*----------------------------------------------------------------------------------
 * 제목 : TCTools '인사이트' 게시판 수정 화면
 * 중요 변수:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
*/
include "header.inc.php";

$board_info = $lib_fix->get_board_info($_GET[board_name]);
if ($_GET[board_name] == '') {
	$board_info[member_info] = "Y";
	$board_info[notice_email] = "N";
	$board_info[notice_sms] = "N";
	$board_info[notice_user_email] = "N";
	$board_info[notice_user_sms] = "N";
	$board_info[filter] = $IS_filter_keyword;
	$board_info[extensions] = $IS_upload_ext;
	$mode = "add";
	$board_info[extensions] = implode(',', $GLOBALS[VI][allow_ext]);
} else {
	$mode = "modify";
	$msg_chg_clip = "(변경시 다시한번 확인)";
	$P_chg_board_name = "
						" . $GLOBALS[lib_common]->make_input_box($board_info[name], "name", "text", "size=5 maxlength='10' class='designer_text' disabled", "") . "
						<input type=checkbox name='chk_name' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">(입력)
	";
	$P_chg_page_name = "
				<tr>
					<td class='input_form_title'>{$IS_icon[form_title]}페이지파일명</td>
					<td class='input_form_value_11px' colspan=3>
						" . $GLOBALS[lib_common]->make_input_box($board_info[list_page], "list_page", "text", "size='12' maxlength='20' class='designer_text' disabled", '', '') . "
						<input type=checkbox name='chk_list_page' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
						" . $GLOBALS[lib_common]->make_input_box($board_info[view_page], "view_page", "text", "size='12' maxlength='20' class='designer_text' disabled", '', '') . "
						<input type=checkbox name='chk_view_page' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
						" . $GLOBALS[lib_common]->make_input_box($board_info[write_page], "write_page", "text", "size='12' maxlength='20' class='designer_text' disabled", '', '') . "
						<input type=checkbox name='chk_write_page' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
						" . $GLOBALS[lib_common]->make_input_box($board_info[modify_page], "modify_page", "text", "size='12' maxlength='20' class='designer_text' disabled", '', '') . "
						<input type=checkbox name='chk_modify_page' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
						" . $GLOBALS[lib_common]->make_input_box($board_info[delete_page], "delete_page", "text", "size='12' maxlength='20' class='designer_text' disabled", '', '') . "
						<input type=checkbox name='chk_delete_page' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
						" . $GLOBALS[lib_common]->make_input_box($board_info[reply_page], "reply_page", "text", "size='12' maxlength='20' class='designer_text' disabled", '', '') . "
						<input type=checkbox name='chk_reply_page' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
					</td>
				</tr>
	";
}

// 게시판 내부디자인 상자
$query = "select name, alias from $DB_TABLES[board_list]";
$result = $GLOBALS[lib_common]->querying($query, "게시판 목록 추출쿼리중 에러");

$option_name = array(":: 기존게시판복사 ::");
$option_value = array('');
while ($board_list_value = mysql_fetch_array($result)) {
	$option_name[] = $board_list_value[alias];
	$option_value[] = $board_list_value[name];
}
$P_clip_board_name = $GLOBALS[lib_common]->make_list_box("clip_board_name", $option_name, $option_value, '', '', "class='designer_select' disabled", "width:130");
$template_list_array = $GLOBALS[lib_common]->get_dir_file_list($DIRS[template]);
$P_template_list = $GLOBALS[lib_common]->get_list_boxs_array($template_list_array, "template_name", '', 'Y', "class=designer_select disabled", ":: 템플릿복사 ::");

$P_skin_files = $lib_insiter->make_skin_file_liist();						// 스킨파일 목록 생성

// 게시판 상위 페이지
if ($mode == "modify") $is_disable_design_file_list = "style='width:130px' disabled";
else  $is_disable_design_file_list = "style='width:130px'";
$parent_design_file_type = array('U');

// 권한설정
$option_name = $option_value = array();
$user_level_list = $lib_insiter->get_level_alias($site_info[user_level_alias]);
$read_perm_array = $user_level_list + array('S'=>"본인게시물만");
$modify_delete_perm_array = array('P'=>"패스워드인증", 'S'=>"본인글만", 'A'=>"관리자만");

while (list($key, $value) = each($user_level_list)) {
	$option_value[] = $key;
	$option_name[] = $value;
}
$option_name[0] = "::읽기::";
$option_value[0] = '8';
$P_perm_read = $GLOBALS[lib_common]->make_list_box("read_perm", $option_name, $option_value, '', $board_info[read_perm], "class='designer_select' style='width:75px'", '');

$option_name[sizeof($option_value)] = "미사용";
$option_value[sizeof($option_value)] = '0';

$option_name[0] = "::쓰기::";
$P_perm_write = $GLOBALS[lib_common]->make_list_box("write_perm", $option_name, $option_value, '', $board_info[write_perm], "class='designer_select' style='width:75px'", '');

$option_name[0] = "::답변::";
$P_perm_reply = $GLOBALS[lib_common]->make_list_box("reply_perm", $option_name, $option_value, '', $board_info[reply_perm], "class='designer_select' style='width:75px'", '');

// 타이틀 유형
if ($board_info[title_type] == '') $board_info[title_type] = 'P';

// 조회수조정
$option_name = $option_value = array();
for($i=1; $i<10; $i++) $option_name[] = $option_value[] = $i;
$P_count_term = $GLOBALS[lib_common]->make_list_box("count_term", $option_name, $option_value, '', $board_info[count_term], "class='designer_select'", '');

// 첨부확장자
$option_name = array("만 허용", "만 제외");
$option_value = array('T', 'M');
$P_extensions_mode = $GLOBALS[lib_common]->make_list_box("extensions_mode", $option_name, $option_value, '', $board_info[extensions_mode], "class='designer_select'", '');

$option_name = array("새파일명(일련번호)저장", "새파일명(시간)저장", "원본명저장");
$option_value = array('N', 'T', 'O');
$P_name_method = $GLOBALS[lib_common]->make_list_box("file_name_method", $option_name, $option_value, '', $board_info[file_name_method], "class='designer_select'", '');

$P_contents_title = "
			<table border='0' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td><font color='#FF6600'><b>게시판속성관리</b> - {$ppb_link[1][0]} Boards</font></td>
					<td>$design_group</td>
					<td align=right>
						<b>[<a href='{$DIRS[designer_root]}page_designer.php?design_file={$board_info[list_page]}&page_type=B'>디자인수정</a>]
						[<a href='{$root}{$site_info[index_file]}?design_file=$board_info[list_page]' target=_blank>미리보기</a>]</b>&nbsp;&nbsp;
					</td>
				</tr>
			</table>
";
$P_contents = "
<script language='javascript'>
<!--
	function verify_submit(form) {
		if (form.alias.value == '') {
			alert('게시판 이름을 입력하세요.');
			form.alias.focus();
			return false;
		}
		form.submit();
	}
	function del_img() {
		form = document.frm;
		form.saved_title_img.value = '';
	}
	function chk_board_style(form, obj) {
		if (obj.value == 'T') {
			form.template_name.disabled = false;
			form.clip_board_name.disabled = true;
		} else {
			form.template_name.disabled = true;
			form.clip_board_name.disabled = false;
		}
	}
	function chg_read_perm() {
		form = document.frm;
		if (form.read_perm.value == 'S' || form.read_perm.value == '') form.read_perm_mode.disabled = true;
		else form.read_perm_mode.disabled = false;
		if (form.write_perm.value == 'S' || form.write_perm.value == '') form.write_perm_mode.disabled = true;
		else form.write_perm_mode.disabled = false;
		if (form.reply_perm.value == 'S' || form.reply_perm.value == '') form.reply_perm_mode.disabled = true;
		else form.reply_perm_mode.disabled = false;
	}
//-->
</script>

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<form name='frm' method='post' action='board_manager.php' onsubmit='return verify_submit(this)' enctype='multipart/form-data'>
	<input type='hidden' name='board_name' value='$_GET[board_name]'>
	<input type='hidden' name='mode' value='$mode'>
	<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	<input type='hidden' name='is_stripslashes' value='N'>
	<tr>
		<td>
			<table border='0' cellpadding='5' cellspacing='1'  width='100%' class=input_form_table>
				<tr>
					<td class='input_form_title' width=17%>{$IS_icon[form_title]}게시판 이름</td>
					<td class='input_form_value_11px' width=30%>
						" . $GLOBALS[lib_common]->make_input_box($board_info[alias], "alias", "text", "size='20' maxlength='100' class='designer_text'", '', '') . "
						$P_chg_board_name
					</td>
					<td class='input_form_title' width=13%>{$IS_icon[form_title]}관리자</td>
					<td class='input_form_value_11px' width=35%>
						<input type='button' value='검색' onclick=\"window.open('{$DIRS[member_root]}sch_member.php?nm_serial_num=admin&search_item=serial_num&search_keyword={$board_info[admin]}', 'sch_member', 'left=10,top=10,width=600,height=550,scrollbars=1,resizable=1').focus()\" class=designer_button>
						" . $GLOBALS[lib_common]->make_input_box($board_info[admin], "admin", "text", "size=10 class='designer_text' readonly", "") . "
						<input type=checkbox name='chk_admin' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'R')\">(입력)
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>
						{$IS_icon[form_title]}타이틀 설정<br>
						{$IS_icon[form_title]}첨부이미지" . $GLOBALS[lib_common]->make_input_box($board_info[title_type], "title_type", "radio", "class='designer_radio'", '', "I") . "<br>
						{$IS_icon[form_title]}인클루드파일" . $GLOBALS[lib_common]->make_input_box($board_info[title_type], "title_type", "radio", "class='designer_radio'", '', "F") . "
					</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box('', "title_img", "file", "size='25' class='designer_text'", '', '') . "
						<br>" . $GLOBALS[lib_common]->make_input_box($board_info[title_img], "saved_title_img", "text", "size=35 maxlength=200 class='designer_text'", '', "width:180") . "
						" . $GLOBALS[lib_common]->make_input_box("삭제", '', "button", "class=designer_button onclick='del_img()'", '', '') . "
						<br>" . $GLOBALS[lib_common]->make_input_box($board_info['include'], "include", "text", "size='45' class='designer_text'", '', '') . "
					</td>
					<td class='input_form_title'>{$IS_icon[form_title]}옵션</td>
					<td class='input_form_value_11px'>
						관리자에게 글등록통보(" . $GLOBALS[lib_common]->make_input_box($board_info['notice_email'], "notice_email", "checkbox", "class='designer_checkbox'", '', "Y") . "Email, 
						" . $GLOBALS[lib_common]->make_input_box($board_info['notice_sms'], "notice_sms", "checkbox", "class='designer_checkbox'", '', "Y") . "SMS)<br>
						질문자에게 답변글통보(" . $GLOBALS[lib_common]->make_input_box($board_info['notice_user_email'], "notice_user_email", "checkbox", "class='designer_checkbox'", '', "Y") . "Email, 
						" . $GLOBALS[lib_common]->make_input_box($board_info['notice_user_sms'], "notice_user_sms", "checkbox", "class='designer_checkbox'", '', "Y") . "SMS)<br>
						글쓰기시 기본정보삽입" . $GLOBALS[lib_common]->make_input_box($board_info['member_info'], "member_info", "checkbox", "class='designer_checkbox'", '', "Y") . ", 
						조회수증가범위 $P_count_term
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>{$IS_icon[form_title]}권한설정</td>
					<td class='input_form_value_11px' colspan=3>
						" . $GLOBALS[lib_common]->get_list_boxs_array($read_perm_array, "read_perm", $board_info[read_perm], 'Y', "class=designer_select onchange='chg_read_perm()'", ":: 읽기 ::") . "
						" . $GLOBALS[lib_common]->get_list_boxs_array($IS_level_mode, "read_perm_mode", $board_info[read_perm_mode], 'N', "class=designer_select") . "
						" . $GLOBALS[lib_common]->get_list_boxs_array($user_level_list, "write_perm", $board_info[write_perm], 'Y', "class=designer_select onchange='chg_read_perm()'", ":: 쓰기 ::") . "
						" . $GLOBALS[lib_common]->get_list_boxs_array($IS_level_mode, "write_perm_mode", $board_info[write_perm_mode], 'N', "class=designer_select") . "
						" . $GLOBALS[lib_common]->get_list_boxs_array($user_level_list, "reply_perm", $board_info[reply_perm], 'Y', "class=designer_select onchange='chg_read_perm()'", ":: 답변 ::") . "
						" . $GLOBALS[lib_common]->get_list_boxs_array($IS_level_mode, "reply_perm_mode", $board_info[reply_perm_mode], 'N', "class=designer_select") . "
						" . $GLOBALS[lib_common]->get_list_boxs_array($modify_delete_perm_array, "modify_perm", $board_info[modify_perm], 'Y', "class=designer_select", ":: 수정 ::") . "
						" . $GLOBALS[lib_common]->get_list_boxs_array($modify_delete_perm_array, "delete_perm", $board_info[delete_perm], 'Y', "class=designer_select", ":: 삭제 ::") . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>{$IS_icon[form_title]}첨부파일</td>
					<td class='input_form_value_11px' colspan=3>
						$P_name_method
						" . $GLOBALS[lib_common]->make_input_box($board_info[extensions], "extensions", "text", "size='60' maxlength='100' class='designer_text'", '', '') . "
						$P_extensions_mode
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>
						{$IS_icon[form_title]}타이틀TAG
						" . $GLOBALS[lib_common]->make_input_box($board_info[title_type], "title_type", "radio", "class='designer_radio'", '', "T") . "
					</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[title_tag], "title_tag", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
					<td class='input_form_title'>{$IS_icon[form_title]}필터링(, 구분)</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[filter], "filter", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>{$IS_icon[form_title]}상단 TAG</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[header], "header", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
					<td class='input_form_title'>{$IS_icon[form_title]}하단 TAG</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[footer], "footer", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>{$IS_icon[form_title]}분류-1 정의<br><span class=11px>저장값;출력이름[줄바꿈]</span></td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[category_1], "category_1", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
					<td class='input_form_title'>{$IS_icon[form_title]}분류-2 정의</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[category_2], "category_2", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>{$IS_icon[form_title]}분류-3 정의</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[category_3], "category_3", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
					<td class='input_form_title'>{$IS_icon[form_title]}분류-4 정의</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[category_4], "category_4", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>{$IS_icon[form_title]}분류-5 정의</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[category_5], "category_5", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
					<td class='input_form_title'>{$IS_icon[form_title]}분류-6 정의</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[category_6], "category_6", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>{$IS_icon[form_title]}글유형정의<br><span class=11px>저장값;출력태그[줄바꿈]</span></td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[type_define], "type_define", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
					<td class='input_form_title'>{$IS_icon[form_title]}검색항목정의<br><span class=11px>필드명;출력이름[줄바꿈]</span></td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box($board_info[search_field], "search_field", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off", "width:100%", '') . "
					</td>
				</tr>
				<tr>
					<td colspan=4 height=30 class='input_form_value_11px'>※ 아래는 게시판 페이지들의 속성을 일괄변경 할 때 사용 합니다..</td>
				</tr>
				<tr>
					<td class='input_form_title' width=17%>{$IS_icon[form_title]}디자인속성</td>
					<td class='input_form_value_11px' colspan=3>
						$P_skin_files
						" . $lib_insiter->make_page_menu_list('', "class='designer_select' style='width:100px'", "page_menu", $page_menu_etc) . "
						$P_template_list<input type=radio name='chk_style' value='T' onclick=\"chk_board_style(this.form, this)\">
						$P_clip_board_name<input type=radio name='chk_style' value='C' onclick=\"chk_board_style(this.form, this)\">
						$msg_chg_clip
					</td>
				</tr>												
				<tr>
					<td class='input_form_title'>{$IS_icon[form_title]}상위페이지</td>
					<td class='input_form_value_11px'>
						" . $lib_insiter->design_file_list("parent_design_file", $parent_design_file_type, "Y", $design_file, $is_disable_design_file_list, '', 'N') . "
					</td>
					<td class='input_form_title'>
						{$IS_icon[form_title]}그룹
						<input type=checkbox name='chk_udf_group' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
					</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box('', "udf_group", "text", "size='30' maxlength='100' class='designer_text' disabled", "width:100%; background:fafafa;", '') . "
					</td>				
				</tr>
				<tr>
					<td class='input_form_title'>
						{$IS_icon[form_title]}BODY 내
						<input type=checkbox name='chk_tag_body_in' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
					</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box('', "tag_body_in", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off disabled", "width:100%; background:fafafa;", '') . "
					</td>
					<td class='input_form_title'>
						{$IS_icon[form_title]}BODY 외
						<input type=checkbox name='chk_tag_body_out' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
					</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box('', "tag_body_out", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off disabled", "width:100%; background:fafafa;", '') . "
					</td>
				</tr>
				<tr>
					<td class='input_form_title'>
						{$IS_icon[form_title]}헤더
						<input type=checkbox name='chk_tag_header' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
					</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box('', "tag_header", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off disabled", "width:100%; background:fafafa;", '') . "
					</td>					
					<td class='input_form_title'>
						{$IS_icon[form_title]}컨텐츠외부
						<input type=checkbox name='chk_tag_contents_out' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
					</td>
					<td class='input_form_value_11px'>
						" . $GLOBALS[lib_common]->make_input_box('', "tag_contents_out", "textarea", "rows=3 cols=30 class='designer_textarea' wrap=off disabled", "width:100%; background:fafafa;", '') . "
					</td>
				</tr>
				$P_chg_page_name
			</table>
		</td>
	</tr>
	<tr>
		<td align=center height=40>
			<input type=submit value='저장하기' class=designer_button>
		</td>
	</tr>
</form>
</table>
<script language='javascript1.2'>
<!--
	document.frm.alias.focus();
	chg_read_perm();
//-->
</script>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>$P_contents_title));
echo($P_contents);
include "footer.inc.php";
?>