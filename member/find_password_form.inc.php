<script language='javascript1.2'>
<!--
function verify_submit_find_password(form) {
	
	if ((form.jumin_number_1.value == '') || (form.jumin_number_1.value == '')) {
		alert('�ֹι�ȣ�� ��Ȯ�� �Է��� �ּ���');
		form.jumin_number_1.focus();
		return false;
	}
	if (form.name.value == '') {
		alert('������ �Է��� �ּ���');
		form.name.focus();
		return false;
	}
	if (form.id.value == '') {
		alert('���̵� �Է��� �ּ���');
		form.id.focus();
		return false;
	}
	form.submit();
}
//-->
</script>

<link rel='stylesheet' href='<?echo($DIRS[designer_root])?>include/designer_style.css' type='text/css'>	

<table border=0 cellpadding=0 cellspacing=0 align=center>
	<form name='insiter' method=post action='<?echo($site_info[index_file])?>?design_file=find_manager.php' onsubmit='return verify_submit_find_password(this)'>
	<input type='hidden' name='find_item' value='password'>
	<input type='hidden' name='flag' value='<?echo($_SERVER[HTTP_HOST])?>'>
	<tr>
		<td width=80>�ֹε�Ϲ�ȣ</td>
		<td><input type="text" size=8 class="designer_text" name="jumin_number_1"> - <input type="text" size=8 class="designer_text" name="jumin_number_2"></td>
	</tr>
	<tr>
		<td width=80>�� ��</td>
		<td><input type="text" size=23 name="name" class="designer_text"></td>
	</tr>
	<tr>
		<td width=80>���̵�</td>
		<td><input type="text" size=23 name="id" class="designer_text"></td>
	</tr>
	<tr><td colspan=2 height=5></td></tr>
	<tr>
		<td></td>
		<td><input type=image src="<?echo($DIRS[designer_root])?>images/btn_confirm.gif" width="72" height="23" border="0" alt=""></td>
	</tr>
	</form>
</table>