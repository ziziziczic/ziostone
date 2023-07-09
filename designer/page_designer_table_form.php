<?
require "header_sub.inc.php";

if ($index == '') {	// 페이지 디자이너인 경우
	 $default_mode = "make";
	 $default_disabled = "";
} else {						// 테이블 디자이너인 경우
	$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
	$index_exp = explode("_", $index);
	$location = "index=" . $index_exp[0];
	$line = $lib_fix->search_index($design, "테이블", $location);
	$exp = explode($GLOBALS[DV][dv], $design[$line[0]]);
	$define_property = array("cellpadding", "cellspacing", "align", "border", "bgcolor", "width", "height", "background");
	$table_property = $GLOBALS[lib_common]->parse_property($exp[2], " ", "=", $define_property);
	$default_mode = "modify";
	$default_disabled = " disabled";
}

// 기본속성
for ($i=1; $i<=50; $i++) $option_name[] = $i;
$P_table_input_form = "
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
";
if ($index != '') {
	$P_table_input_form .= "
							<tr>
								<td colspan=8 align=right valign=bottom>
									<a href=\"javascript:make_work('make')\">[삽입]</a>
									<a href=\"javascript:verify('table_manager.php?design_file=$design_file&index=$index&mode=delete', 'delete')\">[삭제]</a>
									<a href=\"javascript:verify('table_manager.php?design_file=$design_file&index=$index&mode=copy', 'copy')\">[복사]</a>
									<a href=\"javascript:verify('table_manager.php?design_file=$design_file&index=$index&mode=cut', 'cut')\">[잘라내기]</a>
									<a href=\"javascript:verify('table_manager.php?design_file=$design_file&index=$index&mode=paste&current_line=$current_line', 'paste')\">[붙여넣기]</a>
								</td>
							</tr>
							<tr><td colspan=8><hr size=1></td></tr>
	";
}
$P_table_input_form .= "
							<tr> 
								<td>줄</td>
								<td>
									" . $GLOBALS[lib_common]->make_list_box("row", $option_name, $option_name, "", "", "class=designer_select{$default_disabled}", "") . "
								</td>
								<td>칸</td>
								<td>
									" . $GLOBALS[lib_common]->make_list_box("col", $option_name, $option_name, "", "", "class=designer_select{$default_disabled}", "") . "
								</td>
								<td>너비</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($table_property[width], "width", "text", "size=3 maxlength='4' class='designer_text'", $style) . "
								</td>
								<td>높이</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($table_property[height], "height", "text", "size=3 maxlength='4' class='designer_text'", $style) . "
								</td>
							</tr>
							<tr> 
								<td>선두께</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($table_property[border], "border", "text", "size=3 maxlength='4' class='designer_text'", $style) . "
								</td>
								<td>안여백</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($table_property[cellpadding], "cellpadding", "text", "size=3 maxlength='4' class='designer_text'", $style) . "
								</td>
								<td>칸간격</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($table_property[cellspacing], "cellspacing", "text", "size=3 maxlength='4' class='designer_text'", $style) . "
								</td>
								<td>정렬</td>
								<td>
";
$option_name = array("기본값", "왼쪽", "가운데", "오른쪽");
$option_value = array("", "left", "center", "right");
$P_table_input_form .= "
									" . $GLOBALS[lib_common]->make_list_box("align", $option_name, $option_value, "", $table_property[align], "class=designer_select", "") . "
								</td>
							</tr>
							<tr> 
								<td>배경</td>
								<td colspan=5><input type='file' size='23' name='background' class='designer_text'></td>
								<td>배경색</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($table_property[bgcolor], "bgcolor", "text", "size=7 maxlength='7' class='designer_text'", $style) . "
									<script language='javascript'>
										document.write(\"<input type=button name=bcolor value=click style=background-color:\"+c1+\";border-color:white;height=18px class=designer_button onclick=callColorPicker(-50,-50,1,event,'frm.bcolor','frm.bgcolor')>\");
									</script>
								</td>
							</tr>
							<tr>
								<td colspan=2>설정된이미지</td>
								<td colspan=6>
									<input type='button' value='삭제' onclick='del_image()' style='font-size:11'> <input type='text' name='saved_background' value='$table_property[background]' size='35' class='designer_text'>
								</td>
							</tr>
							<tr> 
								<td>기타</td>
								<td colspan=7>
									" . $GLOBALS[lib_common]->make_input_box($table_property[etc], "etc", "text", "size=65 class='designer_text'", $style) . "
								</td>
							</tr>
						</table>
";
$P_table_input_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_input_form, $IS_input_box_padding, array("title"=>"<b>표(TABLE) 관리</b>"));

$table_skin_dir = "{$DIRS[designer_root]}images/box/";
$option_name = array(":: 스킨을 선택하세요 ::");
$option_value = array('');

if ($handle = opendir($table_skin_dir)) {
	while (false !== ($file = readdir($handle))) { 
		if ($file != '.' && $file != ".." && substr($file, -4) != ".bak") {
			$option_name[] = $file;
			$option_value[] = $file;
		}
	}
	closedir($handle);
}

if ($exp[13] != '') {
	$table_skin_info = explode($GLOBALS[DV][ct4], $exp[13]);
}
$P_table_skin_form = "
<table>
	<tr>
		<td>파일선택</td>
		<td width=10></td>
		<td>
			" . $GLOBALS[lib_common]->make_list_box("table_skin_dir", $option_name, $option_value, '', $table_skin_info[0], "class='designer_select'") . "
		</td>
	</tr>
	<tr>
		<td>타이틀입력</td>
		<td width=10></td>
		<td>
			" . $GLOBALS[lib_common]->make_input_box($table_skin_info[1], "table_skin_title", "text", "size=65 class='designer_text'", $style) . "
		</td>
	</tr>	
	<tr>
		<td>안쪽여백</td>
		<td width=10></td>
		<td>
			" . $GLOBALS[lib_common]->make_input_box($table_skin_info[2], "table_skin_padding", "text", "size=10 class='designer_text'", $style) . "
		</td>
	</tr>
</table>
";
$P_table_skin_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_skin_form, $IS_input_box_padding, array("title"=>"<b>스킨선택</b>"));

if($table_property[bgcolor] != "") {
	$P_script = "
		c1 = '$table_property[bgcolor]';
	";
}

include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";

$help_msg = "
	버튼삽입화면
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--
	$P_script
	var msg, c1;
	function del_image() {
		var form = eval(document.frm);
		form.saved_background.value = '';
		return;
	}

	function make_work(works) {
		var form = document.frm;
		switch (works) {
			case 'make' :
				form.mode.value = 'make';
				form.row.disabled = false;
				form.col.disabled = false;
				form.width.value = '';
				form.height.value = '';
				form.border.value = '';
				form.cellpadding.value = '';
				form.cellspacing.value = '';
				form.align.value = '';
				form.background.value = '';
				form.bgcolor.value = '';
				form.etc.value = '';
				form.style.value = '';
				form.saved_background.value = '';
				form.tag_open.value = '';
				form.tag_close.value = '';
			break;
		}
	}
	function verify(url, mode) {
		var msg;
		form = document.frm;
		form.mode.value = mode;
		if (mode == 'delete') msg = '선택하신 칸의 표 전체를 삭제합니다.';
		if (mode == 'copy') msg = '선택하신 칸의 표 전체를 클립보드에 복사합니다. 복사한 표는 다른 표에 붙여 넣기 할 수 있습니다.';
		if (mode == 'cut') msg = '선택하신 칸의 표 전체를 잘라냅니다. 잘라낸 표는 다른 표에 붙여 넣기 할 수 있습니다.';
		if (mode == 'paste') msg = '클립보드에 있는 표를 붙여 넣기 합니다.';
		if (mode == 'delete_form') msg = '표에 설정된 폼기능(게시판, 로그인등)을 삭제합니다. 폼기능을 삭제하면 테이블 안의 내용이 제대로 보이지 않을 수도 있습니다.';
		if (confirm(msg)) {
			document.location.href = url;
		}
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<form method='post'  name='frm' action='table_manager.php?design_file=$design_file&index=$index&current_line=$current_line' onsubmit='this.submit(); return false;' enctype='multipart/form-data'>
	<tr>
		<td>
			$P_table_input_form					
		</td>
	</tr>
	<tr>
		<td>
			$P_form_open_close_tag
		</td>
	</tr>
	<tr>
		<td>
			$P_table_skin_form
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='hidden' name='mode' value='$default_mode'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'>
			<a href='javascript:document.frm.reset()'><img src='{$DIRS[designer_root]}images/bt_repeat.gif' border='0'></a>
		</td>
	</tr>
	</form>
	<tr>
		<td>
			$P_table_form_help
		</td>
	</tr>
</table>
");
include "footer_sub.inc.php";
?>