<script language='javascript1.2'>
<!--
	function verify_submit_sa(form) {
		if (form.name.value == '' || form.name.value == '성명을 적어주세요') {
			alert('상담받으실 고객님의 성명을 적어주세요.');
			form.name.focus();
			return false;
		}
		if (form.phone.value == '' || form.phone.value == '연락처를 적어주세요') {
			alert('상담받으실 전화 또는 이메일주소를 정확히 적어 주세요.');
			form.phone.focus();
			return false;
		}
		if (form.sa_date.value == '') {
			alert('상담을 원하시는 일자와 시간을 적어주세요.');
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
		<td>고 객 성 명</td>
		<td><input type=text name=name size=16 class=inputbox value='성명을 적어주세요' onfocus='box_reset(this)'></td>
	</tr>
	<tr>
		<td>고객연락처</td>
		<td><input type=text name=phone size=16 class=inputbox value='연락처를 적어주세요' onfocus='box_reset(this)'></td>
	</tr>
	<tr>
		<td>상담가능시간</td>
		<td><input type=text name=sa_date size=16 class=inputbox value='즉시 상담원함' onfocus='box_reset(this)'></td>
	<tr>
		<td colspan=2 align=right>
			<input type=image src='images/button.gif'>
		</td>
	</tr>
</form>
</table>