<?
include "header_sub.inc.php";
$sell_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_sell], "serial_num", $_GET[serial_num]);
$P_contents = "
<table border='0' width='100%' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr>
		<td width=100 class=input_form_title><font color=red>*</font> ��ǰ��</td>
		<td class=input_form_value>
			" . stripslashes($sell_info[title]) . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> �����ڸ�</td>
		<td class=input_form_value>
			" . stripslashes($sell_info[buyer_name]) . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> �ܰ�</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->get_format("money", $sell_info[money_price], '', " ��") . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> �Ⱓ</td>
		<td class=input_form_value>
			{$sell_info[ea]} {$SI_unit_code[$sell_info[unit_code]]}
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> �������</td>
		<td class=input_form_value>
			{$SI_pay_method[$sell_info[pay_method]]}
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> �� ������ �ݾ�</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->get_format("money", $sell_info[money_price]*$sell_info[ea], '', " ��") . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> �ǸŹݿ�</td>
		<td class=input_form_value>
			{$SI_pay_ok[$sell_info[sell_state]]}
		</td>
	</tr>
</table>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>"<b>������</b>"));
$P_input_form = "
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr>
		<td width=100 class=input_form_title><font color=red>*</font> ����</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($sell_info[money_receive], "money_receive", "text", "size=10 class=designer_text onblur='ck_number(this)'", "text-align:right", $style) . " ��
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> ����</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($sell_info[money_dc], "money_dc", "text", "size=10 class=designer_text onblur='ck_number(this)'", "text-align:right", $style) . " ��
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> �������</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($sell_info[pay_info], "pay_info", "textarea", "cols=40 rows=5 class=designer_textarea", "width:100%") . "
		</td>
	</tr>

</table>
";
$P_input_form = $lib_insiter->w_get_img_box($IS_thema, $P_input_form, $IS_input_box_padding, array("title"=>"<b>��������</b>"));
$P_input_form = "
	<tr><td height=10></td></tr>
	<tr>
		<td>$P_input_form</td>
	</tr>
";
echo("
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<form name=frm method=post action='buy_input.php'>
	<input type=hidden name='proc_mode' value='modify'>
	<input type=hidden name='serial_num' value='$_GET[serial_num]'>
	<tr>
		<td>
			$P_contents
		</td>
	</tr>
	$P_input_form
	<tr>
		<td align=center height=40>
			<input type=submit value='�������� ����' class='designer_button'>
		</td>
	</tr>
	</form>
</table>
");
include "{$DIRS[designer_root]}footer_sub.inc.php";
?>