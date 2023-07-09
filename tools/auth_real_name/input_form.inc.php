<?
if ($_GET[user_level] != '') {
	$checked_7 = $checked_6 = $checked_5 = '';
	switch ($_GET[user_level]) {
		case '7' :
			$checked_7 = " checked";
		break;
		case '6' :
			$checked_6 = " checked";
		break;
		case '5' :
			$checked_5 = " checked";
		break;
	}

}

echo("
<script language='javascript1.2'>
<!--
function verify_submit_real_name(form) {
	if (radio_check(form, 'user_level', 'radio') == 0) {
		alert('회원 구분을 먼저 선택하세요');
		return false;
	}
	if (form.a1.value == '') {
		alert('성명을 입력하세요');
		form.a1.focus();
		return false;
	}
	if (form.jumin_number_1.value == '' || form.jumin_number_2.value == '') {
		alert('주민등록번호를 정확히 입력해 주세요');
		form.jumin_number_1.focus();
		return false;
	}
	if (form.is_agree.checked != true) {
		alert('약관을 읽어보신 후 동의 하셔야 가입 가능합니다.');
		return false;
	}
	form.submit();
}
//-->
</script>
<table cellSpacing='0' cellPadding='0' width='100%' border='0' align='center'>
	<form name='form2' action='{$root}nc_coin_p.php' method='post' onsubmit='verify_submit_real_name(this);return false;'>
	<input type='hidden' name='flag' value='{$_SERVER[HTTP_HOST]}'>
	<tr>
		<td><b>* 회원구분 선택<hr size=1 width=100%></td>
	</tr>
	<tr>
		<td>
			<input type='radio' name=user_level value='7' id='radio_user_level_7'{$checked_7}><label for='radio_user_level_7'>개인, 차주회원 (지입차 구입 하려는 분, 지입차량차주, 구직을 원하는 개인)</label><br>
			<input type='radio' name=user_level value='6' id='radio_user_level_6'{$checked_6}><label for='radio_user_level_6'>기업, 화주회원 (물류견적상담, 지입차를 쓰려는 기업)</label><br>
			<input type='radio' name=user_level value='5' id='radio_user_level_5'{$checked_5}><label for='radio_user_level_5'>운수회사, 지입매니저 (운수회사, 지입매니저업에 종사하는 기업 또는 개인)</label>
		</td>
	</tr>
	<tr><td height=20></td></tr>
	<tr>
		<td><b>* 성명, 주민등록번호 입력</b>(아래의 회원약관을 읽고 동의하셔야 가입 가능 합니다.)<hr size=1 width=100%></td>
	</tr>
	<tr>
		<td>
			성명 <input style='margin: 0px 20px 0px 10px; width: 65px' align='absmiddle' name='a1' size='20' class='designer_text'>
			주민등록번호 <input style='margin-left: 10px;' maxlength='6' align='absmiddle' name='jumin_number_1' size='6' class='designer_text'> - <input style='margin-left: 10px;' maxlength='7' align='absmiddle' name='jumin_number_2' size='7' class='designer_text'>
			<input style='border: medium none; margin-left: 10px' type='image' src='designer/images/btn_ok.gif' align='absmiddle' width='30' height='18'>
		</td>
	</tr>
	<tr>
		<td height=50>
			아래의 약관을 읽었으며 가입약관에 동의합니다. <input type='checkbox' name='is_agree' value='y'>
		</td>
	</tr>
	</form>
</table>
");
?>