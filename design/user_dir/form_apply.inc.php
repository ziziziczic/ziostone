<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		if (form.name.value == '') {
			alert('������ �Է��ϼ���');
			form.name.focus();
			return false;
		}
		if (form.phone.value == '') {
			alert('���� ������ ��ȭ��ȣ �Ǵ� �޴��� ��ȣ�� �Է����ֽʽÿ�');
			form.phone.focus();
			return false;
		}
		if (form.memo.value == '') {
			alert('�ֹ� ������ �Է��ϼ���');
			form.memo.focus();
			return false;
		}
	}
//-->
</script>
<?
echo("
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* ǥ�ô� �ʼ� �Է»��� �Դϴ�.
<table width='100%' border='0' cellpadding='4' cellspacing='1' bgcolor='D5D9E8' align=center>
	<form name='TCBOARD_2474_WRITE_1' method='post' action='./board/article_write.php' onsubmit='return verify_submit(this);'>
	<input type='hidden' name='Q_STRING' value='design_file=2476.php'>
	<input type='hidden' name='board' value='2474'>
	<input type='hidden' name='flag' value='$_SERVER[HTTP_HOST]'>
	<input type='hidden' name='category_1' value='O'>
	<input type='hidden' name='is_html' value='Y'>
	<input type='hidden' name='query_next_page' value='home.php'>
	<tr bgcolor='#FFFFFF'>
		<td bgcolor='#F4F5FB' align='center'><font color='47557C'>���� �ֹ�����<br>�����Ǽ���</font></td>
		<td>Tel. <strong>031-419-7553</strong> Fax. 031-419-7554 E-mail : tjrghtks@korea.com</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td width='120' bgcolor='#F4F5FB' align='center'><font color='47557C'>* ����</font></td>
		<td ><input name='name' type='text' size='30' value='$user_info[name]'> (�ʼ�)</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td bgcolor='#F4F5FB' align='center'><font color='47557C'>E-mail</font></td>
		<td><input name='email' type='text' size='30' value='$user_info[email]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td bgcolor='#F4F5FB' align='center'><font color='47557C'>* ����ó(�ڵ���)</font></td>
		<td><input name='phone' type='text' size='30' value='$user_info[phone]'> (�ʼ�)</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td bgcolor='#F4F5FB' align='center'><font color='47557C'>�ּ�</font></td>
		<td><input name='address' type='text' size='60' value='$user_info[address]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td bgcolor='#F4F5FB' align='center'><font color='47557C'>* �ֹ����� (�ʼ�)</font></td>
		<td><textarea name='memo' rows=10 cols='80'></textarea></td>
	</tr>	
	<tr>
		<td align=middle height=50 colspan=2 bgcolor=ffffff><input type=image src=/design/user_dir/images/but_up.gif>&nbsp;<a href='/'><img src=/design/user_dir/images/but_cancel.gif border=0></a></td>
	</tr>
	</form>
</table>
");
?>