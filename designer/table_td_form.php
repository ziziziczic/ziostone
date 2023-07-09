<?
include "header_sub.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);						//	디자인 파일을 불러 한줄씩 배열에 저장한다.
$index_exp = explode("_", $index);
$location = "index=" . $index_exp[0] . "_" . $index_exp[1] . "_" . $index_exp[2];
$line = $lib_fix->search_index($design, "칸", $location);
$exp = explode($GLOBALS[DV][dv],$design[$line[0]]);

$define_property = array("width", "height", "align", "valign", "colspan", "rowspan", "bgcolor", "background");
$td_property = $GLOBALS[lib_common]->parse_property($exp[2], " ", "=", $define_property);
if($td_property[bgcolor] != "") {
	$P_script = "
		var c1 = '$td_property[bgcolor]';
	";
}

$option_name = array();
for ($i=1; $i<=20; $i++) $option_name[] = $i;

$option_name_align = array("기본값", "왼쪽", "가운데", "오른쪽");
$option_value_align = array("", "left", "center", "right");

$option_name_colspan = array();
for ($i=1; $i<=20; $i++) $option_name_colspan[] = $i;

$option_name_valign = array("기본값", "상단", "중앙", "하단");
$option_value_valign = array("", "top", "middle", "bottom");

$option_name_rowspan = array();
for ($i=1; $i<=20; $i++) $option_name_rowspan[] = $i;

include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";

$P_form_input_td_insert = "
						<table width='100%' border='0' cellspacing='3' cellpadding='0'>
							<tr>
								<td colspan='6' align='right'>
									<a href=\"javascript:make_work('make')\">[삽입]</a>
									<a href=\"javascript:verify('table_td_manager.php?design_file=$design_file&index=$index&mode=delete_vlaue', 'delete_vlaue')\">[내용만삭제]</a>
									<a href=\"javascript:verify('table_td_manager.php?design_file=$design_file&index=$index&mode=delete', 'delete')\">[칸삭제]</a>
									<hr size='1'>
								</td>
							</tr>
							<tr> 
								<td width=80>왼쪽삽입</td>
								<td width=80>
									" . $GLOBALS[lib_common]->make_input_box("left", "insert_location", "radio", "disabled", '', "left") . "
								</td>
								<td width=80>오른쪽삽입</td>
								<td width=80>
									" . $GLOBALS[lib_common]->make_input_box("right", "insert_location", "radio", "disabled", '', '') . "
								</td>
								<td width=60>칸개수</td>
								<td>
									" . $GLOBALS[lib_common]->make_list_box("td_num", $option_name, $option_name, '', $align, "disabled class=designer_select", '') . "  칸
								</td>
							</tr>
						</table>
";
$P_form_input_td_insert = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input_td_insert, $IS_input_box_padding, array("title"=>"칸(TD) 삽입속성"));

$P_form_input_td_basic = "
						<table width='100%' border='0' cellspacing='3' cellpadding='0'>
							<tr>
								<td width=60>동시적용</td>
								<td colspan=5>
									" . $GLOBALS[lib_common]->make_input_box("", "select_modify_row", "checkbox", "class='designer_checkbox'", '', "tr") . "가로줄전체&nbsp;&nbsp; 
									" . $GLOBALS[lib_common]->make_input_box("", "select_modify_col", "checkbox", "class='designer_checkbox'", '', "tr") . "세로줄전체&nbsp;&nbsp;
									" . $GLOBALS[lib_common]->make_input_box("", "select_modify_alltd", "checkbox", "class='designer_checkbox'", '', "td") . "테이블전체칸
								</td>
							</tr>
							<tr><td colspan='6'><hr size=1></td></tr>						
							<tr> 
								<td>너비</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($td_property[width], "width", "text", "size=4 maxlength=4 class='designer_text'", '') . "
								</td>
								<td width=60>가로정렬</td>
								<td width=60>
									" . $GLOBALS[lib_common]->make_list_box("align", $option_name_align, $option_value_align, '', $td_property[align], "class=designer_select", '') . "
								</td>
								<td width=50>가로병합</td>
								<td>
									" . $GLOBALS[lib_common]->make_list_box("colspan", $option_name_colspan, $option_name_colspan, '', $td_property[colspan], "class=designer_select", '') . "  칸
								</td>								
							</tr>
							<tr> 
								<td>높이</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($td_property[height], "height", "text", "size=4 maxlength=4 class='designer_text'", '') . "
								</td>
								<td>세로정렬</td>
								<td>
									" . $GLOBALS[lib_common]->make_list_box("valign", $option_name_valign, $option_value_valign, '', $td_property[valign], "class=designer_select", '') . "
								</td>
								<td>세로병합</td>
								<td>
									" . $GLOBALS[lib_common]->make_list_box("rowspan", $option_name_rowspan, $option_name_rowspan, '', $td_property[rowspan], "class=designer_select", '') . "  칸
								</td>
								<tr> 
								<td>배경이미지</td>
								<td colspan=3><input type='file' size='20' name='background' class='designer_text'></td>
								<td>배경색</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($td_property[bgcolor], "bgcolor", "text", "size='5' maxlength='7' class='designer_text'", '') . "
									<script language='javascript'>
										document.write('<input type=button name=bcolor value=click class=designer_button style=background-color:'+c1+'; border-color:white; height=18px onclick=\"callColorPicker(-50, -50, 1, event, \'frm.bcolor\', \'frm.bgcolor\')\">');
									</script>
								</td>
							</tr>
							<tr>
								<td colspan=2>설정된배경이미지</td>
								<td colspan=4>
									<input type='button' value='삭제' onclick='del_image()' style='font-size:11'> <input type='text' name='saved_background' value='$td_property[background]' size='35' class='designer_text'>
								</td>
							</tr>
							</tr>
							<tr> 
								<td>기타</td>
								<td colspan=5>
									" . $GLOBALS[lib_common]->make_input_box($td_property[etc], "etc", "text", "size=57 class='designer_text'", '') . "
								</td>
							</tr>
						</table>
";
$P_form_input_td_basic = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input_td_basic, $IS_input_box_padding, array("title"=>"칸(TD) 기본속성"));

$help_msg = "
	칸편집 화면
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
				form.insert_location[0].disabled = false;
				form.insert_location[1].disabled = false;
				form.td_num.disabled = false;
				form.select_modify_row.disabled = true;
				form.select_modify_col.disabled = true;
				form.select_modify_alltd.disabled = true;
				form.colspan.disabled = true;
				form.rowspan.disabled = true;

				form.width.value = '';
				form.height.value = '';
				form.align.value = '';
				form.valign.value = '';
				form.bgcolor.value = '';
				form.etc.value = '';
				form.style.value = '';
				form.saved_background.value = '';
			break;
		}
	}

	function verify(url, mode) {
		var msg;
		form = document.frm;
		form.mode.value = mode;
		if (mode == 'delete') msg = '선택하신 칸 전체를 삭제합니다.';
		else if (mode == 'delete_vlaue') msg = '선택하신 칸안의 내용만 삭제합니다.';
		if (confirm(msg)) {
			document.location.href = url;
		}
	}

	function del_image() {
		var form = eval(document.frm);
		form.saved_background.value = '';
		return;
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<form method='post'  name='frm' action='table_td_manager.php?design_file=$design_file&index=$index' enctype='multipart/form-data'>
	<input type=hidden name=mode value=modify>
	<tr>
		<td>
			$P_form_input_td_insert
		</td>
	</tr>
	<tr>
		<td>
			$P_form_input_td_basic
		</td>
	</tr>
	<tr>
		<td>
			$P_form_open_close_tag
		</td>
	</tr>
	<tr>
		<td height='20' align='right' valign='top'>
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