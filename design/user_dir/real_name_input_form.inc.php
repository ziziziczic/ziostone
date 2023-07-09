<script language='javascript1.2'>
<!--
function verify_submit_real_name(form) {
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
<table cellSpacing="1" cellPadding="5" width="600" border="0" bgcolor=cccccc>
  <tr>
    <td bgcolor=ffffff>
    <img height="21" src="design/images/tit_b01.gif"></td>
  </tr>
  <tr>
    <td bgcolor=f3f3f3>
		<font color=555555>열린마당은 보다 많은 사용자들의 원활한 서비스 이용과 온라인 상에서의 익명 사용자로 인한 피해 등을 방지하기 회원 ID에 대한 실명제를 시행하고 있습니다.<br><br>
      또한 사용자의 개인정보보호를 위해 사용자 여러분이 열린마당의 서비스를 이용함에 있어 온라인상에서 회사에 제공한 개인정보가 보호 받을 수 있도록 최선을 다하고 있습니다.<br><br>
		회원님의 정보는 동의 없이 공개되지 않으며, 개인정보 보호정책에 의해 보호받고 있습니다.<br>
		회원가입후 탈퇴를 원하시는 경우 <a href="javascript:window.open('tools/form_mail/send_mail_form.php','form_mail', 'top=100,left=300,width=450,height=430,resizable=0,status=0,scrollbars=0,menubar=0').focus()"><font color=blue><u>개인정보보호담당자</font></u></a> 에게 메일 주시면 즉시 처리해 드립니다.<br><br>
		개인정보 보호에 관한 문의는 본 홈페이지 <a href='insiter.php?design_file=492.php'><font color=blue><u>고객상담실</font></u></a> 이나 <a href="javascript:window.open('tools/form_mail/send_mail_form.php','form_mail', 'top=100,left=300,width=450,height=430,resizable=0,status=0,scrollbars=0,menubar=0').focus()"><font color=blue><u>개인정보보호담당자</font></u></a> 에게 문의 주시기 바랍니다.<br>
		열린마당은 더욱 깨끗한 인터넷 세상을 만들기 위해 노력 하겠습니다.<br><br>
		아래에 성명, 주민등록 번호를 기입하시면 실명확인후 간단히 열린마당의 가족이 될 수 있습니다.
　</td>
  </tr>
</table><br><br>

<table cellSpacing="1" cellPadding="5" width="550" bgColor="#f3f3f3" border="0" align=center>
<form name="form2" action="nc_coin_p.php" method="post" onsubmit="verify_submit_real_name(this);return false;">
<input type=hidden name=flag value=<?echo($_SERVER[HTTP_HOST])?>>
	<tr>
		<td align="middle" bgcolor=fefefe>
			<table cellSpacing="0" cellPadding="0" width="500" border="0" align='center'>
				<tr>
					<td><b>성명, 주민등록번호 입력</b>(아래의 회원약관을 읽고 동의하셔야 가입 가능 합니다.)<hr size=1 width=100%></td>
				</tr>
				<tr>
					<td>
						성명 <input style="MARGIN: 0px 20px 0px 10px; WIDTH: 65px" align="absMiddle" name="a1" size="20" class='design_text'>
						주민등록번호 <input style="MARGIN-LEFT: 10px;" maxLength="6" align="absMiddle" name="jumin_number_1" size="6" class='design_text'> - <input style="MARGIN-LEFT: 10px;" maxLength="7" align="absMiddle" name="jumin_number_2" size="7" class='design_text'>
						<input style="border: medium none; margin-left: 10px" type="image" src="design/images/btn_ok.gif" align="absMiddle" width="30" height="18">
					</td>
				</tr>
				<tr>
					<td height=50>
						아래의 약관을 읽었으며 가입약관에 동의합니다. <input type="checkbox" name='is_agree' value='Y'>
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