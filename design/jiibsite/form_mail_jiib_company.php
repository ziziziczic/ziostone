
<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		if (form.company.value == '') {
			alert('��ȣ�� �Է��ϼ���');
			form.company.focus();
			return 0;
		}
		if (form.name.value == '') {
			alert('������ �Է��ϼ���');
			form.name.focus();
			return 0;
		}
		if (form.phone.value == '') {
			alert('���� ������ ��ȭ��ȣ�� �Է����ֽʽÿ�');
			form.phone.focus();
			return 0;
		}
		form.submit();
}
//-->
</script>

	<table cellSpacing="0" cellPadding="1" border="0">
		<form name="apply_jiib_free" onsubmit="verify_submit(this); return false;" action="design/user_dir/save_apply_total.php" method="post">
		<input type=hidden name=category value="���ü���">
		<tr>
			<td><img src='/design/fix_img/form_tit1.gif' border=0></td>
		</tr>
		<tr>
			<td>
			<table cellSpacing="1" cellPadding="5" bgColor="#e0e0e0" border="0" width=100%>
				<tr>
					<td bgColor="#f3f3f3" height="33" width=100>
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">ȸ���</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="20" name="company" class=inputbox> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33" width=100>
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">�����</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="15" name="name" class=inputbox> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">��ȭ��ȣ</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="15" name="phone" class=inputbox> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">�̸��� �ּ�</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="40" name="email" class=inputbox></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">�ٹ��ð�</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="20" name="time" class=inputbox></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">���޿�</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="20" name="pay" class=inputbox></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">����</td>
					<td bgColor="#ffffff"><select name="holiday">
					<option value="�Ͽ���" selected>�Ͽ���</option>
					<option value="������">������</option>
					<option value="�Ͽ���+������">�Ͽ���+������</option>
					<option value="�� Ÿ">��Ÿ</option>
					</select> </td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">����</td>
					<td bgColor="#ffffff">
<?
$board_info = $lib_handle->get_board_info("542");
$option_name = $option_value = explode("~", $board_info[category_2]);
echo($lib_handle->make_list_box("category_2", $option_name, $option_value, "", "", "class=design_select", ""));
?>
						<select name="car_van">
							<option value selected>����&amp;����</option>
							<option value="3 �ν¹�">3 �ν¹�</option>
							<option value="6 �ν¹�">6 �ν¹�</option>
							<option value="9-15 �ν½���">9-15 �ν½���</option>
							<option value="25 �ν�">25 �ν�</option>
							<option value="35 �ν�">35 �ν�</option>
							<option value="45 �ν�">45 �ν�</option>
							<option value="����/��������">����/��������</option>
						</select>
					</td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">��㳻��</td>
					<td bgColor="#ffffff">
					<textarea name="memo" rows="20" cols="65" class=inputbox></textarea> </td>
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
