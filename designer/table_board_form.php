<?
/*----------------------------------------------------------------------------------
 * ���� : �λ���Ʈ �Խ��� �׸� ���� ȭ��
 * �߿� ����:
 *-----------------------------------------------------------------------------------
 * PHP Programing by Han Sang You
 *-----------------------------------------------------------------------------------
 */
include "header_sub.inc.php";
$is_save_list = $is_save_form = $is_save_view = "none";
$design = $lib_fix->design_load($DIRS, $design_file, $site_page_info);
$exp = explode($GLOBALS[DV][dv], $design[$_GET[form_line]]);
if ($exp[4] != "") {	// �� ������ �ִ� ��� ������ �ҷ��´�.
	if ($exp[4] == "TC_BOARD") {
		$exp_bp = explode(":", $exp[5]);
		$board_name = $exp_bp[0];	// �̸�
		$form_type = $exp_bp[1];			// ��Ÿ��
		if ($form_type == "LIST") {
			$is_save_list = "visible";
			$query_type = $exp_bp[2];		// ����Ÿ��
			$table_per_article = $exp_bp[3];	// ���̺�� ��°Խù� ��
			$table_per_block = $exp_bp[4];	// ���̺�� �����������ũ ��
			$line_per_article = $exp_bp[5];		// ���ٴ� ��°Խù���
			$sort_field = $exp_bp[7];					// �����ʵ�
			$sort_sequence = $exp_bp[8];		// ���ļ���
			$user_query = $exp[6];						// ���������
			$list_view_mode = $exp_bp[9];		// ��¹��
			$relation_table = $exp_bp[10];		// ���ðԽ���
		} else if (($form_type == "WRITE") || ($form_type == "MODIFY") || ($form_type == "DELETE") || ($form_type == "REPLY") || ($form_type == "COMMENT")) {
			$is_save_form = "visible";
			$query_next_page = $exp_bp[3];
			$relation_table = $exp_bp[10];		// ���ðԽ���
			$saved_verify_input = explode("~", $exp_bp[2]);	 // �ʼ� �Է��׸�
		} else {
			$is_save_view = "visible";
		}
	}
	// ����Ǿ� �ִ� ���̺��� �ִ��� Ȯ���ϰ� ������ �̸��� ����.
	$saved_board_info = $lib_fix->get_board_info($board_name);
}

$query = "select	name, alias from $DB_TABLES[board_list] order by create_date;";		//	�����Ǿ��ִ� �Խ��� ������ �ҷ��´�. 
$query_info = array($query, "name", "alias");

$P_table_board_form = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td height='30' width='80' align='center'>�Խ��Ǽ���</td>
		<td>" . $GLOBALS[lib_common]->get_list_boxs_query($query_info, "board_name", $saved_board_info[name], 'N', 'N', "class='designer_select'", '', $default_num_msg=":: �Խ��Ǽ��� ::") . "</td>
	</tr>
	<tr>
		<td colspan='2'><hr></td>
	</tr>
	<tr> 
		<td height='30' width='80' align='center'>��Ÿ��</td>
		<td>
			<table width='100%'>
				<tr>
					<td width=50%>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('LIST', document.getElementsByTagName('tr'), '')\"", "", "LIST") . "<b>��Ϻ���</b> ���</td>
					<td width=50%>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('', document.getElementsByTagName('tr'), '')\"", "", "VIEW") . "<b>���뺸��</b> ���</td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('FORM', document.getElementsByTagName('tr'), '')\"", "", "WRITE") . "<b>����</b> ���</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('FORM', document.getElementsByTagName('tr'), '')\"", "", "MODIFY") . "<b>����</b> ���</td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('FORM', document.getElementsByTagName('tr'), '')\"", "", "REPLY") . "<b>��۾���</b> ���</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('FORM', document.getElementsByTagName('tr'), '')\"", "", "DELETE") . "<b>����</b> ���</td>
				</tr>
				<tr>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($form_type, "form_type", "radio", "onclick=\"chg_form_type();enable_child_id('FORM', document.getElementsByTagName('tr'), '')\"", "", "COMMENT") . "<b>��۾���</b> ���
						" . $GLOBALS[lib_common]->make_input_box($relation_table, "relation_table_1", "text", "size=13 maxlength=100 class=designer_text", "") . "
					</td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_table_board_form = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_board_form, $IS_input_box_padding, array("title"=>"<b>�Խ��� & ��Ÿ�� ����</b>"));

$query = "select * from $DB_TABLES[board_list] where view_page='$design_file'";
$result = $GLOBALS[lib_common]->querying($query, "�Խù� ���� ������ ���� ������ ����");
if (mysql_num_rows($result) == 0) $is_view_page = " disabled";	// ���� �������� ���� �������� �� ����, ����, ���� ��������� ������ �� �ְ� �Ѵ�.	

// ���ļ���
$option_name=array("::: ���� :::", "�Ϸù�ȣ", "�����", "�̸�", "�̸���", "Ȩ������", "����", "����-1", "����-2", "��ȸ��", "�ڷ�", "�з�-1", "�з�-2", "�з�-3", "���̵�", "��Ÿ-1", "��Ÿ-2", "��Ÿ-3");
$option_value = array("", "serial_num", "sign_date", "name", "email", "homepage", "subject", "comment_1", "comment_2", "count", "user_file", "category_1", "category_2", "category_3", "writer_id", "etc_1", "etc_2", "etc_3");
$P_sort_field = "�׸� " . $GLOBALS[lib_common]->make_list_box("sort_field", $option_name, $option_value, "", $sort_field, "class=designer_select", $style) . "<br>";
$option_name = $option_value = "";

$option_name = array("::: ���� :::", "��������","��������");
$option_value = array("", "desc","asc");
$P_sort_sequence = "���� " . $GLOBALS[lib_common]->make_list_box("sort_sequence", $option_name, $option_value, "", $sort_sequence, "class=designer_select", $style) . "<br>";

// ��°��� ����
$option_name = array();
for ($i=1; $i<=100; $i++) $option_name[] = $i;
$option_name[] = 0;
$P_table_per_article = "�Խù��� " . $GLOBALS[lib_common]->make_list_box("table_per_article", $option_name, $option_name, $table_per_article, "", "class=designer_select", "width=50");
$option_name = array();
for ($i=1; $i<=20; $i++) $option_name[] = $i;
$P_table_per_block = "�������� " . $GLOBALS[lib_common]->make_list_box("table_per_block", $option_name, $option_name, $table_per_block, "", "class=designer_select", "width=50");
$option_name = array();
for ($i=0; $i<=30; $i++) $option_name[] = $i;
$P_line_per_article = "���ٰ��� " . $GLOBALS[lib_common]->make_list_box("line_per_article", $option_name, $option_name, $line_per_article, "", "class=designer_select", "width=50");

// ��¹�� ����
$option_name = array("::: ���� :::", "�Ϲ���","FAQ��");
$option_value = array("", "","_layer");
$P_list_view_mode = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " . $GLOBALS[lib_common]->make_list_box("list_view_mode", $option_name, $option_value, "", $list_view_mode, "class=designer_select", $style) . "<br>";
$option_name = $option_value = "";

$P_table_board_form_list = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td height='30' width='80' align='center'>����Ÿ��</td>
		<td>
			<table width='100%'>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'", "", "1") . "<b>��ü���</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'", "", "2") . "<b>�����۸��</b>(�亯�� ���ܸ��)</td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'", "", "3") . "<b>���α۸��</b>(ȸ��������)</td>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'{$is_view_page}", "", "4") . "<b>���ñ۸��</b>(������ �亯�۸��)</td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'{$is_view_page}", "", "5") . "<b>�����۸��</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'{$is_view_page}", "", "6") . "<b>�����۸��</b></td>
				</tr>
				<tr>
					<td>
						" . $GLOBALS[lib_common]->make_input_box($query_type, "query_type", "radio", "class=designer_radio onclick='chg_query_type()'{$is_view_page}", "", "7") . "<b>��۸��</b>
						" . $GLOBALS[lib_common]->make_input_box($relation_table, "relation_table", "text", "size=13 maxlength=100 class=designer_text", "") . "
					</td>
					<td>* �������� " . $GLOBALS[lib_common]->make_input_box($user_query, "user_query", "text", "size=20 maxlength=100 class=designer_text", "") . "<span class=11px> (where �� and ����)</span></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan='2'><hr></td>
	</tr>
	<tr>
		<td colspan='2'>
			<table width='100%' cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td height='30' width='80' align='center'>���Ĺ��</td>
					<td>
						$P_sort_field
						$P_sort_sequence
					</td>
					<td height='30' width='80' align='center'>��°���</td>
					<td>
						$P_table_per_article ('0' �� ��ü)<br>
						$P_table_per_block<br>
						$P_line_per_article<br>
					</td>
				</tr>
				<tr>
					<td height='30' align='center'>��¹��</td>
					<td>
						$P_list_view_mode
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_table_board_form_list = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_board_form_list, $IS_input_box_padding, array("title"=>"<b>��ϱ�ɼ���</b>"));

// �Է��� �̵�������
$query = "select name, file_name from $DB_TABLES[design_files] where type='�����'";
$result = $GLOBALS[lib_common]->querying($query, "�����̸����� ���������� �����߻�");
$option_name[] = "::: �⺻�� :::";
$option_value[] = "";
while ($value = mysql_fetch_row($result)) {
	$option_name[] = $value[0];
	$option_value[] = $value[1];
}
$P_query_next_page = $GLOBALS[lib_common]->make_list_box("query_next_page", $option_name, $option_value, "", $query_next_page, "class=designer_select", "");

$P_table_board_form_input = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	<tr> 
		<td height='30' width='80' align='center'>�ʼ��Է��׸�</td>
		<td>
			<table width='100%'>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[0], "verify_input_1", "checkbox", "", "", "name") . "<b>�̸�</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[1], "verify_input_2", "checkbox", "", "", "email") . "<b>�̸���</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[2], "verify_input_3", "checkbox", "", "", "homepage") . "<b>Ȩ������</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[3], "verify_input_4", "checkbox", "", "", "subject") . "<b>����</b></td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[4], "verify_input_5", "checkbox", "", "", "comment_1") . "<b>����-1</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[5], "verify_input_6", "checkbox", "", "", "comment_2") . "<b>����-2</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[7], "verify_input_8", "checkbox", "", "", "user_file") . "<b>����</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[8], "verify_input_9", "checkbox", "", "", "category_1") . "<b>�з�-1</b></td>
				</tr>
				<tr>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[9], "verify_input_10", "checkbox", "", "", "category_2") . "<b>�з�-2</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[10], "verify_input_11", "checkbox", "", "", "category_3") . "<b>�з�-3</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[11], "verify_input_12", "checkbox", "", "", "etc_1") . "<b>��Ÿ-1</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[12], "verify_input_13", "checkbox", "", "", "etc_2") . "<b>��Ÿ-2</b></td>
				</tr>
				<tr>											
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[13], "verify_input_14", "checkbox", "", "", "etc_3") . "<b>��Ÿ-3</b></td>
					<td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[14], "verify_input_15", "checkbox", "", "", "phone") . "<b>��ȭ��ȣ</b></td>
					<!-- ��й�ȣ�� �ڵ����� ������ <td>" . $GLOBALS[lib_common]->make_input_box($saved_verify_input[6], "verify_input_7", "checkbox", "", "", "passwd") . "<b>��й�ȣ</b></td>//-->
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_table_board_form_input = $lib_insiter->w_get_img_box($IS_thema_window, $P_table_board_form_input, $IS_input_box_padding, array("title"=>"<b>�ʼ��Է��׸�</b>"));

include "include/form_form_property.inc.php";

$help_msg = "
	�Խ��Ǽ��� ȭ��
";
$P_table_form_help = $lib_insiter->get_help_form($help_msg, $GLOBALS[lib_common]->get_file_name($_SERVER[SCRIPT_FILENAME]));

echo("
<script language='javascript'>
<!--
	function verify_submit() {
		form = document.frm;
		if (form.board_name.value == '') {
			alert('�Խ����� �����ϼ���');
			form.board_name.focus();
			return false;
		}
		if (submit_radio_check(form, 'form_type', 'radio') == false) {
			alert('�� Ÿ���� �����ϼ���.');
			return false;
		}

		if (get_radio_value(form.form_type) == 'COMMENT') {	// ����� ��� �ʼ� �Է°˻�
			if (form.relation_table_1.disabled == false) {
				if (form.relation_table_1.value == '') {
					alert('������ ���̺��� �Է��ϼ���');
					form.relation_table_1.focus();
					return false;
				}
			}
		}

		if (get_radio_value(form.form_type) == 'LIST') {	// ����� ��� �ʼ� �Է°˻�
			if (submit_radio_check(form, 'query_type', 'radio') == false) {
				alert('����Ÿ���� �����ϼ���');
				return false;
			}
			if (form.relation_table.disabled == false) {
				if (form.relation_table.value == '') {
					alert('������ ���̺��� �Է��ϼ���');
					form.relation_table.focus();
					return false;
				}
			}
		}
	}
	function chg_form_type() {
		form = document.frm;
		if (get_radio_value(form.form_type) == 'COMMENT') {	// ��� ��� �ΰ�� ���� ���̺� Ȱ��
			form.relation_table_1.disabled = false;
			form.relation_table_1.style.background = '#FFFFFF';
			form.relation_table_1.focus();
		} else {
			form.relation_table_1.disabled = true;
			form.relation_table_1.style.background = '#FAFAFA';
		}
	}
	function chg_query_type() {
		form = document.frm;
		if (get_radio_value(form.query_type) == '7') {	// ��� ��� �ΰ�� ���� ���̺� Ȱ��
			form.relation_table.disabled = false;
			form.relation_table.style.background = '#FFFFFF';
			form.relation_table.focus();
		} else {
			form.relation_table.disabled = true;
			form.relation_table.style.background = '#FAFAFA';
		}
	}
//-->
</script>
<table width='100%' border='0' cellpadding='5' cellspacing='3'>
	<form name='frm' method='post' action='table_form_manager.php?design_file=$design_file' onsubmit='return verify_submit();'>
	<input type='hidden' name='design_file' value='$design_file'>
	<input type='hidden' name='form_line' value='$form_line'>
	<input type='hidden' name='mode' value='$mode'>
	<tr>
		<td>
			$P_table_board_form
		</td>
	</tr>
	<tr id='LIST' style='display:$is_save_list'>
		<td>
			$P_table_board_form_list
		</td>
	</tr>
	<tr id='FORM' style='display:$is_save_form'>
		<td>
			$P_table_board_form_input
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
<script language='javascript1.2'>
<!--
	chg_query_type();
	chg_form_type();
//-->
</script>
");

include "footer_sub.inc.php";
?>