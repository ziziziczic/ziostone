<?
/*----------------------------------------------------------------------------------
 * ���� : �λ���Ʈ �Խ��� �׸� ���� ȭ��
 * �߿� ����:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Lee Joo Han
 *-----------------------------------------------------------------------------------
 */
include "header_sub.inc.php";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
$exp = explode($GLOBALS[DV][dv], $design[$_GET[form_line]]);
$exp_function = explode($GLOBALS[DV][ct4], $exp[7]);
$login_next_method_array = array('P'=>"����������", 'C'=>"����������", 'S'=>"�⺻����");
$P_table_login_form = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td height='30' width='80' align='center'>�ʼ��Է�</td>
		<td>
			" . $GLOBALS[lib_common]->make_input_box("", "", "checkbox", "checked disabled", "", "") . " ���̵�
			" . $GLOBALS[lib_common]->make_input_box("", "", "checkbox", "checked disabled", "", "") . " ��й�ȣ (�α��ν� ���̵�� ��й�ȣ�� �׻� �ʼ� �Է�)
		</td>
	</tr>
	<tr> 
		<td height='30' width='80' align='center'>�α�����</td>
		<td>
			" . $GLOBALS[lib_common]->get_list_boxs_array($login_next_method_array, "login_next_method", $exp_function[4], 'N', "class=designer_select") . " (��)�� �̵�
		</td>
	</tr>
</table>
";
$P_table_login_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_login_form, $IS_input_box_padding, array("title"=>"<font color='#5145FF'><b>�α����� ����</b></font>"));

include "include/form_form_property.inc.php";

$help_msg = "
	�α����� ����ȭ��
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<form name='frm' method='post' action='table_form_manager.php'>
	<input type='hidden' name='design_file' value='$design_file'>
	<input type='hidden' name='form_line' value='$form_line'>
	<input type='hidden' name='mode' value='$mode'>
	<tr>
		<td>
			$P_table_login_form
		</td>
	</tr>
	<tr>
		<td>
			$P_table_form_function
		</td>
	</tr>
	<tr>
		<td height='20' colspan='4' align='right' valign='top'>
			<input type='image' src='{$DIRS[designer_root]}images/bt_enter.gif' border='0'></a>
			<a href='javascript:parent.window.close()'><img src='{$DIRS[designer_root]}images/bt_close.gif' border='0'></a>
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