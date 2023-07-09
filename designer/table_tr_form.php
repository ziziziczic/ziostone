<?
require "header_sub.inc.php";

$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);						//	디자인 파일을 불러 한줄씩 배열에 저장한다.
$index_exp = explode("_", $index);
$location = "index=" . $index_exp[0] . "_" . $index_exp[1];
$line = $lib_fix->search_index($design, "줄", $location);
$exp = explode($GLOBALS[DV][dv],$design[$line[0]]);

$define_property = array("width", "height", "align", "valign", "bgcolor");
$tr_property = $GLOBALS[lib_common]->parse_property($exp[2], " ", "=", $define_property);

if($tr_property[bgcolor] != "") {
	$P_script = "
		var c1 = '$tr_property[bgcolor]';
	";
}

$option_name = array();
for ($i=1; $i<=20; $i++) $option_name[] = $i;

$P_form_input_insert = "
						<table width='98%' border='0' cellspacing='3' cellpadding='0'>
							<tr>
								<td colspan='6' align='right'>
									<a href=\"javascript:make_work('make')\">[삽입]</a>
									<a href=\"javascript:verify('table_tr_manager.php?design_file=$design_file&index=$index&mode=delete&delete_line=row', 'delete')\">[행삭제]</a>
									<a href=\"javascript:verify('table_tr_manager.php?design_file=$design_file&index=$index&mode=delete&delete_line=col', 'delete')\">[열삭제]</a>
									<hr size='1'>
								</td>
							</tr>
							<tr> 
								<td width=70>가로줄삽입</td>
								<td width=80>
									" . $GLOBALS[lib_common]->make_input_box("row", "insert_line", "radio", "checked disabled", "", "row") . "
								</td>
								<td width=70>왼쪽(위쪽)</td>
								<td width=80>
									" . $GLOBALS[lib_common]->make_input_box("left", "insert_location", "radio", "checked disabled", "", "left") . "
								</td>
								<td width=60>줄개수</td>
								<td>
									" . $GLOBALS[lib_common]->make_list_box("row", $option_name, $option_name, "", $align, "disabled class=designer_select", "") . " 줄
								</td>
							</tr>
							<tr> 
								<td>세로줄삽입</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box("", "insert_line", "radio", "disabled", "", "col") . "
								</td>
								<td>오른쪽(아래쪽)</td>
								<td colspan=3>
									" . $GLOBALS[lib_common]->make_input_box("", "insert_location", "radio", "disabled", "", "right") . "
								</td>
							</tr>
						</table>
";
$P_form_input_insert = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input_insert, $IS_input_box_padding, array("title"=>"줄(TR) 삽입속성"));

$option_name_align = array("기본값", "왼쪽", "가운데", "오른쪽");
$option_value_align = array("", "left", "center", "right");

$option_name_valign = array("기본값", "상단", "중앙", "하단");
$option_value_valign = array("", "top", "middle", "bottom");

$P_form_input_basic = "
						<table width='98%' border='0' cellspacing='3' cellpadding='0'>
							<tr> 
								<td width=70>너비</td>
								<td width=80>
									" . $GLOBALS[lib_common]->make_input_box($tr_property[width], "width", "text", "size=4 maxlength=4 class='designer_text'", "") . "
								</td>
								<td width=70>가로정렬</td>
								<td width=80>
									" . $GLOBALS[lib_common]->make_list_box("align", $option_name_align, $option_value_align, "", $tr_property[align], "class=designer_select", "") . "
								</td>
								<td width=50>배경색</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($tr_property[bgcolor], "bgcolor", "text", "size='7' maxlength='7' class='designer_text'", "") . "
									<script language='javascript'>
										document.write('<input type=button name=bcolor value=click class=designer_button style=background-color:'+c1+'; border-color:white; height=18px onclick=\"callColorPicker(-50, -50, 1, event, \'frm.bcolor\', \'frm.bgcolor\')\">');
									</script>									
								</td>
							</tr>
							<tr> 
								<td>높이</td>
								<td>
									" . $GLOBALS[lib_common]->make_input_box($tr_property[height], "height", "text", "size=4 maxlength=4 class='designer_text'", "") . "
								</td>
								<td>세로정렬</td>
								<td>
									" . $GLOBALS[lib_common]->make_list_box("valign", $option_name_valign, $option_value_valign, "", $tr_property[valign], "class=designer_select", "") . "
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr> 
								<td>기타</td>
								<td colspan=5>
									" . $GLOBALS[lib_common]->make_input_box($tr_property[etc], "etc", "text", "size=57 class='designer_text'", "") . "
								</td>
							</tr>
						</table>
";
$P_form_input_basic = $lib_insiter->w_get_img_box($IS_thema_window, $P_form_input_basic, $IS_input_box_padding, array("title"=>"줄(TR) 기본속성"));


$help_msg = "
	줄 편집 화면
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
				form.insert_line[0].disabled = false;
				form.insert_line[1].disabled = false;
				form.insert_location[0].disabled = false;
				form.insert_location[1].disabled = false;
				form.row.disabled = false;
				form.width.value = '';
				form.height.value = '';
				form.align.value = '';
				form.valign.value = '';
				form.bgcolor.value = '';
				form.etc.value = '';
			break;
		}
	}

	function verify(url, mode) {
		var msg;
		form = document.frm;
		form.mode.value = mode;
		if (mode == 'delete') msg = '선택하신 칸의 행 전체를 삭제합니다.';
		if (confirm(msg)) {
			document.location.href = url;
		}
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<form method='post'  name='frm' action='table_tr_manager.php?design_file=$design_file&index=$index' enctype='multipart/form-data'>
	<input type=hidden name=mode value=modify>
	<tr>
		<td>
			$P_form_input_insert
		</td>
	</tr>
	<tr>
		<td>
			$P_form_input_basic
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