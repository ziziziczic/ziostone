<script language='javascript1.2'>
<!--
function verify_submit_real_name(form) {
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
<table cellSpacing="1" cellPadding="5" width="600" border="0" bgcolor=cccccc>
  <tr>
    <td bgcolor=ffffff>
    <img height="21" src="design/images/tit_b01.gif"></td>
  </tr>
  <tr>
    <td bgcolor=f3f3f3>
		<font color=555555>���������� ���� ���� ����ڵ��� ��Ȱ�� ���� �̿�� �¶��� �󿡼��� �͸� ����ڷ� ���� ���� ���� �����ϱ� ȸ�� ID�� ���� �Ǹ����� �����ϰ� �ֽ��ϴ�.<br><br>
      ���� ������� ����������ȣ�� ���� ����� �������� ���������� ���񽺸� �̿��Կ� �־� �¶��λ󿡼� ȸ�翡 ������ ���������� ��ȣ ���� �� �ֵ��� �ּ��� ���ϰ� �ֽ��ϴ�.<br><br>
		ȸ������ ������ ���� ���� �������� ������, �������� ��ȣ��å�� ���� ��ȣ�ް� �ֽ��ϴ�.<br>
		ȸ�������� Ż�� ���Ͻô� ��� <a href="javascript:window.open('tools/form_mail/send_mail_form.php','form_mail', 'top=100,left=300,width=450,height=430,resizable=0,status=0,scrollbars=0,menubar=0').focus()"><font color=blue><u>����������ȣ�����</font></u></a> ���� ���� �ֽø� ��� ó���� �帳�ϴ�.<br><br>
		�������� ��ȣ�� ���� ���Ǵ� �� Ȩ������ <a href='insiter.php?design_file=492.php'><font color=blue><u>������</font></u></a> �̳� <a href="javascript:window.open('tools/form_mail/send_mail_form.php','form_mail', 'top=100,left=300,width=450,height=430,resizable=0,status=0,scrollbars=0,menubar=0').focus()"><font color=blue><u>����������ȣ�����</font></u></a> ���� ���� �ֽñ� �ٶ��ϴ�.<br>
		���������� ���� ������ ���ͳ� ������ ����� ���� ��� �ϰڽ��ϴ�.<br><br>
		�Ʒ��� ����, �ֹε�� ��ȣ�� �����Ͻø� �Ǹ�Ȯ���� ������ ���������� ������ �� �� �ֽ��ϴ�.
��</td>
  </tr>
</table><br><br>

<table cellSpacing="1" cellPadding="5" width="550" bgColor="#f3f3f3" border="0" align=center>
<form name="form2" action="nc_coin_p.php" method="post" onsubmit="verify_submit_real_name(this);return false;">
<input type=hidden name=flag value=<?echo($_SERVER[HTTP_HOST])?>>
	<tr>
		<td align="middle" bgcolor=fefefe>
			<table cellSpacing="0" cellPadding="0" width="500" border="0" align='center'>
				<tr>
					<td><b>����, �ֹε�Ϲ�ȣ �Է�</b>(�Ʒ��� ȸ������� �а� �����ϼž� ���� ���� �մϴ�.)<hr size=1 width=100%></td>
				</tr>
				<tr>
					<td>
						���� <input style="MARGIN: 0px 20px 0px 10px; WIDTH: 65px" align="absMiddle" name="a1" size="20" class='design_text'>
						�ֹε�Ϲ�ȣ <input style="MARGIN-LEFT: 10px;" maxLength="6" align="absMiddle" name="jumin_number_1" size="6" class='design_text'> - <input style="MARGIN-LEFT: 10px;" maxLength="7" align="absMiddle" name="jumin_number_2" size="7" class='design_text'>
						<input style="border: medium none; margin-left: 10px" type="image" src="design/images/btn_ok.gif" align="absMiddle" width="30" height="18">
					</td>
				</tr>
				<tr>
					<td height=50>
						�Ʒ��� ����� �о����� ���Ծ���� �����մϴ�. <input type="checkbox" name='is_agree' value='Y'>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<iframe width=100% height=350 src='design/user_dir/agreement.html' frameborder=0></iframe>
		</td>
	</tr>
</form>
</table>