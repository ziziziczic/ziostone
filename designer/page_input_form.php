<?
/*----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
*/
include "header_sub.inc.php";

if ($site_page_info[serial_num] == '') {
	$default_page_type = $_GET[view_page_type];
	$mode = "add";
} else {
	$default_page_type = $site_page_info[type];
	$mode = "modify";
	$P_chg_file_name = "
							<tr> 
								<td class='input_form_title'>{$IS_icon[form_title]}파일명변경</td>
								<td class=input_form_value_11px colspan=3>
									" . $GLOBALS[lib_common]->make_input_box($site_page_info[file_name], "file_name", "text", "size='30' maxlength='20' class='designer_text' disabled", '', '') . "
									<input type=checkbox name='chk_file_name' value='Y' onclick=\"chk_box_enable(this.form, this, 4, 'D')\">
								</td>
							</tr>
				
	";
}

// 권한입력상자
$option_name = $option_value = '';
$user_level_list = $lib_insiter->get_level_alias($site_info[user_level_alias]);
while (list($key, $value) = each($user_level_list)) {
	$option_value[] = $key;
	$option_name[] = $value;
}
$P_page_level = $GLOBALS[lib_common]->make_list_box("pageViewLevel", $option_name, $option_value, "", $site_page_info[view_level], "class='designer_select'", '');

if ($site_page_info[view_level_mode] == '') $T_view_level_mode = 'U';
else $T_view_level_mode = $site_page_info[view_level_mode];
$option_name = array("이상", "이하", "만");
$option_value = array('U', 'L', 'E');
$P_page_level_method = $GLOBALS[lib_common]->make_list_box("page_view_level_mode", $option_name, $option_value, '', $T_view_level_mode, "class='designer_select'", '');

// 내용보호
$item_define = "L;왼쪽클릭\nR;오른쪽클릭\nC;Ctrl\nA;Alt";
$P_page_block = $lib_insiter->make_multi_input_box("checkbox", "page_lock", $item_define, $site_page_info[page_lock], ' ', "class=designer_checkbox");

// 템플릿
$template_list_array = $GLOBALS[lib_common]->get_dir_file_list($DIRS[template]);
$template_file_list_array = array();
while (list($key, $value) = each($template_list_array)) {
	$T_list = $GLOBALS[lib_common]->get_dir_file_list($DIRS[template] . $key, array("resource"));
	$template_file_list_array[$key] = $T_list;
}

// 네비게이션 모드 (페이지명+링크, 사용자입력, 페이지명만, 노출안함)
$navi_mode_array = array('A'=>"페이지이름+링크", 'B'=>"사용자입력", 'C'=>"페이지이름만", 'D'=>"노출안함");

// 서비스 종류 선택상자 설정
$property = array(
	"name_1"=>"template_name",
	"property_1"=>"class=designer_select style='width:110px' disabled",
	"default_value_1"=>'',
	"name_2"=>"template_file_name",
	"property_2"=>"class=designer_select style='width:110px' disabled",
	"default_value_2"=>'',
	"default_title_1"=>":: 템플릿 ::",
	"default_title_2"=>":: 파일 ::"
);
$P_item_codes = $GLOBALS[lib_common]->get_item_select_box($template_list_array, $template_file_list_array, $property);


$P_contents = "
<script language='javascript'>
<!--
	function verify_submit(form) {
		if (form.design_name.value == '') {
			alert('페이지 이름을 입력하세요');
			document.design_name.design_name.focus();
			return false;
		}	
	}
	function chk_page_style(form, obj) {
		if (obj.value == 'T') {
			form.template_name.disabled = false;
			form.template_file_name.disabled = false;
			form.design_file_copy.disabled = true;
		} else {
			form.template_name.disabled = true;
			form.template_file_name.disabled = true;
			form.design_file_copy.disabled = false;
		}
	}
	function chg_navi_mode() {
		form = document.design_name;
		obj = form.navi_mode;
		switch (obj.value) {
			case 'B' :
				form.navi_property.disabled = false;
				form.navi_property.focus();
				form.navi_property.style.background = '#FFFFFF';
			break;
			default :
				form.navi_property.disabled = true;
				form.navi_property.style.background = '#FAFAFA';
			break;
		}
	}
//-->
</script>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
	<form name='design_name' method='post' action='page_manager.php' onsubmit='return verify_submit(this);'>
	<input type='hidden' name='design_file_parent' value='$_GET[parent_design_file]'>
	<input type='hidden' name='mode' value='$mode'>
	<input type='hidden' name='serial_num' value='$site_page_info[serial_num]'>
	<input type='hidden' name='design_file' value='$site_page_info[file_name]'>
	<input type='hidden' name='where' value='$_GET[where]'>
	<input type='hidden' name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	<input type='hidden' name='is_stripslashes' value='N'>
	<tr>
		<td>
			<table width='100%' border='0' cellpadding='0' cellspacing='0'>
				<tr> 
					<td align='center'> 
						<table border=0 cellpadding=5 cellspacing=1 width='100%' class=input_form_table>
							<tr> 
								<td width=80 class='input_form_title'>{$IS_icon[form_title]}분류</td>
								<td width=230 class=input_form_value_11px>
									" . $GLOBALS[lib_common]->get_list_boxs_array($GLOBALS[VI][page_type_array], "page_type", $default_page_type, 'N', "class=designer_select") . "
								</td>
								<td width=80 class='input_form_title'>{$IS_icon[form_title]}이름</td>
								<td class=input_form_value_11px>
									" . $GLOBALS[lib_common]->make_input_box($site_page_info[name], "design_name", "text", "size='30' maxlength='30' class='designer_text'", $style, "") . "
									$P_chg_page_name
								</td>
							</tr>
							<tr> 
								<td class='input_form_title'>{$IS_icon[form_title]}스킨</td>
								<td class=input_form_value_11px>
									" . $lib_insiter->make_skin_file_liist() . "
								</td>
								<td class='input_form_title'>{$IS_icon[form_title]}열람권한</td>
								<td class=input_form_value_11px>
									$P_page_level
									$P_page_level_method
								</td>
							</tr>
							<tr> 
								<td class='input_form_title'>{$IS_icon[form_title]}소속메뉴</td>
								<td class=input_form_value_11px>
									" . $lib_insiter->make_page_menu_list($site_page_info[menu], "class='designer_select'") . "
								</td>
								<td class='input_form_title'>{$IS_icon[form_title]}그룹명</td>
								<td class=input_form_value_11px>
									" . $GLOBALS[lib_common]->make_input_box($site_page_info[udf_group], "udf_group", "text", "size='15' maxlength='60' class='designer_text'", '', "") . " ( ; 사용불가)
								</td>
							</tr>
							<tr> 
								<td class='input_form_title'>{$IS_icon[form_title]}네비게이션</td>
								<td class=input_form_value_11px>
									" . $GLOBALS[lib_common]->get_list_boxs_array($navi_mode_array, "navi_mode", $site_page_info[navi_mode], 'N', "style='width:110px' class=designer_select onchange='chg_navi_mode()'") . "
									" . $GLOBALS[lib_common]->make_input_box($site_page_info[navi_property], "navi_property", "text", "size='18' maxlength='60' class='designer_text'", '', "") . "									
								</td>
								<td class='input_form_title'>{$IS_icon[form_title]}업로드경로</td>
								<td class=input_form_value_11px>
									" . $GLOBALS[lib_common]->make_input_box($site_page_info[default_file_dir], "default_file_dir", "text", "size='40' maxlength='60' class='designer_text'", '', "") . "
								</td>
							</tr>
							<tr> 
								<td class='input_form_title'>{$IS_icon[form_title]}내용보호</td>
								<td class=input_form_value_11px>
									$P_page_block
								</td>
								<td rowspan=2 class='input_form_title'>{$IS_icon[form_title]}에러문구</td>
								<td rowspan=2 height=100% class=input_form_value_11px>
									" . $GLOBALS[lib_common]->make_input_box($site_page_info[perm_err_msg], "perm_err_msg", "textarea", "class='designer_textarea'", "width=100%;height=100%") . "
								</td>
							</tr>
							<tr> 
								<td class='input_form_title'>{$IS_icon[form_title]}에러이동</td>
								<td class=input_form_value_11px>
									" . $GLOBALS[lib_common]->make_input_box($site_page_info[view_err_page], "view_err_page", "text", "size='30' maxlength='60' class='designer_text'", '', "") . "
								</td>
							</tr>
							<tr> 
								<td class='input_form_title'>{$IS_icon[form_title]}복사 <input type=radio name='chk_style' value='C' onclick=\"chk_page_style(this.form, this)\"></td>
								<td class=input_form_value_11px>
									" . $lib_insiter->design_file_list("design_file_copy", '', "Y", '', "class=designer_select style='width:150px' disabled", '', 'N') . "									
								</td>
								<td class='input_form_title'>{$IS_icon[form_title]}템플릿 <input type=radio name='chk_style' value='T' onclick=\"chk_page_style(this.form, this)\"></td>
								<td class=input_form_value_11px>
									{$P_item_codes[0]} {$P_item_codes[1]}{$P_item_codes[2]}
								</td>
							</tr>
							$P_chg_file_name
							<tr>
								<td colspan=4 align=right class=input_form_value_11px height=30>
									<table border='0' cellpadding='3' cellspacing='0'>
										<tr> 
											<td><input type='image' src='{$DIRS[designer_root]}images/bt_save.gif' width='38' height='20' border='0'></td>
											<td><a href='#' onclick='reset()'><img src='{$DIRS[designer_root]}images/bt_repeat.gif' width='38' height='20' border='0'></a></td>
											<td><a href='javascript:self.close()'><img src='{$DIRS[designer_root]}images/bt_close.gif' width='38' height='20' border='0'></a></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</form>
</table>
";

$P_contents = $lib_insiter->w_get_img_box($IS_thema_window, $P_contents, $IS_input_box_padding, array("title"=>"<b>페이지속성입력</b>"));

$help_msg = "
네비게이션 : 네비게이션 강제설정 (예 : 회사소개 > 사업분야..) / 링크 및 스타일도 함께 정의 할 수 있음.<br>
소속메뉴, 그룹명 : 출력제한 설정을 해 둔 부분이 보일 수 있도록 상황에 맞게 지정.<br>
업로드경로 : 이미지 또는 플래시파일등을 첨부시 업로드 되는 경로 지정<br>
에러이동, 문구 : 열람권한 오류시, 이동할 페이지 및 메시지<br>
복사 : 다른 디자인 파일의 내용 및 헤더, 바디 태그등을 불러옵니다. <font color=red>(기존 내용이 삭제되니 주의하세요)</font><br>
템플릿 : 템플릿 파일의 내용 및 헤더, 바디 태그 등을 불러옵니다. <font color=red>(기존 내용이 삭제되니 주의하세요)</font>
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>$P_contents</td>
	</tr>
	<tr><td height=10></td></tr>
	<tr>
		<td>$P_table_form_help</td>
	</tr>
</table>
<script>chg_navi_mode()</script>
");
include "footer_sub.inc.php";
?>