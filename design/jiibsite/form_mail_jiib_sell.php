<script language='javascript1.2'>
<!--
	function verify_submit1(form) {
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
	if (form.car_type.value == '') {
		alert('차종/연식을 입력해주세요.');
		form.car_type.focus();
		return 0;
	}
	if (form.start.value == '') {
		alert('운행 구간을 입력해 주세요.');
		form.start.focus();
		return 0;
	}
	if (form.w_time.value == '') {
		alert('근무시간을 입력해주세요.');
		form.w_time.focus();
		return 0;
	}
	if (form.pay.value == '') {
		alert('월 급여를 입력해 주세요.');
		form.pay.focus();
		return 0;
	}
	if (form.e_money.value == '') {
		alert('지입료를 입력해주세요.');
		form.e_money.focus();
		return 0;
	}
	if (form.f_money.value == '') {
		alert('매도 희망금액을 입력해 주세요.');
		form.f_money.focus();
		return 0;
	}
	form.submit();
	}
//-->
</script>

	<table cellSpacing="0" cellPadding="1" border="0">
	<form name="apply_jiib_sell" onsubmit="verify_submit1(this); return false;" action="design/user_dir/save_apply_total.php" method="post">	
	<input type=hidden name=category value="매도상담">
		<tr>
			<td><img src='/design/fix_img/form_tit1.gif' border=0></td>
		</tr>
		<tr>
			<td>
			<table cellSpacing="1" cellPadding="5" bgColor="#e0e0e0" border="0" width=100%>
				<tr>
					<td bgColor="#f3f3f3" height="33" width=100>
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">의뢰인 성명</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="15" name="name" class=design_text> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">이메일 주소</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="40" name="email" class=design_text></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">전화번호</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="15" name="phone" class=design_text> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">차량톤수</td>
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
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">차종/연식</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="40" name="car_type" class=design_text> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">운행구간</td>
					<td bgColor="#ffffff">
						<input maxLength="100" size="15" name="start" class=design_text> ~ <input maxLength="100" size="15" name="end" class=design_text> <font color=red>*</font>
					</td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
						<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">근무시간(휴무)</td>
					<td bgColor="#ffffff">
						<input maxLength="100" size="30" name="w_time" class=design_text>  <font color=red>*</font>
					</td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
						<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">월급여
					</td>
					<td bgColor="#ffffff">
						<input maxLength="100" size="15" name="pay" class=design_text> <font color=red>*</font>
					</td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">지입료/관리비/보험료</td>
					<td bgColor="#ffffff">
						<input maxLength="100" size="34" name="e_money" class=design_text> <font color=red>*</font>
					</td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">매도희망금액</td>
					<td bgColor="#ffffff"><input maxLength="100" size="19" name="f_money" class=design_text> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">기타사항</td>
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

