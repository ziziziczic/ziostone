<script language='javascript1.2'>
<!--
	function verify_submit_sa(form) {
		if (form.name.value == '' || form.name.value == '������ �����ּ���') {
			alert('�������� ������ ������ �����ּ���.');
			form.name.focus();
			return false;
		}
		if (form.phone.value == '' || form.phone.value == '����ó�� �����ּ���') {
			alert('�������� ��ȭ �Ǵ� �̸����ּҸ� ��Ȯ�� ���� �ּ���.');
			form.phone.focus();
			return false;
		}
		if (form.sa_date.value == '') {
			alert('����� ���Ͻô� ���ڿ� �ð��� �����ּ���.');
			form.sa_date.focus();
			return false;
		}
		form.submit();
	}
	function box_reset(form_object) {
		form_object.value = '';
	}
//-->
</script>
<table border=0 cellpadding=2 cellspacing=0>
	<form name='TCBOARD_2098_WRITE' method='post' action='./board/article_write.php?design_file=2076.php&board=2098' onsubmit='return verify_submit_sa(this);'>
	<input type='hidden' name='flag' value='<?echo($_SERVER[HTTP_HOST])?>'>
	<input type='hidden' name='category_1' value='Q'>
	<input type='hidden' name='query_next_page' value='home.php'>
	<tr>
		<td>�� �� �� ��</td>
		<td><input type=text name=name size=16 class=inputbox value='������ �����ּ���' onfocus='box_reset(this)'></td>
	</tr>
	<tr>
		<td>������ó</td>
		<td><input type=text name=phone size=16 class=inputbox value='����ó�� �����ּ���' onfocus='box_reset(this)'></td>
	</tr>
	<tr>
		<td>��㰡�ɽð�</td>
		<td><input type=text name=sa_date size=16 class=inputbox value='��� ������' onfocus='box_reset(this)'></td>
	<tr>
		<td colspan=2 align=right>
			<input type=image src='images/button.gif'>
		</td>
	</tr>
</form>
</table>