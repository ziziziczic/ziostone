<?
require "header_sub.inc.php";

$option_name = array(":: ���� ::");
$option_value = array('');
$template_names = array();
if ($handle = opendir($DIRS[template])) {
	while (false !== ($file = readdir($handle))) { 
		if ($file != '.' && $file != "..") {
			$option_name[] = $option_value[] = $file;
			$template_names[] = "'{$file}'";
		}
	}
	closedir($handle);
	$template_names_str = '[' . implode(',', $template_names) . ']';
}

if ($_GET[board_name] != '') {
	$board_info = $GLOBALS[lib_common]->get_data($DB_TABLES[board_list], "name", $_GET[board_name]);
	$P_form_title = "<b>{$board_info[alias]} �Խ����� ���ø����� �����</b>";
	$P_hidden = "<input type=hidden name=board_name value='{$_GET[board_name]}'>";
	$T_action = "board_manager.php";
} else {
	$design_file_info = $GLOBALS[lib_common]->get_data($DB_TABLES[design_files], "file_name", $_GET[design_file]);
	$P_form_resource_file_name = "
		<tr>
			<td class='input_form_title'>{$IS_icon[form_title]}�������ø�</td>
			<td class='input_form_value_11px'>
				" . $GLOBALS[lib_common]->make_list_box("selected_template_name", $option_name, $option_value, '', '', "onchange=\"select_template(this.form, this)\" class=designer_select") . "
			</td>
		</tr>
		<tr>
			<td class='input_form_title'>{$IS_icon[form_title]}���������ϸ�</td>
			<td class='input_form_value_11px'>
				" . $GLOBALS[lib_common]->make_input_box('', "template_file_name", "text", "size=15 class='designer_text'", $style) . " <b>.php</b> (����, ����, _ �� ��밡���մϴ�)
			</td>
		</tr>
	";
	$P_form_title = "<b>{$design_file_info[name]} �������� ���ø����� �����</b>";
	$P_hidden = "<input type=hidden name=design_file_name value='{$_GET[design_file_name]}'>";
	$T_action = "page_manager.php";
}

$dup_array = array('D'=>"����", 'C'=>"���ϸ���", 'O'=>"������");

$P_table_form = "
<table border='0' cellpadding='5' cellspacing='1'  width='100%' class=input_form_table>
	<tr>
		<td width=130 class='input_form_title'>{$IS_icon[form_title]} �������</td>
		<td class='input_form_value_11px'>
		". substr($DIRS[template], 2) . "���ø��̸�
		</td>
	</tr>
	<tr>
		<td class='input_form_title'>{$IS_icon[form_title]}���ø��̸�</td>
		<td class='input_form_value_11px'>
			" . $GLOBALS[lib_common]->make_input_box('', "template_name", "text", "size=25 class='designer_text'", $style) . " (����, ����, _ �� ��밡���մϴ�)
		</td>
	</tr>	
	<tr>
		<td class='input_form_title'>{$IS_icon[form_title]}���ҽ����ϸ��ߺ���</td>
		<td class='input_form_value_11px'>
			" . $GLOBALS[lib_common]->get_radio_array($dup_array, "dub_method_resource", 'D', "class=designer_radio", ' ') . "
		</td>
	</tr>
	$P_form_resource_file_name
</table>
";
$P_table_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_form, $IS_input_box_padding, array("title"=>$P_form_title));


$help_msg = "
	������ ���ø��� �Խ����� ���鶧�� �������� ���鶧 �ٷ� Ȱ�� �� �� �ֽ��ϴ�.<br>
	���ø� ���丮�� �ٸ� �λ����� ���ø� ���丮�� �Ű� ����� �� �ֽ��ϴ�.
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript1.2'>
<!--
	function find_same_name(find_name) {
		template_list = $template_names_str;
		for(var i=0; i<template_list.length; i++) {
			if (template_list[i] == find_name) return true;
		}
		return false;
	}
	function verify_submit(form) {
		if (form.template_name.disabled == false && form.template_name.value == '') {
			alert('����� ���ø��� �̸��� �Է��ϼ���');
			form.template_name.focus();
			return false;
		}
		if (form.template_name.disabled == false && find_same_name(form.template_name.value) == true) {
			alert('������ �̸��� ���ø��� ���� �մϴ�. �ٸ� �̸��� ����ϼ���');
			form.template_name.value = '';
			form.template_name.focus();
			return false;
		}
		if (typeof(form.template_file_name) != 'undefined' && form.template_file_name.value == '') {
			alert('���������� �̸��� �Է��ϼ���.');
			form.template_file_name.focus();
			return false;
		}
	}
	function select_template(form, obj) {
		if (obj.value != '') form.template_name.disabled = true;
		else form.template_name.disabled = false;
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>	
	<form method='post'  name='frm' action='$T_action' onsubmit='return verify_submit(this)' enctype='multipart/form-data'>
	<input type=hidden name=mode value='make_template'>
	$P_hidden
	<tr>
		<td>
			$P_table_form
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'>
			<a href='javascript:document.frm.reset()'><img src='{$DIRS[designer_root]}images/bt_repeat.gif' border='0'></a>
		</td>
	</tr>
	</form>
	<tr>
		<td>$P_table_form_help</td>
	</tr>
</table>
</body>
");
include "footer_sub.inc.php";
?>