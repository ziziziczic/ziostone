<?
if ($_GET[user_level] != '') {
	$checked_7 = $checked_6 = $checked_5 = '';
	switch ($_GET[user_level]) {
		case '7' :
			$checked_7 = " checked";
		break;
		case '6' :
			$checked_6 = " checked";
		break;
		case '5' :
			$checked_5 = " checked";
		break;
	}

}

echo("
<script language='javascript1.2'>
<!--
function verify_submit_real_name(form) {
	if (radio_check(form, 'user_level', 'radio') == 0) {
		alert('ȸ�� ������ ���� �����ϼ���');
		return false;
	}
	if (form.a1.value == '') {
		alert('������ �Է��ϼ���');
		form.a1.focus();
		return false;
	}
	if (form.jumin_number_1.value == '' || form.jumin_number_2.value == '') {
		alert('�ֹε�Ϲ�ȣ�� ��Ȯ�� �Է��� �ּ���');
		form.jumin_number_1.focus();
		return false;
	}
	if (form.is_agree.checked != true) {
		alert('����� �о�� �� ���� �ϼž� ���� �����մϴ�.');
		return false;
	}
	form.submit();
}
//-->
</script>
<table cellSpacing='0' cellPadding='0' width='100%' border='0' align='center'>
	<form name='form2' action='{$root}nc_coin_p.php' method='post' onsubmit='verify_submit_real_name(this);return false;'>
	<input type='hidden' name='flag' value='{$_SERVER[HTTP_HOST]}'>
	<tr>
		<td><b>* ȸ������ ����<hr size=1 width=100%></td>
	</tr>
	<tr>
		<td>
			<input type='radio' name=user_level value='7' id='radio_user_level_7'{$checked_7}><label for='radio_user_level_7'>����, ����ȸ�� (������ ���� �Ϸ��� ��, ������������, ������ ���ϴ� ����)</label><br>
			<input type='radio' name=user_level value='6' id='radio_user_level_6'{$checked_6}><label for='radio_user_level_6'>���, ȭ��ȸ�� (�����������, �������� ������ ���)</label><br>
			<input type='radio' name=user_level value='5' id='radio_user_level_5'{$checked_5}><label for='radio_user_level_5'>���ȸ��, ���ԸŴ��� (���ȸ��, ���ԸŴ������� �����ϴ� ��� �Ǵ� ����)</label>
		</td>
	</tr>
	<tr><td height=20></td></tr>
	<tr>
		<td><b>* ����, �ֹε�Ϲ�ȣ �Է�</b>(�Ʒ��� ȸ������� �а� �����ϼž� ���� ���� �մϴ�.)<hr size=1 width=100%></td>
	</tr>
	<tr>
		<td>
			���� <input style='margin: 0px 20px 0px 10px; width: 65px' align='absmiddle' name='a1' size='20' class='designer_text'>
			�ֹε�Ϲ�ȣ <input style='margin-left: 10px;' maxlength='6' align='absmiddle' name='jumin_number_1' size='6' class='designer_text'> - <input style='margin-left: 10px;' maxlength='7' align='absmiddle' name='jumin_number_2' size='7' class='designer_text'>
			<input style='border: medium none; margin-left: 10px' type='image' src='designer/images/btn_ok.gif' align='absmiddle' width='30' height='18'>
		</td>
	</tr>
	<tr>
		<td height=50>
			�Ʒ��� ����� �о����� ���Ծ���� �����մϴ�. <input type='checkbox' name='is_agree' value='y'>
		</td>
	</tr>
	</form>
</table>
");
?>