<?
include "header_sub.inc.php";
$sell_info = $GLOBALS[lib_common]->get_data($DB_TABLES[service_sell], "serial_num", $_GET[serial_num]);
$P_contents = "
<table border='0' width='100%' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr>
		<td width=100 class=input_form_title><font color=red>*</font> 상품명</td>
		<td class=input_form_value>
			" . stripslashes($sell_info[title]) . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 구매자명</td>
		<td class=input_form_value>
			" . stripslashes($sell_info[buyer_name]) . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 단가</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->get_format("money", $sell_info[money_price], '', " 원") . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 기간</td>
		<td class=input_form_value>
			{$sell_info[ea]} {$SI_unit_code[$sell_info[unit_code]]}
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 결제방식</td>
		<td class=input_form_value>
			{$SI_pay_method[$sell_info[pay_method]]}
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 총 결제할 금액</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->get_format("money", $sell_info[money_price]*$sell_info[ea], '', " 원") . "
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 판매반영</td>
		<td class=input_form_value>
			{$SI_pay_ok[$sell_info[sell_state]]}
		</td>
	</tr>
</table>
";
$P_contents = $lib_insiter->w_get_img_box($IS_thema, $P_contents, $IS_input_box_padding, array("title"=>"<b>상세정보</b>"));
$P_input_form = "
<table border='0' width='100%' id='table5' cellspacing='1' cellpadding='5' class=input_form_table>
	<tr>
		<td width=100 class=input_form_title><font color=red>*</font> 수금</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($sell_info[money_receive], "money_receive", "text", "size=10 class=designer_text onblur='ck_number(this)'", "text-align:right", $style) . " 원
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 할인</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($sell_info[money_dc], "money_dc", "text", "size=10 class=designer_text onblur='ck_number(this)'", "text-align:right", $style) . " 원
		</td>
	</tr>
	<tr>
		<td class=input_form_title><font color=red>*</font> 결제기록</td>
		<td class=input_form_value>
			" . $GLOBALS[lib_common]->make_input_box($sell_info[pay_info], "pay_info", "textarea", "cols=40 rows=5 class=designer_textarea", "width:100%") . "
		</td>
	</tr>

</table>
";
$P_input_form = $lib_insiter->w_get_img_box($IS_thema, $P_input_form, $IS_input_box_padding, array("title"=>"<b>결제정보</b>"));
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
			<input type=submit value='결제정보 변경' class='designer_button'>
		</td>
	</tr>
	</form>
</table>
");
include "{$DIRS[designer_root]}footer_sub.inc.php";
?>