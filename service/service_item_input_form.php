<?
// ����
include "header.inc.php";
if ($_GET[serial_num] == '') {
	$proc_mode = "add";
} else {
	$proc_mode = "modify";
	$service_item_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_item], "serial_num", $_GET[serial_num]);
}

// ���� ���� ���û��� ����
$property = array(
	"name_1"=>"code_table_name",
	"property_1"=>"class=designer_select",
	"default_value_1"=>$service_item_info[code_table_name],
	"name_2"=>"code_field_name",
	"property_2"=>"class=designer_select",
	"default_value_2"=>$service_item_info[code_field_name],
	"default_title_1"=>":: �з� ::",
	"default_title_2"=>":: ���� ::"
);
$P_item_codes = $GLOBALS[lib_common]->get_item_select_box($SI_item_table, $SI_item_field, $property);

// �����Է»���
$T_user_level_alias = $user_level_alias;
$T_user_level_alias['1'] = $T_user_level_alias['8'] = '';
$P_price_input_box = "<b>��ǥ����</b> : " . $GLOBALS[lib_common]->make_input_box($service_item_info[price], "price", "text", "size=10 class=designer_text onblur='ck_number(this)'", "text-align:right") . " ��<br>";
while (list($key, $value) = each($T_user_level_alias)) {
	if ($value == '') continue;
	$field_name_price_input_box = "price_{$key}";
	$P_price_input_box .= "<b>$value</b> : " . $GLOBALS[lib_common]->make_input_box($service_item_info[$field_name_price_input_box], $field_name_price_input_box, "text", "size=10 class=designer_text onblur='ck_number(this)'", "text-align:right", $style) . " ��<br>";
}

// �������û���
for ($i=1; $i<=200; $i++) $option_name[] = $option_value[] = $i;

$P_input_form = "
<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		if (form.code_table_name.value == '') {
			alert('��ǰ  �з��� ���� �ϼ���');
			form.code_table_name.focus();
			return false;
		}
		if (form.code_field_name.value == '') {
			alert('���� ������ ���� �ϼ���');
			form.code_field_name.focus();
			return false;
		}
		if (form.apply_fields.value == '') {
			alert('�Ⱓ������ ���� �ϼ���');
			form.apply_fields.focus();
			return false;
		}
		if (form.name.value == '') {
			alert('��ǰ���� �Է��ϼ���');
			form.name.focus();
			return false;
		}
		if (form.price.value == '') {
			alert('������ �Է��ϼ���.');
			form.price.focus();
			return false;
		}
		if (form.unit_code.value == '') {
			alert('��ǰ �ǸŴ����� ��Ȯ�� �����ϼ���.');
			form.unit_code.focus();
			return false;
		}
	}
//-->
</script>
<table border='0' width='100%' id='table1' cellspacing='0' cellpadding='0'>
	<tr>
		<td>				
			<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
				<tr>
					<td width='115' class=input_form_title><font color=red>*</font> ��������</td>
					<td class=input_form_value>
						$P_item_codes[0] $P_item_codes[1] $P_item_codes[2]
					</td>
				</tr>
				<tr>
					<td width='115' class=input_form_title><font color=red>*</font> �Ⱓ����</td>
					<td class=input_form_value>
						" . $GLOBALS[lib_common]->get_list_boxs_array($SI_apply_nums, "apply_fields", $service_item_info[apply_fields], 'Y', "class=designer_select") . " (DB table field ������ ���� ����)
					</td>
				</tr>
				<tr>
					<td width='115' class=input_form_title><font color=red>*</font> ��ǰ��</td>
					<td class=input_form_value>
						" . $GLOBALS[lib_common]->make_input_box($service_item_info[name], "name", "text", "size=60 class=designer_text", $style) . "
					</td>
				</tr>
				<tr>
					<td width='115' class=input_form_title><font color=red>*</font> ����</td>
					<td class=input_form_value>
						$P_price_input_box
					</td>
				</tr>
				<tr>
					<td width='115' class=input_form_title><font color=red>*</font> �ǸŴ���</td>
					<td class=input_form_value>
						<b>�ּ�</b> : " . $GLOBALS[lib_common]->make_list_box("ea_min", $option_name, $option_value, '', $service_item_info[ea_min], "class=designer_select", '') . "
						" . $GLOBALS[lib_common]->get_list_boxs_array($SI_unit_code, "unit_code", $service_item_info[unit_code], 'Y', "class=designer_select", "��������") . " / <b>�ִ�</b> : 
						" . $GLOBALS[lib_common]->make_list_box("ea_max", $option_name, $option_value, '', $service_item_info[ea_max], "class=designer_select", '') . " / <b>����</b> : 
						" . $GLOBALS[lib_common]->make_list_box("ea_pack", $option_name, $option_value, '', $service_item_info[ea_pack], "class=designer_select", '') . "
					</td>
				</tr>
				<tr>
					<td width='115' class=input_form_title><font color=red>*</font> ��Ű��</td>
					<td class=input_form_value>
						" . $GLOBALS[lib_common]->make_input_box($service_item_info[package], "package", "text", "size=30 class=designer_text", $style) . " (���� ��ǰ, �Է¿� : ;21;3;40; )
					</td>
				</tr>
				<tr>
					<td width='115' class=input_form_title><font color=red>*</font> �ǸŰ��ɼ�</td>
					<td class=input_form_value>
						" . $GLOBALS[lib_common]->make_input_box($service_item_info[ea_total], "ea_total", "text", "size=10 class=designer_text", $style) . " (���� ���� ���� �ִ� ��ǰ��, �� : ���)
					</td>
				</tr>
				<tr>
					<td class=input_form_title><font color=red>*</font> �Ǹ���</td>
					<td class=input_form_value>
						" . $GLOBALS[lib_common]->get_list_boxs_array($SI_is_yn, "state", $service_item_info[state], 'N', "class=designer_select") . "
					</td>
				</tr>
				<tr>
					<td class=input_form_title>* �̹��� #1</td>
					<td class=input_form_value>
						" . $GLOBALS[lib_common]->get_file_upload_box("upload_file", 1, $service_item_info[upload_files], "size=40 class=designer_text", "{$DIRS[service_upload]}item/") . "<br>(.jpg .gif ���ϸ� ����)									
					</td>
				</tr>
				<tr>
					<td class=input_form_title>* �̹��� #2</td>
					<td class=input_form_value>
						" . $GLOBALS[lib_common]->get_file_upload_box("upload_file", 2, $service_item_info[upload_files], "size=40 class=designer_text", "{$DIRS[service_upload]}item/") . "<br>(.jpg .gif ���ϸ� ����)										
					</td>
				</tr>
				<tr>
					<td class=input_form_title>* ��ǰ����</td>
					<td class=input_form_value>
						" . $GLOBALS[lib_common]->make_input_box($service_item_info[comment], "comment", "textarea", "rows=5 cols=50 class=designer_textarea", "width:100%") . "
					</td>
				</tr>
				<tr>
					<td class=input_form_title>* �ɼ�</td>
					<td class=input_form_value>
						" . $GLOBALS[lib_common]->make_input_box($service_item_info[item_option], "item_option", "text", "size=130 class=designer_text", '') . "<br>
						�������) �Է»���;�Ѱ���;���ټ�;���ʽ�;��Ų��;�����;����ĭ��Ÿ��;������;���ϳ���;���ϱ�Ÿ�Ӽ�;����ĭ�Ӽ�;Ÿ��Ʋ����;�������;������̺�Ӽ�<br>
						��ʿ�) UPLOADFILE_TITLE1_CONTENTS;30;5;0;img_title_gray;140;style='';130;30;border=0 align=absmiddle;5;30;50;width=100% cellpadding=3 cellspacing=0 border=0<br>
						��Ÿ����) �ʵ��;�ڵ�:��³���,�ڵ�:��³��� ... / ��Ÿ��) #CC0000:������,#0000CC:�Ķ��� ..
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
";
$P_input_form = $lib_insiter->w_get_img_box($IS_thema, $P_input_form, $IS_input_box_padding, array("title"=>"<b>���� �����Է�</b>"));
$P_input_form = "
	<tr>
		<td>$P_input_form</td>
	</tr>
";

$change_vars = array();
$link_list = "{$DIRS[service]}service_item_list.php?" . $GLOBALS[lib_common]->get_change_var_url($_SERVER[QUERY_STRING], $change_vars);

echo("
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<form name=frm method=post action='service_item_input.php' onsubmit='return verify_submit(this)' enctype='multipart/form-data'>
	<input type=hidden name='proc_mode' value='$proc_mode'>
	<input type=hidden name='serial_num' value='$_GET[serial_num]'>
	<input type=hidden name='Q_STRING' value='$_SERVER[QUERY_STRING]'>
	<tr>
		<td>
			$P_input_form
		</td>
	</tr>	
	<tr>
		<td align=center height=40>
			<input type=submit value='�����ϱ�' class='designer_button'>
			<input type=button value='��Ϻ���' onclick=\"document.location.href='$link_list'\" class='designer_button'>
		</td>
	</tr>
	</form>
</table>
");
include "{$DIRS[designer_root]}footer.inc.php";
?>