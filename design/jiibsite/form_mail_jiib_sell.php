<script language='javascript1.2'>
<!--
	function verify_submit1(form) {
		if (form.name.value == '') {
		alert('��ȣ(����)�� �Է��ϼ���');
		form.name.focus();
		return 0;
	}
	if (form.phone.value == '') {
		alert('���� ������ ��ȭ��ȣ�� �Է����ֽʽÿ�');
		form.phone.focus();
		return 0;
	}
	if (form.car_type.value == '') {
		alert('����/������ �Է����ּ���.');
		form.car_type.focus();
		return 0;
	}
	if (form.start.value == '') {
		alert('���� ������ �Է��� �ּ���.');
		form.start.focus();
		return 0;
	}
	if (form.w_time.value == '') {
		alert('�ٹ��ð��� �Է����ּ���.');
		form.w_time.focus();
		return 0;
	}
	if (form.pay.value == '') {
		alert('�� �޿��� �Է��� �ּ���.');
		form.pay.focus();
		return 0;
	}
	if (form.e_money.value == '') {
		alert('���ԷḦ �Է����ּ���.');
		form.e_money.focus();
		return 0;
	}
	if (form.f_money.value == '') {
		alert('�ŵ� ����ݾ��� �Է��� �ּ���.');
		form.f_money.focus();
		return 0;
	}
	form.submit();
	}
//-->
</script>

	<table cellSpacing="0" cellPadding="1" border="0">
	<form name="apply_jiib_sell" onsubmit="verify_submit1(this); return false;" action="design/user_dir/save_apply_total.php" method="post">	
	<input type=hidden name=category value="�ŵ����">
		<tr>
			<td><img src='/design/fix_img/form_tit1.gif' border=0></td>
		</tr>
		<tr>
			<td>
			<table cellSpacing="1" cellPadding="5" bgColor="#e0e0e0" border="0" width=100%>
				<tr>
					<td bgColor="#f3f3f3" height="33" width=100>
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">�Ƿ��� ����</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="15" name="name" class=design_text> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">�̸��� �ּ�</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="40" name="email" class=design_text></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">��ȭ��ȣ</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="15" name="phone" class=design_text> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">�������</td>
					<td bgColor="#ffffff">
<?
$board_info = $lib_handle->get_board_info("542");
$option_name = $option_value = explode("~", $board_info[category_2]);
echo($lib_handle->make_list_box("category_2", $option_name, $option_value, "", "", "class=design_select", ""));
?>
					<font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">����/����</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="40" name="car_type" class=design_text> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">���౸��</td>
					<td bgColor="#ffffff">
						<input maxLength="100" size="15" name="start" class=design_text> ~ <input maxLength="100" size="15" name="end" class=design_text> <font color=red>*</font>
					</td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
						<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">�ٹ��ð�(�޹�)</td>
					<td bgColor="#ffffff">
						<input maxLength="100" size="30" name="w_time" class=design_text>  <font color=red>*</font>
					</td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
						<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">���޿�
					</td>
					<td bgColor="#ffffff">
						<input maxLength="100" size="15" name="pay" class=design_text> <font color=red>*</font>
					</td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">���Է�/������/�����</td>
					<td bgColor="#ffffff">
						<input maxLength="100" size="34" name="e_money" class=design_text> <font color=red>*</font>
					</td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">�ŵ�����ݾ�</td>
					<td bgColor="#ffffff"><input maxLength="100" size="19" name="f_money" class=design_text> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">��Ÿ����</td>
					<td bgColor="#ffffff">
					<textarea name="memo" rows="10" cols="63" class=design_textarea></textarea> </td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td align="middle" height="50"><input type="image" src="/design/fix_img/but_up.gif">&nbsp;<a href='/'><img src="/design/fix_img/but_cancel.gif" border=0></a>
			</td>
		</tr>
		</form>
	</table>

