<?
// ����
include "header.inc.php";
if ($_GET[serial_num] == '') {
	$proc_mode = "add";
	if ($_GET[serial_service_item] != '') $service_item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $_GET[serial_service_item]);
} else {
	$proc_mode = "modify";
	$banner_info = $GLOBALS[lib_common]->get_data($DB_TABLES[banner], "serial_num", $_GET[serial_num]);
	$service_item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $banner_info[serial_service_item]);
}
if ($service_item_info[serial_num] == '') $GLOBALS[lib_common]->alert_url('��������� ���õ��� �ʾҽ��ϴ�.');

/*
// ��ʻ�ǰ ����
$query_info = array();
$query_info[] = "select serial_num, name from $DB_TABLES[service_item] where code_table_name='{$DB_TABLES[banner]}'";
$query_info[] = "serial_num";
$query_info[] = "name";
$P_banner_position = $GLOBALS[lib_common]->get_list_boxs_query($query_info, "serial_service_item", $banner_info[serial_service_item], 'N', 'N', "onchange=\"set_banner_input_box(this.form, 'frm', this)\" class='designer_select'", '');
*/
include "include/banner_input_form.inc.php";
$P_input_form = $lib_insiter->w_get_img_box($IS_thema, $P_input_form, $IS_input_box_padding, array("title"=>"<b>��ʱ⺻����</b>"));
$P_input_form = "
	<tr>
		<td>$P_input_form</td>
	</tr>
";
$P_input_form_owner = $lib_insiter->w_get_img_box($IS_thema, $P_input_form_owner, $IS_input_box_padding, array("title"=>"<b>����������</b>"));
$P_input_form_owner = "
	<tr><td height=10></td></tr>
	<tr>
		<td>$P_input_form_owner</td>
	</tr>
";

$P_input_form_admin = "
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr>
		<td class=input_form_title><font color=red>*</font> ����</td>
		<td class=input_form_value>
			���� : " . $GLOBALS[lib_common]->make_date_input_box("open_date_chk", "open_date", $banner_info[banner_open_date], 0, "����", "Y-m-d, H:i:s", "size=25 class='designer_text' maxlength=30", 'Y') . "<br>
			���� : " . $GLOBALS[lib_common]->make_date_input_box("close_date_chk", "close_date", $banner_info[banner_close_date], 30, "30����", "Y-m-d, H:i:s", "size=25 class='designer_text' maxlength=30", 'Y') . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> ����</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->get_list_boxs_array($BA_state, "state", $banner_info[state], 'N', "class=designer_select") . "
		</td>
	</tr>	
	<tr>
		<td class=input_form_title><font color=red>*</font> �˸�</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->get_list_boxs_array($BA_state_alarm, "state_alarm", $banner_info[state_alarm], 'N', "class=designer_select") . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> �켱����</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($banner_info[priority], "priority", "text", "size=5 class=designer_text onblur='ck_number(this)'", '') . " (Ŭ���� �������� / 0 �Ǵ� 100 �̻��̸� �Ѹ�����)
		</td>
	</tr>
	<tr>
		<td width=100 class=input_form_title>* ��ũŸ��</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->get_list_boxs_array($SI_banner_target, "link_target", $banner_info[link_target], 'N', "class=designer_select") . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title>* ��â�Ӽ�</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($banner_info[link_target_pp], "link_target_pp", "text", "size=40 class=designer_text", '') . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title>* �������</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($banner_info[buy_qty], "buy_qty", "text", "size=2 class=designer_text", '') . " {$SI_unit_code[$service_item_info[unit_code]]}
		</td>
	</tr>
	<tr>
		<td class=input_form_title>* ����ȳ�/�ݾ�</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($banner_info[price_chg_msg], "price_chg_msg", "text", "size=30 class=designer_text", '') . " ��������
			" . $GLOBALS[lib_common]->make_input_box($banner_info[price_chg], "price_chg", "text", "size=10 class=designer_text onblur='ck_number(this)'", "text-align:right") . "����
			" . $GLOBALS[lib_common]->get_list_boxs_array($BA_price_chg_array, "price_chg_type", $banner_info[price_chg_type], 'N', "class=designer_select") . " �Ǿ����ϴ�.
		</td>
	</tr>
</table>
";
$P_input_form_admin = $lib_insiter->w_get_img_box($IS_thema, $P_input_form_admin, $IS_input_box_padding, array("title"=>"<b>�ΰ����� (�����ڿ�)</b>"));
$P_input_form_admin = "
	<tr><td height=10></td></tr>
	<tr>
		<td>$P_input_form_admin</td>
	</tr>
";

$change_vars = array();
$link_list = "{$DIRS[service]}banner_list.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);
$link_view = "{$DIRS[service]}banner_view.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);

echo("
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<form name=frm method=post action='banner_input.php' onsubmit='return verify_submit(this)' enctype='multipart/form-data'>
	<input type=hidden name='proc_mode' value='$proc_mode'>
	<input type=hidden name='serial_num' value='$_GET[serial_num]'>
	<input type=hidden name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	$P_input_form
	$P_input_form_owner
	$P_input_form_admin
	<tr>
		<td align=center height=40>
			<input type=submit value='�����ϱ�' class='designer_button'>
			<input type=button value='�󼼺���' onclick=\"document.location.href='$link_view'\" class='designer_button'>
			<input type=button value='��Ϻ���' onclick=\"document.location.href='$link_list'\" class='designer_button'>
		</td>
	</tr>
	<tr>
		<td>
");
if ($proc_mode == "add") {
	$BIF_serial_service_item = array($_GET[serial_service_item]);
	$BIF_form_name = "frm";
	$BIF_item_select = 'Y';
	include "buy_input_form.inc.php";
	$script_buy = "if (verify_submit_buy(form) == false) return false;";
}
echo("
		</td>
	</tr>
	</form>
</table>
<script id='dynamic_manager'></script>
<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		return verify_submit_banner(form);
		return verify_submit_banner_owner(form);
		$script_buy
	}
	/*
	function set_banner_input_box(form, form_name, obj) {
		if (obj.value == '') return;
		input_value = obj.value;
		dynamic_manager.src = '{$DIRS[service]}include/set_banner_input_box.js.php?serial_service_item=' + input_value + '&form_name=' + form_name;
	}
	*/
//-->
</script>
");
include "{$DIRS[designer_root]}footer.inc.php";
?>