<?
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
$exp = explode($GLOBALS[DV][dv], $design[$current_line]);

if ($exp[0] == "����Ʈ") $
$page_type = array('I', 'T', 'B', 'J');
$design_file_list = $lib_insiter->design_file_list("import_file", $page_type, "Y", $design_file, "class=designer_select", $exp[1], 'N');
$P_table_input_form = "
	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td height ='40'>������ ������ ����</td>
			<td>
				<table cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td>$design_file_list</td>
						<td width=5></td>
						<td><input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
";
$P_table_input_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_input_form, $IS_input_box_padding, array("title"=>"<b>�ٸ� ������ �ҷ�����</b>"));

$P_table_skin = "
	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td>
				<table cellpadding=0 cellspacing=0 border=0>
					<tr>
						<td>���� ĭ�� �� ��������</td>
						<td width=5></td>
						<td><input type=button value='���� �ֱ�' onclick=\"document.location.href='table_designer_manager.php?design_file=$design_file&cpn=$cpn&index=$index&current_line=$current_line&mode=contents'\" class=designer_button></td>
						<td width=5></td>
						<td><input type=button value='�������ܺγ��� �ֱ�' onclick=\"document.location.href='table_designer_manager.php?design_file=$design_file&cpn=$cpn&index=$index&current_line=$current_line&mode=contents_out'\" class=designer_button></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
";
$P_table_skin = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_skin, $IS_input_box_padding, array("title"=>"<b>��Ų����</b>"));

if ($exp[0] == "��Ŭ���") $include_file = $exp[1];
$P_include = "
	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td height ='40'>���ϸ�(����Ʈ����)</td>
			<td>
				" . $GLOBALS[lib_common]->make_input_box($include_file, "include", "text", "size=40 maxlength=100 class='designer_text'", "") . " ����) ���ϸ�{$GLOBALS[DV][ct2]}������=������,...
			</td>
		</tr>
	</table>
";
$P_include = $lib_insiter->w_get_img_box($IS_thema_window, $P_include, $IS_input_box_padding, array("title"=>"<b>�ܺ����� INCLUDE</b>"));

$P_command = "
	<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td height ='40'>����Է�</td>
			<td>
				" . $GLOBALS[lib_common]->make_input_box($exp[0], "command", "text", "size=40 maxlength=100 class='designer_text'", "") . "
			</td>
		</tr>
	</table>
";
$P_command = $lib_insiter->w_get_img_box($IS_thema, $P_command, $IS_input_box_padding, array("title"=>"<b>��Ÿ��ɻ���</b>"));

include "{$DIRS[designer_root]}include/form_open_close_tag.inc.php";
include "{$DIRS[designer_root]}include/form_blank.inc.php";

$help_msg = "
	����Ʈ �ϴ� ���
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<SCRIPT language='JavaScript1.2'>
<!--
function verify_submit() {
	var form = document.frm;
	if (form.import_file.value == '') {
		alert('����Ʈ�� �������� �����ϼ���');
		form.import_file.focus();
		return;
	}
	form.submit();
}

function verify_submit_1() {
	var form = document.frm_1;
	if (form.include.value == '') {
		alert('���� ��θ� �Է��ϼ���.');
		form.include.focus();
		return;
	}
	form.submit();
}

function verify_submit_2() {
	var form = document.frm_2;
	if (form.command.value == '') {
		alert('����� �Է��ϼ���.');
		form.command.focus();
		return;
	}
	form.submit();
}
//-->
</script>
<body topmargin='0' leftmargin='0' marginwidth=0 marginheight=0 text='#000000'>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<form name='frm' method='post' action='table_designer_manager.php?design_file=$design_file&cpn=$cpn&index=$index&current_line=$current_line&mode=import' onsubmit='verify_submit();return false;'>
	<tr>
		<td>
			$P_table_input_form
		</td>
	</tr>
	<tr>
		<td>
			$P_table_skin
		</td>
	</tr>
	</form>
	<form name='frm_1' method='post' action='table_designer_manager.php?design_file=$design_file&cpn=$cpn&index=$index&current_line=$current_line&mode=include' onsubmit='verify_submit_1(); return false;'>
	<tr>
		<td>
			$P_include
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'>
			<a href='#' onclick='reset()'><img src='{$DIRS[designer_root]}images/bt_repeat.gif' border='0'></a>
		</td>
	</tr>
	</form>
	<form name='frm_2' method='post' action='table_designer_manager.php?design_file=$design_file&cpn=$cpn&index=$index&current_line=$current_line&mode=command' onsubmit='verify_submit_2(); return false;'>
	<tr>
		<td>
			$P_command
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
			<a href='#' onclick='reset()'><img src='{$DIRS[designer_root]}images/bt_repeat.gif' border='0'></a>
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