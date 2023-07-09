<script language='javascript1.2'>
<!--
	var click_flag = 0;
	function verify_submit(form) {
		if (form.name.value == '') {
			alert('상호(성명)을 입력하세요');
			form.name.focus();
			return 0;
		}
		if (form.phone.value == '') {
			alert('연락 가능한 전화번호를 입력해주십시오');
			form.phone.focus();
			return 0;
		}
		form.submit();
	}
	function del_default_value(form) {
		if (click_flag == 0) {
			form.memo.value = "";
			click_flag = 1;
		} 
	}

//-->
</script>
	<a name='detail_top'>
	<table cellSpacing="0" cellPadding="1" border="0">
		<form name="apply_jiib_free" onsubmit="verify_submit(this); return false;" action="design/user_dir/save_apply_total.php?mode=detail" method="post">
		<input type=hidden name=category value="매물상담">
		<input type=hidden name=category_2 value="<?echo($article_num)?>">
		<tr>
			<td>
			<table cellSpacing="1" cellPadding="5" bgColor="#e0e0e0" border="0" width=100%>
				<tr>
					<td bgColor="#f3f3f3" height="33" width=100>
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">의뢰인 성명</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="15" name="name" class=design_text> <font color=red>*</font>&nbsp;&nbsp;매물번호:<b><?echo($article_num)?></b></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">전화번호</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="15" name="phone" class=design_text> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">이메일 주소</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="30" name="email" class=design_text></td>
				</tr>
				<tr>
					<td bgColor="#ffffff" colspan='2'>
					<textarea name="memo" rows="7" cols="44" class=design_textarea onfocus='del_default_value(this.form)'>문의내용을 적어주세요.</textarea> </td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td align="middle" height="50"><input type="image" src="/design/fix_img/but_up.gif">&nbsp;<a href="#" onclick="window.close()"><img src="/design/fix_img/but_cancel.gif" border=0></a>
			</td>
		</tr>
	</form>
	</table>

