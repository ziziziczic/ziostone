
<script language='javascript1.2'>
<!--
	function verify_submit(form) {
		if (form.company.value == '') {
			alert('상호를 입력하세요');
			form.company.focus();
			return 0;
		}
		if (form.name.value == '') {
			alert('성명을 입력하세요');
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
//-->
</script>

	<table cellSpacing="0" cellPadding="1" border="0">
		<form name="apply_jiib_free" onsubmit="verify_submit(this); return false;" action="design/user_dir/save_apply_total.php" method="post">
		<input type=hidden name=category value="기업체상담">
		<tr>
			<td><img src='/design/fix_img/form_tit1.gif' border=0></td>
		</tr>
		<tr>
			<td>
			<table cellSpacing="1" cellPadding="5" bgColor="#e0e0e0" border="0" width=100%>
				<tr>
					<td bgColor="#f3f3f3" height="33" width=100>
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">회사명</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="20" name="company" class=inputbox> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33" width=100>
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">담당자</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="15" name="name" class=inputbox> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">전화번호</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="15" name="phone" class=inputbox> <font color=red>*</font></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">이메일 주소</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="40" name="email" class=inputbox></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">근무시간</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="20" name="time" class=inputbox></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">월급여</td>
					<td bgColor="#ffffff">
					<input maxLength="100" size="20" name="pay" class=inputbox></td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">휴일</td>
					<td bgColor="#ffffff"><select name="holiday">
					<option value="일요일" selected>일요일</option>
					<option value="공휴일">공휴일</option>
					<option value="일요일+공휴일">일요일+공휴일</option>
					<option value="기 타">기타</option>
					</select> </td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">차종</td>
					<td bgColor="#ffffff">
<?
$board_info = $lib_handle->get_board_info("542");
$option_name = $option_value = explode("~", $board_info[category_2]);
echo($lib_handle->make_list_box("category_2", $option_name, $option_value, "", "", "class=design_select", ""));
?>
						<select name="car_van">
							<option value selected>승합&amp;버스</option>
							<option value="3 인승밴">3 인승밴</option>
							<option value="6 인승밴">6 인승밴</option>
							<option value="9-15 인승승합">9-15 인승승합</option>
							<option value="25 인승">25 인승</option>
							<option value="35 인승">35 인승</option>
							<option value="45 인승">45 인승</option>
							<option value="버스/관광차량">버스/관광차량</option>
						</select>
					</td>
				</tr>
				<tr>
					<td bgColor="#f3f3f3" height="33">
					<img src="/design/fix_img/nec_dot.gif" width="13" height="13" border="0" align="absmiddle">상담내용</td>
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
